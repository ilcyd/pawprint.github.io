<?php
// Include necessary files
include 'includes/session.php';

// Check if appointment ID is provided
if (isset($_POST['appointment_id'])) {
    $appointmentId = $_POST['appointment_id'];

    // Update the appointment status to 'Done' (status 2)
    $sql = "UPDATE appointments SET status = 2 WHERE id = ? AND delete_flag = 0";

    // Prepare statement and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointmentId);

    if ($stmt->execute()) {
        // Return success response
        echo json_encode(['status' => 'success']);
    } else {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => 'Failed to mark the appointment as done.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No appointment ID provided.']);
}
?>
