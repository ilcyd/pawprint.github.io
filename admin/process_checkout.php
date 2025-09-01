<?php
include 'includes/session.php';
header('Content-Type: application/json');

// Get raw POST data
$input = json_decode(file_get_contents('php://input'), true);

// Check if data is valid
if (isset($input['customer_id'], $input['items'], $input['total_with_tax'], $input['payment'], $input['change'])) {
    $customer_id = $input['customer_id'];
    $items = $input['items'];
    $total_with_tax = $input['total_with_tax'];
    $payment = $input['payment'];
    $change = $input['change'];

    // Check if customer ID is valid
    if (empty($customer_id)) {
        echo json_encode(['success' => false, 'message' => 'Customer ID is required.']);
        exit;
    }

    // Begin a transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // Insert the order into the orders table
        $sql = "INSERT INTO orders (customer_id, total_with_tax, payment, `change`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iddd', $customer_id, $total_with_tax, $payment, $change);

        if (!$stmt->execute()) {
            throw new Exception('Error inserting order: ' . $stmt->error);
        }

        // Get the last inserted order ID
        $order_id = $conn->insert_id;

        // Insert the order items into the order_items table and deduct stock
        foreach ($items as $item) {
            $product_id = $item['id'];
            $quantity = $item['qty'];
            $price = $item['price']; // Get the price of the item

            // Check if there is enough stock
            $sql_check_stock = "SELECT stock FROM products WHERE id = ?";
            $stmt_check_stock = $conn->prepare($sql_check_stock);
            $stmt_check_stock->bind_param('i', $product_id);
            $stmt_check_stock->execute();
            $result = $stmt_check_stock->get_result();
            $product = $result->fetch_assoc();

            if (!$product || $product['stock'] < $quantity) {
                throw new Exception('Insufficient stock for product: ' . $item['name']);
            }

            // Insert item into order_items table
            $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt_item = $conn->prepare($sql_item);
            $stmt_item->bind_param('iiid', $order_id, $product_id, $quantity, $price);
            if (!$stmt_item->execute()) {
                throw new Exception('Error inserting order item: ' . $stmt_item->error);
            }

            // Deduct stock from the products table
            $sql_update_stock = "UPDATE products SET stock = stock - ? WHERE id = ?";
            $stmt_update_stock = $conn->prepare($sql_update_stock);
            $stmt_update_stock->bind_param('ii', $quantity, $product_id);
            if (!$stmt_update_stock->execute()) {
                throw new Exception('Error updating stock for product ID ' . $product_id);
            }
        }

        // Commit the transaction
        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Order successfully processed.']);
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required data.']);
}
?>
