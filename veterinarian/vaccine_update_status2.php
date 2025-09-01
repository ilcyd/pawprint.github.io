<?php
include 'includes/session.php';

// Check if vaccine_id and status are provided via POST
if (isset($_POST['vaccine_id']) && isset($_POST['status'])) {
 $vaccineId = $_POST['vaccine_id'];
 $status = $_POST['status'];

 // Prepare SQL statement to update vaccination status
 $sql = "UPDATE vaccination SET status2 = ? WHERE id = ? AND delete_flag = 0";

 $stmt = $conn->prepare($sql);
 $stmt->bind_param("ii", $status, $vaccineId);

 if ($stmt->execute()) {
  echo json_encode(['status' => 'success']);
 } else {
  echo json_encode(['status' => 'error']);
 }

 // Close statement and connection
 $stmt->close();
 $conn->close();
} else {
 echo json_encode(['status' => 'error']);
}
