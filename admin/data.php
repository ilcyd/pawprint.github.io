<?php
include 'includes/session.php';
$userid = $user['id'];
// Update notifications to mark them as read
$query = 'UPDATE notifications SET is_read = 1 WHERE user_id = ' . $userid;
if (mysqli_query($conn, $query)) {
    // If the update was successful, fetch all fields of read notifications
    $query2 = 'SELECT message AS msg, created_at FROM notifications WHERE user_id = ' . $userid . ' AND is_read = 1 ORDER BY created_at DESC';
    $result = mysqli_query($conn, $query2);

    if ($result) {
        // Fetch all rows as an associative array
        $notifications = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $notifications[] = $row;
        }
        // Encode the notifications array as JSON and echo it
        echo json_encode($notifications);
    } else {
        echo json_encode(['error' => 'Failed to fetch notifications']);
    }
} else {
    echo json_encode(['error' => 'Failed to mark notifications as read']);
}
