<?php
include 'includes/session.php';

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $sql = "INSERT INTO subcategory (name, category_id) VALUES ('$name', '$category_id')";
    if(mysqli_query($conn, $sql)){
        $_SESSION['success'] = 'Subcategory added successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong in adding subcategory';
    }
}

header('location: subcategory.php');
?>
