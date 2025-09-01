<?php
include 'includes/session.php';

$output = array('error' => false);

$id = $_POST['id'];
$qty = $_POST['qty'];

if (isset($_SESSION['user'])) {
    // Update the quantity in the database for the logged-in user
    $stmt = $conn->prepare("UPDATE cart SET quantity=? WHERE id=?");
    $stmt->bind_param("ii", $qty, $id);
    if ($stmt->execute()) {
        $output['message'] = 'Updated';
    } else {
        $output['error'] = true;
        $output['message'] = 'Error updating quantity in database';
    }
} else {
    // Update the quantity in the session cart
    foreach ($_SESSION['cart'] as $key => $row) {
        if ($row['productid'] == $id) {
            $_SESSION['cart'][$key]['quantity'] = $qty;
            $output['message'] = 'Updated';
        }
    }
}


// Output the JSON response
echo json_encode($output);