<?php
include 'includes/session.php';

$output = array('error' => false);

$id = $_POST['id'];
$quantity = $_POST['quantity'];

// Retrieve product stock from the products table
$stmt = $conn->prepare("SELECT stock FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Check if the product exists and retrieve its stock
if ($product) {
    $available_stock = $product['stock'];

    // Check if the requested quantity exceeds available stock
    if ($quantity <= $available_stock) {
        if (isset($_SESSION['user'])) {
            // User is logged in, handle cart in the database

            // Prepare statement to check if the product is already in the cart for the logged-in user
            $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=? AND product_id=?");
            $stmt->bind_param("ii", $user['id'], $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Check if the product is in the cart
            if($quantity>=1){
                if ($row['numrows'] < 1) {
                    // Product is not in the cart, insert it
                    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $user['id'], $id, $quantity);
                    if ($stmt->execute()) {
                        $output['message'] = 'Item added to cart';
                    } else {
                        $output['error'] = true;
                        $output['message'] = 'Error adding item to cart';
                    }
                } else {
                    // Product is already in the cart, update the quantity
                    $new_quantity = $row['quantity'] + $quantity;
                    // Limit the new quantity to the available stock
                    $new_quantity = min($new_quantity, $available_stock);
                    $stmt = $conn->prepare("UPDATE cart SET quantity=? WHERE user_id=? AND product_id=?");
                    $stmt->bind_param("iii", $new_quantity, $user['id'], $id);
                    if ($stmt->execute()) {
                        $output['message'] = 'Cart updated with new quantity';
                    } else {
                        $output['error'] = true;
                        $output['message'] = 'Error updating cart';
                    }
                }
            }else{
                $output['error'] = true;
                $output['message'] = 'Error adding item to cart';
            }
            
        } else {
            // User is not logged in, handle cart in the session

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

            if ($available_stock > 0) {
                $found = false;
                foreach ($_SESSION['cart'] as &$row) {
                    if ($row['productid'] == $id) {
                        // Limit the quantity to the available stock
                        $new_quantity = min($row['quantity'] + $quantity, $available_stock);
                        $row['quantity'] = $new_quantity;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $data['productid'] = $id;
                    // Limit the quantity to the available stock
                    $data['quantity'] = min($quantity, $available_stock);
                    if (array_push($_SESSION['cart'], $data)) {
                        $output['message'] = 'Item added to cart';
                    } else {
                        $output['error'] = true;
                        $output['message'] = 'Error adding item to cart';
                    }
                } else {
                    $output['message'] = 'Cart updated with new quantity';
                }
            } else {
                // Product is out of stock, cannot be added to cart
                $output['error'] = true;
                $output['message'] = 'Product is out of stock';
            }
        }
    } else {
        // Requested quantity exceeds available stock
        $output['error'] = true;
        $output['message'] = 'Requested quantity exceeds available stock';
    }
} else {
    // Product not found
    $output['error'] = true;
    $output['message'] = 'Product not found';
}

// Output the JSON response
echo json_encode($output);