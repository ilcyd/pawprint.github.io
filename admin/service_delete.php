<?php
include ('includes/session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    // Process form data
    $id = $_POST["id"];

    // Validate and sanitize input (not shown here for brevity)

    // Example: Delete from database (you should use prepared statements to prevent SQL injection)
    // Example assumes you have a database connection already established
    $sql = "DELETE FROM services WHERE service_id='$id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect or set success message
        header("Location: services.php"); // Redirect to your desired page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>