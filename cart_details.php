<?php
include 'includes/session.php';

// Initialize the output variable
$output = '';

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Logged in user logic
    try {
        // Fetch cart items for the logged-in user
        $total = 0;

        // Check if there are items in the session cart
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $productid = $item['productid'];
                $quantity = $item['quantity'];

                // Insert the item into the database cart
                $stmt_insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)
                                                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
                $stmt_insert->bind_param("iii", $user['id'], $productid, $quantity);
                $stmt_insert->execute();
            }
            // Clear the session cart after transferring
            unset($_SESSION['cart']);
        }

        // Fetch updated cart items from the database
        $stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id = cart.product_id WHERE user_id = ?");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            // Limit quantity to available stock
            $quantity = min($row['quantity'], $row['stock']);

            // Update quantity in database if it exceeds available stock
            if ($quantity != $row['quantity']) {
                $stmt_update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
                $stmt_update->bind_param("ii", $quantity, $row['cartid']);
                $stmt_update->execute();
                // Update the quantity in the row variable for consistent display
                $row['quantity'] = $quantity;
            }

            $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';

            // Use discount_price if available
            $price = !empty($row['discount_price']) ? $row['discount_price'] : $row['price'];
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $output .= "
                <tr>
                    <td><button type='button' data-id='" . $row['cartid'] . "' class='btn btn-danger btn-flat cart_delete'><i class='fas fa-trash'></i></button></td>
                    <td><img src='" . $image . "' width='50px' height='50px'></td>
                    <td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>&#8369; " . number_format($price, 2) . "</td>
                    <td class='input-group'>
                        <span class='input-group-btn'>
                            <button type='button' class='btn btn-default btn-flat minus' data-id='" . $row['cartid'] . "'><i class='fa fa-minus'></i></button>
                        </span>
                        <input type='text' class='form-control' value='" . $quantity . "' id='qty_" . $row['cartid'] . "'>
                        <span class='input-group-btn'>
                            <button type='button' class='btn btn-default btn-flat add' data-id='" . $row['cartid'] . "'><i class='fa fa-plus'></i></button>
                        </span>
                    </td>
                    <td>&#8369; " . number_format($subtotal, 2) . "</td>
                </tr>
            ";
        }
        $output .= "
            <tr>
                <td colspan='5' align='right'><b>Total</b></td>
                <td><b>&#8369; " . number_format($total, 2) . "</b></td>
            </tr>
        ";
    } catch (Exception $e) {
        $output .= "
            <tr>
                <td colspan='6'>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td>
            </tr>
        ";
    }
} else {
    // Handle session cart for non-logged in users
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (empty($_SESSION['cart'])) {
        $output .= "
            <tr>
                <td colspan='6' align='center'>Shopping cart empty</td>
            </tr>
        ";
    } else {
        $total = 0;
        foreach ($_SESSION['cart'] as $row) {
            $productid = isset($row['productid']) ? $row['productid'] : null;
            $quantity = isset($row['quantity']) ? $row['quantity'] : null;

            if (is_null($productid) || is_null($quantity)) {
                continue;
            }

            $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname, products.stock FROM products LEFT JOIN category ON category.id = products.category_id WHERE products.id = ?");
            $stmt->bind_param("i", $productid);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            // Limit quantity to available stock
            $quantity = min($quantity, $product['stock']);

            $image = (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg';

            // Use discount_price if available
            $price = !empty($product['discount_price']) ? $product['discount_price'] : $product['price'];
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $output .= "
                <tr>
                    <td><button type='button' data-id='" . $productid . "' class='btn btn-danger btn-flat cart_delete'><i class='fas fa-trash'></i></button></td>
                    <td><img src='" . $image . "' width='50px' height='50px'></td>
                    <td>" . htmlspecialchars($product['prodname'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>&#8369; " . number_format($price, 2) . "</td>
                    <td class='input-group'>
                        <span class='input-group-btn'>
                            <button type='button' class='btn btn-default btn-flat minus' data-id='" . $productid . "'><i class='fa fa-minus'></i></button>
                        </span>
                        <input type='text' class='form-control' value='" . $quantity . "' id='qty_" . $productid . "'>
                        <span class='input-group-btn'>
                            <button type='button' class='btn btn-default btn-flat add' data-id='" . $productid . "'><i class='fa fa-plus'></i></button>
                        </span>
                    </td>
                    <td>&#8369; " . number_format($subtotal, 2) . "</td>
                </tr>
            ";
        }
        $output .= "
            <tr>
                <td colspan='5' align='right'><b>Total</b></td>
                <td><b>&#8369; " . number_format($total, 2) . "</b></td>
            </tr>
        ";
    }
}

echo $output;
exit;
