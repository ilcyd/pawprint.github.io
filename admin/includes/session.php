<?php
include '../includes/conn.php';
session_start();

if (!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '') {
    header('location: ../index.php');
    exit();
}

$user = null; // Initialize $user variable

if (isset($_SESSION['admin'])) {
    $userId = $_SESSION['admin'];

    // Prepare and execute the query securely
    if ($stmt = $conn->prepare("SELECT * FROM users WHERE id = ?")) {
        $stmt->bind_param("i", $userId); // "i" denotes the type of the parameter (integer)
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); // Fetch user data
        $stmt->close();
    }

}