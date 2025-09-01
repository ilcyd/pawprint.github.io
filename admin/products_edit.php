<?php
// Include session file to access session variables and database connection
include 'includes/session.php';

// Check if the form is submitted
if (isset($_POST['edit'])) {
    // Get the product ID from the form
    $prod_id = $_POST['id'];

    // Get other form data
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Update the product in the database
    $sql = "UPDATE products SET name = '$name', category_id = '$category', price = '$price', description = '$description' WHERE id = $prod_id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // If the update is successful, redirect to a page or display a success message
        header("Location: products.php?success=Product updated successfully");
        exit();
    } else {
        // If there is an error, redirect to a page or display an error message
        header("Location: products.php?error=Error updating product: " . mysqli_error($conn));
        exit();
    }
} else {
    // If the form is not submitted, redirect to a page or display an error message
    header("Location: products.php?error=Form submission error");
    exit();
}