<?php
// Include necessary files
include ('includes/session.php');

// Check if pet_id is set and not empty
if (isset($_POST['pet_id']) && !empty($_POST['pet_id'])) {
 $pet_id = $_POST['pet_id'];

 // Prepare delete query
 $delete_query = "UPDATE pets SET delete_flag = 1 WHERE pet_id = ?";
 $stmt = $conn->prepare($delete_query);
 $stmt->bind_param("i", $pet_id);

 // Execute delete query
 if ($stmt->execute()) {
  // Return success response
  echo json_encode(['status' => 'success']);
 } else {
  // Return error response
  echo json_encode(['status' => 'error', 'message' => 'Failed to delete pet: ' . $conn->error]);
 }

 // Close statement and database connection
} else {
 // Handle case where pet_id is not set or empty
 echo json_encode(['status' => 'error', 'message' => 'Pet ID not provided']);
}
