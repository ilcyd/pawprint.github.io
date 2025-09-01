<?php
include 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawPrint</title>
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">

</head>

<body>

    <?php include 'includes/scripts.php'; ?>
</body>

</html>
<?php
// Function to generate appointment ID
function generateAppointmentID($conn)
{
    // Get today's date
    $currentDate = date('Ymd');

    // Query to get the latest appointment ID for today
    $query = "SELECT MAX(appointment_id) AS max_id FROM appointments WHERE appointment_id LIKE '$currentDate%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $maxID = $row['max_id'];

    // Extract the sequence number and increment
    if ($maxID) {
        $lastSerial = substr($maxID, -4); // Extract last 4 characters (serial part)
        $nextSerial = intval($lastSerial) + 1; // Increment the serial number
    } else {
        $nextSerial = 1; // Start from 1 if no appointments exist for today
    }

    // Format the new appointment ID
    $formattedSerial = sprintf('%04d', $nextSerial); // Pad with leading zeros
    $newAppointmentID = $currentDate . '-' . $formattedSerial;

    return $newAppointmentID;
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $owner_id = $user['id'];
    $pet_id = mysqli_real_escape_string($conn, $_POST['pet']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $veterinarian_id = mysqli_real_escape_string($conn, $_POST['veterinarian']);
    $vaccine_type = $_POST['vaccine_type']; // Array of selected service_ids
    $service_ids = $_POST['service_id']; // Array of selected service_ids

    

    // Convert service_ids array to comma-separated string
    $service_ids_str = implode(',', $service_ids);

    // Generate appointment ID
    $appointment_id = generateAppointmentID($conn);

    // Insert appointment into database
    $insert_query = "INSERT INTO appointments (appointment_id, service_id, vet_id, owner_id, pet_id, date ,vaccine_type)
                     VALUES ('$appointment_id', '$service_ids_str', '$veterinarian_id', '$owner_id', '$pet_id', '$appointment_date', '$vaccine_type')";

    if (mysqli_query($conn, $insert_query)) {
        // Insert notification
        $notification_message = "An Appointment has been made.";
        $insert_notification_query = "INSERT INTO notifications (user_id, owner_id, message) VALUES ('$veterinarian_id','$owner_id', '$notification_message')";

        if (mysqli_query($conn, $insert_notification_query)) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success...',
                        text: 'Appointment is set wait for the approval of the Veterinarian',
                    }).then(function() {
                        window.location.href = 'appointments.php';
                    });
                    </script>";
        } else {
            echo "Error inserting notification: " . mysqli_error($conn);
        }
    } else {
        // Handle insertion error (if any)
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle cases where the form was not submitted properly
    echo "Error: Form submission method not valid.";
}
?>