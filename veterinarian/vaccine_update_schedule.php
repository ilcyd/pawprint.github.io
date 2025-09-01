<?php
include 'includes/session.php';

// Check if vaccine_id, new_schedule, and next_schedule are provided via POST
if (isset($_POST['vaccine_id'], $_POST['new_schedule'], $_POST['next_schedule'])) {
 $vaccineId = $_POST['vaccine_id'];
 $newSchedule = $_POST['new_schedule'];
 $nextSchedule = $_POST['next_schedule'];

 // Prepare SQL statement to update vaccination schedule
 $sql = "UPDATE vaccination SET schedule = ?, next_schedule = ? WHERE id = ?";

 $stmt = $conn->prepare($sql);
 $stmt->bind_param("ssi", $newSchedule, $nextSchedule, $vaccineId);

 if ($stmt->execute()) {
  // Return success response if update was successful
  echo json_encode(['status' => 'success']);
 } else {
  // Return error response if update failed
  echo json_encode(['status' => 'error']);
 }

 // Close statement and connection
 $stmt->close();
 $conn->close();
} else {
 // Return error response if required parameters are not provided
 echo json_encode(['status' => 'error', 'message' => 'Invalid request. Please provide vaccine_id, new_schedule, and next_schedule.']);
}
?>