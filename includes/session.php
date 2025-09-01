<?php
session_start();
include 'includes/conn.php';


if (isset($_SESSION['admin'])) {
    header('location: admin/home.php');
}
if (isset($_SESSION['veterinarian'])) {
    header('location: veterinarian/home.php');
}

if (isset($_SESSION['user'])) {

    $user_id = $_SESSION['user'];

    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found!";
    }

}