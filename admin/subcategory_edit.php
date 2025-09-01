<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $sql = "UPDATE subcategory SET name = '$name', category_id = '$category_id' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Subcategory updated successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong in updating subcategory';
    }
}

header('location: subcategory.php');