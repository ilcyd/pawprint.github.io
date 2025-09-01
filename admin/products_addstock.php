<?php
// Include your database connection file
include 'includes/session.php';


// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    // Retrieve and sanitize form data
    $prodId = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $newPrice = isset($_POST['new_price']) ? intval($_POST['new_price']) : 0;
    $newStock = isset($_POST['new_stock']) ? intval($_POST['new_stock']) : 0;
    $newExpiryDate = isset($_POST['expiry_date']) ? $_POST['expiry_date'] : ''; // Corrected input name

    // Validate data (basic validation)
    if ($prodId <= 0 || $newStock < 0 || $newPrice < 0 || empty($newExpiryDate)) {
        $_SESSION['message'] = 'Invalid input data.';
        header('Location: products.php'); // Redirect to the products page
        exit;
    }

    // Start a transaction
    $conn->begin_transaction();
    try {
        // Update the new price, stock, and expiry date
        $updateStockQuery = "UPDATE products SET new_price = ?, new_stock = ?, new_exp_date = ? WHERE id = ?";
        $stmt = $conn->prepare($updateStockQuery);
        if ($stmt === false) {
            throw new Exception('Failed to prepare update statement: ' . $conn->error);
        }

        // Bind parameters (corrected order and data types)
        $stmt->bind_param('iiss', $newPrice, $newStock, $newExpiryDate, $prodId);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception('Failed to update stock and expiry date: ' . $stmt->error);
        }

        // Commit the transaction
        $conn->commit();
        $_SESSION['message'] = 'New stock added and expiry date updated successfully.';
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }

    // Close statement
    $stmt->close();
    // Close the connection (optional if using a persistent connection)
    $conn->close();

    // Redirect back to products page with a message
    header('Location: products.php');
    exit;
} else {
    // If accessed without POST request, redirect to products page
    header('Location: products.php');
    exit;
}
