<?php
include ('includes/session.php');

header('Content-Type: application/json'); // Ensure the response type is JSON

if (isset($_POST['appointment_id'])) {
 $appointment_id = $_POST['appointment_id'];

 // SQL query to mark the appointment as cancelled
 $delete_query = "
        UPDATE appointments
        SET delete_flag = 1
        WHERE id = ?
          AND delete_flag = 0
    ";

 if ($stmt = $conn->prepare($delete_query)) {
  $stmt->bind_param("i", $appointment_id);

  if ($stmt->execute()) {
   if ($stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success']);
   } else {
    echo json_encode(['status' => 'error', 'message' => 'Appointment not found or already cancelled']);
   }
  } else {
   echo json_encode(['status' => 'error', 'message' => 'Database query execution failed: ' . $stmt->error]);
  }

  $stmt->close();
 } else {
  echo json_encode(['status' => 'error', 'message' => 'Statement preparation failed: ' . $conn->error]);
 }

 $conn->close();
} else {
 echo json_encode(['status' => 'error', 'message' => 'No appointment_id provided']);
}
?>