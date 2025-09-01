<?php
// Include the session file and database connection
include 'includes/session.php';

// Check if the product ID is set in the POST request
if (isset($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $product_id = mysqli_real_escape_string($conn, $_POST['id']);

    // Initialize an array to store the product details
    $response = array();

    // Query to select product details
    $sql = "SELECT p.*, c.name AS category_name, sc.name AS subcategory_name
            FROM products p
            LEFT JOIN category c ON p.category_id = c.id
            LEFT JOIN subcategory sc ON p.subcategory_id = sc.id
            WHERE p.id = $product_id"; // Select the product with the given ID

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Check if a product was found with the given ID
        if (mysqli_num_rows($result) == 1) {
            // Fetch the product details
            $row = mysqli_fetch_assoc($result);

            // Store the product details in the response array
            $response['prodid'] = $row['id'];
            $response['prodname'] = $row['name'];
            $response['category_id'] = $row['category_id'];
            $response['catname'] = $row['category_name'];
            $response['subcategory_id'] = $row['subcategory_id'];
            $response['subcatname'] = $row['subcategory_name'];
            $response['price'] = $row['price'];
            $response['description'] = $row['description'];

            // Encode the response array as JSON and output it
            echo json_encode($response);
        } else {
            // No product found with the given ID
            echo json_encode(array('error' => 'Product not found'));
        }
    } else {
        // Error executing the query
        echo json_encode(array('error' => 'Error fetching product details'));
    }
} else {
    // No product ID provided in the request
    echo json_encode(array('error' => 'Product ID not provided'));
}