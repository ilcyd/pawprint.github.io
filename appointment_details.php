<?php
include ('includes/session.php');

header('Content-Type: application/json'); // Ensure the response type is JSON

if (isset($_POST['appointment_id'])) {
 $appointment_id = $_POST['appointment_id'];

 // SQL query to fetch appointment details and service names
 $details_query = "
        SELECT a.*, 
               CONCAT(u.firstname, ' ', u.middlename, ' ', u.lastname) AS owner_name, 
               p.pet_name, 
               GROUP_CONCAT(s.service_name ORDER BY s.service_name ASC SEPARATOR ', ') AS service_names
        FROM appointments a
        JOIN pets p ON a.pet_id = p.pet_id
        JOIN users u ON a.owner_id = u.id
        JOIN services s ON FIND_IN_SET(s.service_id, a.service_id)
        WHERE a.id = ? 
          AND a.delete_flag = 0
        GROUP BY a.id
    ";

 if ($stmt = $conn->prepare($details_query)) {
  $stmt->bind_param("i", $appointment_id);

  if ($stmt->execute()) {
   $result = $stmt->get_result();
   if ($row = $result->fetch_assoc()) {
    echo json_encode(['status' => 'success', 'data' => $row]);
   } else {
    echo json_encode(['status' => 'error', 'message' => 'No details found']);
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