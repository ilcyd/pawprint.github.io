<?php
// Include your database configuration file
include ('includes/session.php');

// Fetch species data from the database
$query = "SELECT * FROM users WHERE type='1' AND status='1'";
$result = mysqli_query($conn, $query);

// Check if there are any species
if (mysqli_num_rows($result) > 0) {
 // Loop through each row and create an option for each species
 while ($row = mysqli_fetch_assoc($result)) {
  echo '<option value="' . $row['id'] . '">Dr. ' . strtoupper(substr($row['firstname'], 0, 1)) . '. ' . $row['lastname'] . '</option>';
 }
} else {
 // If no species found, display a default option
 echo '<option value="">No Species Found</option>';
}
?>