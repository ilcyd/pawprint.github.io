<?php
include 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawPrint</title>
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">

</head>

<body>

    <?php include 'includes/scripts.php'; ?>
</body>

</html>
<?php

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Execute the query directly
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            if ($row['status']) {
                if ($row['type'] == 2) {
                    $_SESSION['admin'] = $row['id'];
                } elseif ($row['type'] == 1) {
                    $_SESSION['veterinarian'] = $row['id'];
                } else {
                    $_SESSION['user'] = $row['id'];
                }
                // Redirect to dashboard or appropriate page upon successful login
                echo "<script>
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Login Success',
                            showConfirmButton: false,
                            timer: 1500
                            }).then(function() {
                                window.location.href = 'cart_view.php';
                            });
                      </script>";
                exit();
            } else {
                $_SESSION['error'] = 'Account not activated.';
            }
        } else {
            $_SESSION['error'] = 'Incorrect Password';
        }
    } else {
        $_SESSION['error'] = 'Email not found';
    }

    // Free result set
    mysqli_free_result($result);

    // Close connection

} else {
    $_SESSION['error'] = 'Input login credentials first';
}

// Redirect to login page with SweetAlert2 alert for errors
echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '" . $_SESSION['error'] . "',
        }).then(function() {
            window.location.href = 'login.php';
        });
      </script>";
?>