<?php
include 'includes/session.php';

if(isset($_POST['add'])){
    // Retrieve form data
    $name = $_POST['name'];
    $slug = strtolower($name);
    $category_id = $_POST['category_id'];
    $subcategory_id = $_POST['subcategory_id'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $expiration_date = $_POST['expiration_date'];
    $filename = $_FILES['photo']['name'];

    // Move uploaded photo to the destination folder
    $new_filename = '';
    if(!empty($filename)){
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $new_filename = $slug.'.'.$ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);    
    }

    // Prepare SQL statement
    $sql = "INSERT INTO products (category_id, subcategory_id, name, description, slug, price, photo, stock, expiry_date) 
            VALUES ('$category_id', '$subcategory_id', '$name', '$description', '$slug', '$price', '$new_filename', '$quantity', '$expiration_date')";

    if(mysqli_query($conn, $sql)){
        $_SESSION['success'] = 'Product added successfully';
    } else {
        $_SESSION['error'] = 'Error: ' . $sql . '<br>' . mysqli_error($conn);
    }

    mysqli_close($conn);
}
else{
    $_SESSION['error'] = 'Fill up product form first';
}

header('location: products.php');
?>
