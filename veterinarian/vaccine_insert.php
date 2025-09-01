<?php
include 'includes/session.php';
include 'includes/header.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize an array to hold error messages
    $errors = [];

    // Get and sanitize the input data
    $vaccine_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $owner_id = isset($_POST['owner_id']) ? intval($_POST['owner_id']) : 0;
    $pet_id = isset($_POST['pet_id']) ? intval($_POST['pet_id']) : 0;
    $vet_id = isset($_POST['vet_id']) ? intval($_POST['vet_id']) : 0;
    $vaccine_type = isset($_POST['vaccine_id']) ? htmlspecialchars(trim($_POST['vaccine_id'])) : ''; 
    $vaccine_schedule = isset($_POST['vaccine_schedule']) ? htmlspecialchars(trim($_POST['vaccine_schedule'])) : '';
    $notes = isset($_POST['notes']) ? htmlspecialchars(trim($_POST['notes'])) : '';

    // Validate the input data
    if ($owner_id <= 0) {
        $errors[] = "Owner ID is required.";
    }
    if ($pet_id <= 0) {
        $errors[] = "Pet ID is required.";
    }
    if ($vet_id <= 0) {
        $errors[] = "Veterinarian ID is required.";
    }
    if (empty($vaccine_type)) {
        $errors[] = "Vaccine type is required.";
    }

    // If there are no errors, proceed to insert the record
    if (empty($errors)) {
        // Prepare an SQL statement to insert the vaccination record
        $sql = "INSERT INTO vaccine_records (owner_id, pet_id, vet_id, type, date_taken, notes, date_created) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        if ($stmt = $conn->prepare($sql)) {
            $date_taken = date('Y-m-d'); // Use current date for date_taken
            $stmt->bind_param("iiiiss", $owner_id, $pet_id, $vet_id, $vaccine_type, $date_taken, $notes);

            // Execute the statement
            if ($stmt->execute()) {
                // Get the ID of the inserted record to delete from vaccination table

                // Prepare the delete statement
                $delete_sql = "DELETE FROM vaccination WHERE id = ?";
                if ($delete_stmt = $conn->prepare($delete_sql)) {
                    $delete_stmt->bind_param("i", $vaccine_id);
                    $delete_stmt->execute();
                    $delete_stmt->close();
                } else {
                    echo "Error preparing delete statement: " . $conn->error;
                }

                // Redirect or display a success message
                echo "<script>alert('Vaccination record inserted and old record deleted successfully!'); window.location.href='pet_records.php?pet_id=$pet_id&owner_id=$owner_id';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Display all error messages
        echo "<script>alert('".implode("\\n", $errors)."');</script>";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
