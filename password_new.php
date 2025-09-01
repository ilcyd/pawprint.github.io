<?php
include 'includes/session.php';

if (!isset($_GET['code']) or !isset($_GET['user'])) {
	header('location: index.php');
	exit();
}

$path = 'password_reset.php?code=' . $_GET['code'] . '&user=' . $_GET['user'];

if (isset($_POST['reset'])) {
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];

	if ($password != $repassword) {
		$_SESSION['error'] = 'Passwords did not match';
		header('location: ' . $path);
	} else {
		$code = $_GET['code'];
		$user_id = $_GET['user'];

		$stmt = $conn->prepare("SELECT id FROM users WHERE reset_code=? AND id=?");
		$stmt->bind_param("si", $code, $user_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		if ($result->num_rows > 0) {
			$password = password_hash($password, PASSWORD_DEFAULT);

			$update_stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
			$update_stmt->bind_param("si", $password, $row['id']);
			try {
				$update_stmt->execute();
				$_SESSION['success'] = 'Password successfully reset';
				header('location: login.php');
			} catch (Exception $e) {
				$_SESSION['error'] = $e->getMessage();
				header('location: ' . $path);
			}
		} else {
			$_SESSION['error'] = 'Code did not match with user';
			header('location: ' . $path);
		}
	}
} else {
	$_SESSION['error'] = 'Input new password first';
	header('location: ' . $path);
}
?>