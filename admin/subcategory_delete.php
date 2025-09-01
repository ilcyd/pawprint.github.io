<?php
// Include session file to access session variables and database connection
include 'includes/session.php';

// Check if the delete button is clicked
if (isset($_POST['delete'])) {
    // Get the subcategory ID from the form
    $id = $_POST['id'];

    // Update the delete_flag in the database instead of deleting the record
    $sql = "UPDATE subcategory SET delete_flag = 1 WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // If update is successful, set a success message in session
        $_SESSION['success'] = 'Subcategory deleted successfully';
    } else {
        // If there's an error, set an error message in session
        $_SESSION['error'] = 'Something went wrong in deleting subcategory';
    }
}

// Redirect back to the subcategory page
header('location: subcategory.php');