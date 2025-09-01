<?php
include 'includes/session.php';
include 'includes/format.php';

// Get the date range from the query string
$dateRange = isset($_GET['date_range']) ? $_GET['date_range'] : '';

// If the date range is provided, split it into start and end dates
if ($dateRange) {
    $dates = explode(' - ', $dateRange);
    $startDate = $dates[0];
    $endDate = $dates[1];
    
    // Modify start date to begin at the start of the day (00:00:00)
    $startDate = date('Y-m-d 00:00:00', strtotime($startDate));

    // Modify end date to end at the end of the day (23:59:59)
    $endDate = date('Y-m-d 23:59:59', strtotime($endDate));

    // SQL query to fetch transactions within the date range
    $query = "SELECT t.transaction_id, 
                     CONCAT(u.firstname, ' ', u.lastname) AS owner_name, 
                     s.service_name,
                     s.price 
              FROM transactions t
              LEFT JOIN services s ON t.service_id = s.service_id
              LEFT JOIN users u ON t.owner_id = u.id
              WHERE t.date_created BETWEEN '$startDate' AND '$endDate'
              ORDER BY t.id DESC";

    $result = mysqli_query($conn, $query);
} else {
    $result = false; // No date range provided
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Print</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Add your Bootstrap CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1 class="text-center">Service Report</h1>
    <h3 class="text-center"><?php echo $dateRange; ?></h3> <!-- Display the date range -->
    
    <table class="table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Owner Name</th>
                <th>Service Name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr>
                        <td>" . $row['transaction_id'] . "</td>
                        <td>" . $row['owner_name'] . "</td>
                        <td>" . $row['service_name'] . "</td>
                        <td>&#8369; " . number_format($row['price'], 2) . "</td>
                    </tr>
                    ";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No records found for the selected date range.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        window.print();  // Automatically trigger print dialog when the page is loaded
    </script>

</body>
</html>
