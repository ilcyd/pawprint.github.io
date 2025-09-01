<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $slug = strtolower($name);
    $category_id = $_POST['category_id'];
    $subcategory_id = $_POST['subcategory_id'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $expiration_date = $_POST['expiration_date'];

    // Handle file upload
    $filename = $_FILES['photo']['name'];
    $new_filename = '';

    if (!empty($filename)) {
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed_exts)) {
            $new_filename = $slug . '.' . $ext;
            // Move uploaded photo to the destination folder
            if (move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $new_filename)) {
                // File uploaded successfully
            } else {
                $_SESSION['error'] = 'Failed to upload file.';
                header('location: products.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Invalid file type. Only jpg, jpeg, png, gif files are allowed.';
            header('location: products.php');
            exit();
        }
    }

    // Prepare SQL statement
    $sql = "INSERT INTO products (category_id, subcategory_id, name, description, slug, price, photo, stock, expiry_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iisssssis", $category_id, $subcategory_id, $name, $description, $slug, $price, $new_filename, $quantity, $expiration_date);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Product added successfully';
        } else {
            $_SESSION['error'] = 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Error preparing statement: ' . $conn->error;
    }

    $conn->close();
} else {
    $_SESSION['error'] = 'Fill up product form first';
}

header('location: products.php');
