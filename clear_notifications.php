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
// Retrieve the user ID from the session
$userid = $user['id'];

// SQL query to delete notifications for the user
$sql = "DELETE FROM notifications WHERE user_id = ?";

if ($stmt = $conn->prepare($sql)) {
 // Bind the user ID parameter to the SQL query
 $stmt->bind_param("i", $userid);

 // Execute the prepared statement
 if ($stmt->execute()) {
  // Close the statement
  $stmt->close();
  // Return a success response
  echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Clearing...',
            text: '" . "Cleared Successfully" . "',
        }).then(function() {
            window.location.href = 'index.php';
        });
      </script>";
 } else {
  // If execution fails, set response code and return an error message
  http_response_code(500); // Internal Server Error
  echo json_encode(['error' => 'Failed to clear notifications']);
 }
} else {
 // If preparation fails, set response code and return an error message
 http_response_code(500); // Internal Server Error
 echo json_encode(['error' => 'Database prepare statement error']);
}

?>