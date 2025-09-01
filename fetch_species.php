<?php
// Include your database configuration file
include ('includes/session.php');

// Fetch species data from the database
$query = "SELECT * FROM species";
$result = mysqli_query($conn, $query);

// Check if there are any species
if (mysqli_num_rows($result) > 0) {
 // Loop through each row and create an option for each species
 while ($row = mysqli_fetch_assoc($result)) {
  echo '<option value="' . $row['species_id'] . '">' . $row['species_name'] . '</option>';
 }
} else {
 // If no species found, display a default option
 echo '<option value="">No Species Found</option>';
}

