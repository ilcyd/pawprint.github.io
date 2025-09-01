<?php
include ('includes/session.php');
// Check if the user ID is provided and the form is submitted
if (isset($_POST['add'])) {
    $name = $_POST['name'];

    $sql = "SELECT * FROM category WHERE name = '$name'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $_SESSION['error'] = 'Category already exists';
    } else {
        $cat_slug = strtolower($name);
        $sql = "INSERT INTO category (name, cat_slug) VALUES ('$name', '$cat_slug')";
        $result = mysqli_query($conn, $sql);
        header("Location: category.php");
        exit();

    }
} else {
    // Handle error if user ID is not provided or form is not submitted
    // Redirect or show an error message
}