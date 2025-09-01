<?php
// Include your database configuration file
include ('includes/session.php');
$userid = $user['id'];
// Fetch species data from the database
$query = "SELECT * FROM pets WHERE owner_id = $userid AND delete_flag = 0";
$result = mysqli_query($conn, $query);

// Check if there are any species
if (mysqli_num_rows($result) > 0) {
 // Loop through each row and create an option for each species
 while ($row = mysqli_fetch_assoc($result)) {
  echo '<option value="' . $row['pet_id'] . '">' . $row['pet_name'] . '</option>';
 }
} else {
 // If no species found, display a default option
 echo '<option value="">No Species Found</option>';
}
