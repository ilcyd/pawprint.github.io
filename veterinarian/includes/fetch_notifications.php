<?php
// Simulating fetching notifications from a database or other source
$notifications = [
    [
        'id' => 1,
        'type' => 'info',
        'message' => 'New message',
        'created_at' => '2024-06-07 10:00:00',
        'is_read' => false
    ],
    [
        'id' => 2,
        'type' => 'warning',
        'message' => 'Another message',
        'created_at' => '2024-06-06 15:30:00',
        'is_read' => true
    ]
];

// Simulating the unread count
$unread_count = 1; // Assuming one unread notification

// Prepare the response
$response = [
    'notifications' => $notifications,
    'unread_count' => $unread_count
];

// Set the content type to JSON
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($response);
?>
