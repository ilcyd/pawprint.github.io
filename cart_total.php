<?php
include 'includes/session.php';

if (isset($_SESSION['user'])) {

    $sql = "SELECT * FROM cart LEFT JOIN products on products.id=cart.product_id WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user['id']);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $total = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
    }


    echo json_encode($total);
}