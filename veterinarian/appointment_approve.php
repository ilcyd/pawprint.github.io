<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
    $appointmentId = mysqli_real_escape_string($conn, $_POST['id']);

    // Fetch service_id, owner_id, and pet_id from the appointments table
    $serviceQuery = "SELECT service_id, owner_id, pet_id, date, vaccine_type, vet_id FROM appointments WHERE id = ?";

    if ($serviceStmt = $conn->prepare($serviceQuery)) {
        $serviceStmt->bind_param("i", $appointmentId);
        $serviceStmt->execute();
        $serviceStmt->store_result();

        if ($serviceStmt->num_rows > 0) {
            $serviceStmt->bind_result($serviceIds, $ownerId, $petId, $date, $vaccine_type, $vetId);
            $serviceStmt->fetch();

            // Split service_ids into an array
            $serviceIdsArray = explode(',', $serviceIds);
            $insertedSuccessfully = true; // Track if all inserts were successful

            foreach ($serviceIdsArray as $serviceId) {
                $serviceId = trim($serviceId);
                $insertQuery = '';
                
                // Insert into transactions table for all service types
                $transactionId = generateTransactionId($conn); // A function to generate a new transaction ID

                $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, owner_id, pet_id, service_id, status) VALUES (?, ?, ?, ?, ?)");
                $status = 0;
                $stmt->bind_param("siiii", $transactionId, $ownerId, $petId, $serviceId, $status);
                if (!$stmt->execute()) {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to insert transaction.']);
                    exit;
                }

                // If service is Consultation (ID = 1) or Vaccination (ID = 2), insert into the respective table
                if ($serviceId == '1') { // Consultation
                    $insertQuery = "INSERT INTO consultation (service_id, owner_id, pet_id, vet_id, schedule, type) VALUES (?, ?, ?, ?, ?, ?)";
                } elseif ($serviceId == '2') { // Vaccination
                    $insertQuery = "INSERT INTO vaccination (service_id, owner_id, pet_id, vet_id, schedule, type) VALUES (?, ?, ?, ?, ?, ?)";
                }
                
                if ($insertQuery) {
                    // Insert into consultation or vaccination table
                    if ($insertStmt = $conn->prepare($insertQuery)) {
                        $insertStmt->bind_param("iiiisi", $serviceId, $ownerId, $petId, $vetId, $date, $vaccine_type);
                        if (!$insertStmt->execute()) {
                            $insertedSuccessfully = false; // Track failure
                        }
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare insert statement.']);
                        exit;
                    }
                }

                // Update appointment status to 1 (approved)
                $updateQuery = "UPDATE appointments SET status = 1 WHERE id = ?";
                if ($updateStmt = $conn->prepare($updateQuery)) {
                    $updateStmt->bind_param("i", $appointmentId);
                    if (!$updateStmt->execute()) {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to update appointment status.']);
                        exit;
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare update statement.']);
                    exit;
                }

                // Add notification for the client
                $notificationMessage = "Your appointment has been approved.";
                $notificationQuery = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
                if ($notificationStmt = $conn->prepare($notificationQuery)) {
                    $notificationStmt->bind_param("is", $ownerId, $notificationMessage);
                    if (!$notificationStmt->execute()) {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to insert notification.']);
                        exit;
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare notification statement.']);
                    exit;
                }
            }

            // Redirect to category.php if all inserts were successful
            if ($insertedSuccessfully) {
                header("Location: category.php");
                exit; // Ensure no further code is executed
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Some inserts failed.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No service found for this appointment.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare service query.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No ID provided.']);
}

// Helper function to generate the transaction ID
function generateTransactionId($conn) {
    $lastInsertedIdQuery = mysqli_query($conn, "SELECT transaction_id FROM transactions ORDER BY transaction_id DESC LIMIT 1");
    if ($lastInsertedIdQuery) {
        $lastInsertedIdRow = mysqli_fetch_assoc($lastInsertedIdQuery);
        $lastInsertedId = ($lastInsertedIdRow && isset($lastInsertedIdRow['transaction_id'])) ? $lastInsertedIdRow['transaction_id'] : 0;
        $last4Digits = substr($lastInsertedId, -4);
        $newIdNumber = intval($last4Digits) + 1; // Convert to integer for proper increment
        $currentYear = date("Y");
        $currentMonth = date("m");
        $currentDay = date("d");
        return $currentYear . $currentMonth . $currentDay . '-' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch last inserted ID.']);
        exit;
    }
}
?>
