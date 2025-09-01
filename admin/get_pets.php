<?php
// Include necessary files
include 'includes/session.php';
// Check if user ID is set in the POST request
if (isset($_POST["userId"])) {
 // Sanitize the user ID
 $userId = mysqli_real_escape_string($conn, $_POST["userId"]);

 // Query to fetch pets owned by the selected user
 $petQuery = mysqli_query($conn, "SELECT pet_id, pet_name FROM pets WHERE owner_id = '$userId' AND delete_flag=0");

 // Initialize an empty array to store pet options
 $petOptions = array();

 // Loop through the result set and create option elements
 while ($petRow = mysqli_fetch_assoc($petQuery)) {
  $petOptions[] = '<option value="' . $petRow['pet_id'] . '">' . $petRow['pet_name'] . '</option>';
 }

 // Output the pet options as HTML
 echo '<option value="">Select Pet</option>' . implode('', $petOptions);
} else {
 // If user ID is not set, output an empty option
 echo '<option value="">No Pets Found</option>';
}
?>