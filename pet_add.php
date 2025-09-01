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
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $pet_name = htmlspecialchars(trim($_POST["pet_name"]));
    $species = htmlspecialchars(trim($_POST["species"]));
    $breed = htmlspecialchars(trim($_POST["breed"]));
    $gender = htmlspecialchars(trim($_POST["gender"]));
    $birthdate = $_POST["birthdate"]; // Ensure it's an integer
    $vaccinated = intval($_POST["vaccinated"]); // Ensure it's an integer

    // Assuming $user['id'] contains the owner_id
    $owner_id = $user['id'];

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO pets (owner_id, pet_name, species_id, breed_id, gender, vaccine_status, birthdate) VALUES ( ?,?,?, ?, ?, ?, ?)");
    $stmt->bind_param("isiisis", $owner_id, $pet_name, $species, $breed, $gender, $vaccinated, $birthdate);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Redirect to pets.php after successful insertion with SweetAlert2 alert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Added...',
                text: 'Pet added Successfully',
            }).then(function() {
                window.location.href = 'pets.php';
            });
          </script>";
    } else {
        // Handle errors if insertion fails
        echo "Error: " . $stmt->error;
    }

    // Close statement
}