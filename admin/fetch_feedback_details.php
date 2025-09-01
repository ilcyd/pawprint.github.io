<?php
include 'includes/session.php';
// Ensure feedback_id is set and numeric
if (isset($_POST['feedback_id']) && is_numeric($_POST['feedback_id'])) {
 $feedback_id = $_POST['feedback_id'];

 // SQL query to fetch feedback details based on feedback_id
 $sql = "SELECT * FROM feedback WHERE id = $feedback_id";
 $result = mysqli_query($conn, $sql);

 if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  ?>
  <h5>Email: <?php echo $row['email']; ?></h5>
  <p><strong>Full Name:</strong> <?php echo $row['fullname']; ?></p>
  <p><strong>Message:</strong></p>
  <p><?php echo $row['message']; ?></p>
  <?php
 } else {
  echo "<p>No feedback found for ID: $feedback_id</p>";
 }
} else {
 echo "<p>Invalid feedback ID.</p>";
}
?>