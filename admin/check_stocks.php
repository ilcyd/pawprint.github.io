<?php
include 'includes/session.php';

$userid = $user['id'];

// Check product stock levels and update notifications accordingly
$sql = "SELECT id, name, stock FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['id'];
        $product_name = $row['name'];
        $stock = $row['stock'];

        $message = "Product $product_name. Current stock: $stock";

        // Check if a notification already exists for this product
        $check_sql = "SELECT * FROM notifications WHERE product_id = $product_id";
        $check_result = $conn->query($check_sql);

        if ($stock <= 3) {
            if ($check_result->num_rows > 0) {
                // Update the notification if stock is lower
                $update_sql = "UPDATE notifications SET message = '$message', is_read = 0, created_at = NOW() WHERE product_id = $product_id";
                $conn->query($update_sql);
            } else {
                // Insert a new notification with the stock level in the message
                $insert_sql = "INSERT INTO notifications (user_id, product_id, message, created_at) VALUES ($userid, $product_id, '$message', NOW())";
                $conn->query($insert_sql);
            }
        } else {
            // Remove notification if stock is higher than 3
            if ($check_result->num_rows > 0) {
                $delete_sql = "DELETE FROM notifications WHERE product_id = $product_id";
                $conn->query($delete_sql);
            }
        }
    }
}

// Fetch and send the notifications as JSON
$notifications = [];

$fetch_query = "SELECT message AS msg, created_at FROM notifications WHERE user_id = $userid ORDER BY created_at DESC";
$fetch_result = mysqli_query($conn, $fetch_query);

if ($fetch_result) {
    while ($row = mysqli_fetch_assoc($fetch_result)) {
        $notifications[] = $row;
    }
} else {
    $notifications[] = ['error' => 'Failed to fetch notifications'];
}

echo json_encode($notifications);