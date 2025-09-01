<?php
include ('includes/session.php');

// Check if the user ID is provided and the form is submitted
if (isset($_POST['deny']) && isset($_POST['id'])) {
    // Get the user ID from the form submission
    $user_id = $_POST['id'];

    // Update the user status to denied (assuming `status` is a column in your `users` table)
    $sql = "UPDATE users SET status = 2 WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    // Redirect back to the appropriate page after processing
    if ($result) {
        // Denial successful
        header("Location: users_denied.php");
        exit();
    } else {
        // Error handling if the denial fails
        // Redirect or show an error message
        echo "Error: Unable to deny user.";
    }
} else {
    // Handle error if user ID is not provided or form is not submitted
    // Redirect or show an error message
    echo "Error: User ID not provided or form not submitted.";
}