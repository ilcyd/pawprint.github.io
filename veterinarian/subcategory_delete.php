<?php
include 'includes/session.php';

if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM subcategory WHERE id = '$id'";
    if(mysqli_query($conn, $sql)){
        $_SESSION['success'] = 'Subcategory deleted successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong in deleting subcategory';
    }
}

header('location: subcategory.php');
?>
