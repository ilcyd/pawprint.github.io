<?php
include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transaction_id = $_POST['transaction_id'];

    // Update transaction status to Paid
    $sql = "UPDATE transactions SET status = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $transaction_id);

    if ($stmt->execute()) {
        // Redirect back to the transactions page
        header("Location: transaction.php");
        exit();
    } else {
        echo "Error updating payment status.";
    }
}
?>
