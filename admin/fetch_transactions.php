<?php
include 'includes/session.php';
include 'includes/format.php';

$startDate = $_POST['start_date'];  // Make sure to sanitize inputs
$endDate = $_POST['end_date'];      // Same for end_date

// If the date includes a time component, we need to handle it correctly
// Modify start date to begin at the start of the day (00:00:00)
$startDate = date('Y-m-d 00:00:00', strtotime($startDate));

// Modify end date to end at the end of the day (23:59:59)
$endDate = date('Y-m-d 23:59:59', strtotime($endDate));

// SQL query to fetch the data within the date range
$query = "SELECT t.id, t.transaction_id, 
                 CONCAT(u.firstname, ' ', u.lastname) AS owner_name, 
                 s.price,
                 s.service_name 
          FROM transactions t
          LEFT JOIN services s ON t.service_id = s.service_id
          LEFT JOIN users u ON t.owner_id = u.id
          WHERE t.date_created BETWEEN '$startDate' AND '$endDate' 
          ORDER BY t.id DESC"; // Ensure this matches your table structure

$result = mysqli_query($conn, $query);
$output = '';

if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $output .= "
      <tr>
        <td>" . $row['transaction_id'] . "</td>
        <td>" . $row['service_name'] . "</td>
        <td>&#8369; " . number_format($row['price'], 2) . "</td>
      </tr>
    ";
  }
} else {
  $output .= "<tr><td colspan='4'>No records found.</td></tr>";
}

echo $output;
?>
