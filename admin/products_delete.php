<?php
// Include session file to access session variables and database connection
include 'includes/session.php';

// Check if the form is submitted
if (isset($_POST['delete'])) {
    // Get the product ID from the form
    $prod_id = $_POST['id'];

    // Update the delete_flag in the database
    $sql = "UPDATE products SET delete_flag = 1 WHERE id = $prod_id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // If the update is successful, redirect to a page or display a success message
        header("Location: products.php?success=Product deleted successfully");
        exit();
    } else {
        // If there is an error, redirect to a page or display an error message
        header("Location: products.php?error=Error deleting product: " . mysqli_error($conn));
        exit();
    }
} else {
    // If the form is not submitted, redirect to a page or display an error message
    header("Location: products.php?error=Form submission error");
    exit();
}