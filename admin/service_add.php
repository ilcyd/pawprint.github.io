<?php
include ('includes/session.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    // Process form data
    $name = $_POST["name"];
    $price = $_POST["price"];

    // Validate and sanitize input (not shown here for brevity)

    // Example: Insert into database (you should use prepared statements to prevent SQL injection)
    // Example assumes you have a database connection already established
    $sql = "INSERT INTO services (service_name, price) VALUES ('$name', '$price')";

    if (mysqli_query($conn, $sql)) {
        // Redirect or set success message
        header("Location: services.php"); // Redirect to your desired page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>