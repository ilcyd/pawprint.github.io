<?php
// Include your database configuration file
include ('includes/session.php');

// Check if the species_id is set and not empty
if (isset($_POST['species_id']) && !empty($_POST['species_id'])) {
 $speciesId = $_POST['species_id'];

 // Fetch breed data from the database based on the selected species
 $query = "SELECT * FROM breeds WHERE species_id = $speciesId";
 $result = mysqli_query($conn, $query);

 // Check if there are any breeds for the selected species
 if (mysqli_num_rows($result) > 0) {
  // Loop through each row and create an option for each breed
  while ($row = mysqli_fetch_assoc($result)) {
   echo '<option value="' . $row['breed_id'] . '">' . $row['breed_name'] . '</option>';
  }
 } else {
  // If no breeds found for the selected species, display a default option
  echo '<option value="">No Breeds Found</option>';
 }
} else {
 // If species_id is not set or empty, display a default option
 echo '<option value="">Select Species First</option>';
}

// Close database connection
?>