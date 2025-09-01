<?php
// Include database connection or session handling files as needed
include 'includes/session.php';
// Check if service_id is provided via POST
if (isset($_POST['service_id'])) {
 $service_id = $_POST['service_id'];

 // Prepare SQL statement to fetch service details
 $sql = "SELECT * FROM services WHERE service_id = ?";
 $stmt = mysqli_prepare($conn, $sql);

 // Bind the parameter
 mysqli_stmt_bind_param($stmt, "i", $service_id);

 // Execute the statement
 mysqli_stmt_execute($stmt);

 // Get result
 $result = mysqli_stmt_get_result($stmt);

 if ($result && mysqli_num_rows($result) > 0) {
  // Fetch service details
  $row = mysqli_fetch_assoc($result);

  // Prepare JSON response
  $response = array(
   'id' => $row['service_id'],
   'name' => $row['service_name'],
   'price' => $row['price']
   // Add more fields as needed
  );

  // Output JSON
  header('Content-Type: application/json');
  echo json_encode($response);
 } else {
  // Service not found
  echo json_encode(array('error' => 'Service not found'));
 }

} else {
 // If service_id is not provided
 echo json_encode(array('error' => 'Invalid request'));
}

// Close database connection