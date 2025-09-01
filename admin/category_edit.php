<?php
include ('includes/session.php');

// Check if the user ID is provided and the form is submitted
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $cat_slug = strtolower($name);
    $sql = "UPDATE category SET name = '$name', cat_slug = '$cat_slug' WHERE id = '$id'";
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