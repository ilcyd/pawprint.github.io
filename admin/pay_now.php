<?php
include 'includes/session.php';

if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    // Update the transaction status to 'Paid'
    $sql = "UPDATE transactions SET status = 1 WHERE transaction_id = '$transaction_id'";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
