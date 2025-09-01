<?php
include 'includes/session.php';

$userid = $user['id'];
$query = "SELECT COUNT(*) FROM notifications WHERE user_id = '$userid' AND is_read = 0";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_array(MYSQLI_NUM);
    echo json_encode($row[0]);
}