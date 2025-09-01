<?php
include 'includes/session.php';
// Check if service_ids is sent via POST
if (isset($_POST['service_ids'])) {
 $serviceIds = $_POST['service_ids'];

 // Example: Querying vaccine types from a hypothetical 'vaccine_types' table
 $query = "SELECT * FROM surgery WHERE service_id IN (" . implode(',', array_map('intval', $serviceIds)) . ")";
 $result = mysqli_query($conn, $query);

 if ($result && mysqli_num_rows($result) > 0) {
  // Build options for vaccine types dropdown
  $options = '<option value="">Select Surgery Type</option>';
  while ($row = mysqli_fetch_assoc($result)) {
   $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '(₱' . $row['price'] . ')</option>';
  }
  echo $options;
 } else {
  echo '<option value="">No Vaccine Types available</option>';
 }
} else {
 echo '<option value="">No service IDs received</option>';
}

// Close the database connection if needed
mysqli_close($conn);
?>