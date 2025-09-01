<?php
 include ('includes/session.php');
// Check if the user ID is provided and the form is submitted
if(isset($_POST['approve']) && isset($_POST['id'])) {
    // Get the user ID from the form submission
    $user_id = $_POST['id'];
    
    // Update the user status to approved (assuming `status` is a column in your `users` table)
    $sql = "UPDATE users SET status = 1 WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    
    // Execute the SQL query (you'll need to have your database connection established)
    // Example:
    // mysqli_query($conn, $sql);
    
    // Redirect back to the appropriate page after processing
    header("Location: users_registered.php");
    exit();
} else {
    // Handle error if user ID is not provided or form is not submitted
    // Redirect or show an error message
}
?>
