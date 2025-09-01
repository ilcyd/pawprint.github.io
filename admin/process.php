<?php
include 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>PawPrint</title>
 <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">

</head>

<body>

 <?php include 'includes/scripts.php'; ?>
</body>

</html>
<?php
// Check if required form fields are set
if (isset($_POST["client_id"]) && isset($_POST["service_id"]) && isset($_POST["pet_id"])) {
 // Sanitize input data
 $userId = mysqli_real_escape_string($conn, $_POST["client_id"]);
 $services = $_POST["service_id"];
 $petId = mysqli_real_escape_string($conn, $_POST["pet_id"]);

 // Insert consultation service if selected
 if (in_array(1, $services)) {
  $insertConsultationQuery = mysqli_query($conn, "INSERT INTO consultation (owner_id, pet_id, service_id) VALUES ('$userId', '$petId', 1)");
  if (!$insertConsultationQuery) {
   echo "Failed to add consultation service for user ID $userId and pet ID $petId.<br>";
  }

  // Generate transaction ID
  $currentYear = date("Y");
  $currentMonth = date("m");
  $currentDay = date("d");

  $lastInsertedIdQuery = mysqli_query($conn, "SELECT transaction_id FROM transactions ORDER BY transaction_id DESC LIMIT 1");
  if ($lastInsertedIdQuery) {
   $lastInsertedIdRow = mysqli_fetch_assoc($lastInsertedIdQuery);
   $lastInsertedId = ($lastInsertedIdRow && isset($lastInsertedIdRow['transaction_id'])) ? $lastInsertedIdRow['transaction_id'] : 0;

   $last4Digits = substr($lastInsertedId, -4);
   $newIdNumber = intval($last4Digits) + 1; // Convert to integer for proper increment

   $transactionId = $currentYear . $currentMonth . $currentDay . '-' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);

   // Insert transaction record
   $serviceIds = implode(',', $services);
   $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, owner_id, pet_id, service_id, date_created, status) VALUES (?, ?, ?, ?, ?, ?)");
   $date = date("Y-m-d");
   $status = 0;
   $stmt->bind_param("sssssi", $transactionId, $userId, $petId, $serviceIds, $date, $status);
   if ($stmt->execute()) {
    // Redirect to login page with SweetAlert2 alert for errors
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Created...',
            text: '" . "Created Successfully" . "',
        }).then(function() {
            window.location.href = 'home.php';
        });
      </script>";
   } else {
    echo "Failed to add services for user ID $userId and pet ID $petId.<br>";
   }
  } else {
   echo "Failed to fetch last inserted ID.<br>";
  }
 }
}
?>