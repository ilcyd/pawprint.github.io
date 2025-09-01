<?php
// Include your database configuration file
include ('includes/session.php');

// Fetch species data from the database
$query = "SELECT * FROM services";
$result = mysqli_query($conn, $query);

// Check if there are any species
if (mysqli_num_rows($result) > 0) {
 // Loop through each row and create an option for each species
 while ($row = mysqli_fetch_assoc($result)) {
  echo '<option value="' . $row['service_id'] . '">' . $row['service_name'] . ' (₱' . $row['price'] . ')</option>';
 }
} else {
 // If no species found, display a default option
 echo '<option value="">No Species Found</option>';
}
