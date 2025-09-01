<?php
include ('includes/session.php');

// Check if the user ID is provided and the form is submitted
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "UPDATE category SET delete_flag = 1 WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: category.php");
        exit(); // Make sure to exit after redirecting
    } else {
        // Handle error if query execution fails
        // Redirect or show an error message
    }

} else {
    // Handle error if user ID is not provided or form is not submitted
    // Redirect or show an error message
}