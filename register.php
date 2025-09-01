<?php
include 'includes/session.php';

if (isset($_POST['signup'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $contact = $_POST['contact'];
    $provinceId = $_POST["province"];
    $municipalityId = $_POST["municipality"];
    $barangayId = $_POST["barangay"];
    $additionalAddressInfo = $_POST["additional_address_info"];
    $valid_id_type = $_POST['valid_id_type'];
    $valid_id = $_FILES['valid_id']['name'];
    $profile = $_FILES['profile']['name'];
    $type = 0;

    if (!empty($valid_id)) {
        move_uploaded_file($_FILES['valid_id']['tmp_name'], 'images/' . $valid_id);
        $filename1 = $valid_id;
    } else {
        $filename1 = null;
    }

    if (!empty($profile)) {
        move_uploaded_file($_FILES['profile']['tmp_name'], 'images/' . $profile);
        $filename2 = $profile;
    } else {
        $filename2 = null;
    }

    if ($password != $repassword) {
        $_SESSION['error'] = 'Passwords did not match';
        header('location: signup.php');
    } else {
        $sql = "SELECT COUNT(*) AS numrows FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if ($row['numrows'] > 0) {
            $_SESSION['error'] = 'Email already taken';
            header('location: signup.php');
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            // Retrieve province, municipality, and barangay names based on IDs
            $stmt = $conn->prepare("SELECT * FROM provinces WHERE province_id = ?");
            $stmt->bind_param("i", $provinceId);
            $stmt->execute();
            $provinceResult = $stmt->get_result();
            $provinceRow = $provinceResult->fetch_assoc();
            $provinceName = $provinceRow['province_name'];

            $stmt = $conn->prepare("SELECT * FROM municipalities WHERE municipality_id = ?");
            $stmt->bind_param("i", $municipalityId);
            $stmt->execute();
            $municipalityResult = $stmt->get_result();
            $municipalityRow = $municipalityResult->fetch_assoc();
            $municipalityName = $municipalityRow['municipality_name'];

            $stmt = $conn->prepare("SELECT * FROM barangays WHERE barangay_id = ?");
            $stmt->bind_param("i", $barangayId);
            $stmt->execute();
            $barangayResult = $stmt->get_result();
            $barangayRow = $barangayResult->fetch_assoc();
            $barangayName = $barangayRow['barangay_name'];

            // Concatenate the address
            $address = $additionalAddressInfo . ", " . $barangayName . ", " . $municipalityName . ", " . $provinceName;

            // Insert the new user into the database
            $sql = "INSERT INTO users (email, password, type, firstname, middlename, lastname, address, contact, valid_id_type, valid_id, profile)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssissssssss", $email, $password, $type, $firstname, $middlename, $lastname, $address, $contact, $valid_id_type, $filename1, $filename2);

            if ($stmt->execute()) {
                $new_user_id = $stmt->insert_id;
                $_SESSION['success'] = 'Account created successfully. Please wait for activation.';

                // Get all admin IDs
                $ad_sql = "SELECT id FROM users WHERE status = 1 AND type = 2";
                $ad_result = $conn->query($ad_sql);

                // Insert a notification for each admin
                while ($admin = $ad_result->fetch_assoc()) {
                    $admin_id = $admin['id'];
                    $notif_sql = "INSERT INTO notifications (user_id, new_user_id, message) VALUES (?, ?, 'A new user has registered')";
                    $notif_stmt = $conn->prepare($notif_sql);
                    $notif_stmt->bind_param("ii", $admin_id, $new_user_id);
                    $notif_stmt->execute();
                }

                header('location: signup.php');
                exit();
            } else {
                $_SESSION['error'] = 'Error: ' . $conn->error;
                header('location: signup.php');
                exit();
            }
        }
    }
} else {
    $_SESSION['error'] = 'Fill up signup form first';
    header('location: signup.php');
    exit();
}