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
session_destroy();

// Redirect to login page with SweetAlert2 alert for errors
echo "<script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Logout...',
            text: '" . "Logout Successfully" . "',
        }).then(function() {
            window.location.href = 'login.php';
        });
      </script>";