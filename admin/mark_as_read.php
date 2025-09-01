<?php
include 'includes/session.php';

$userid = $user['id'];

// Mark notifications as read
$query = 'UPDATE notifications SET is_read = 1 WHERE user_id = ' . $userid;
if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => 'Notifications marked as read']);
} else {
    echo json_encode(['error' => 'Failed to mark notifications as read']);
}