<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
    $curr_password = $_POST['curr_password'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $photo = $_FILES['photo']['name'];

    // Get user data from session or database
    $user_id = $user['id'];
    $user_password = $user['password'];
    $user_photo = $user['photo'];

    if (password_verify($curr_password, $user_password)) {
        if (!empty($photo)) {
            move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $photo);
            $filename = $photo;
        } else {
            $filename = $user_photo;
        }

        if ($password == $user_password) {
            $password = $user_password;
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        $stmt = $conn->prepare("UPDATE users SET email=?, password=?, firstname=?, lastname=?, contact=?, address=?, profile=? WHERE id=?");
        $stmt->bind_param("sssssssi", $email, $password, $firstname, $lastname, $contact, $address, $filename, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Account updated successfully';
        } else {
            $_SESSION['error'] = $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Incorrect password';
    }
} else {
    $_SESSION['error'] = 'Fill up edit form first';
}

$conn->close();

header('location: profile.php');
