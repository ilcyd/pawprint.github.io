<?php
include 'includes/session.php';
include 'includes/format.php';

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Modify start date to begin at the start of the day (00:00:00)
    $startDate = date('Y-m-d 00:00:00', strtotime($startDate));

    // Modify end date to end at the end of the day (23:59:59)
    $endDate = date('Y-m-d 23:59:59', strtotime($endDate));

    // Combined query for both sales and transactions, with ORDER BY applied outside UNION ALL
    $query = "
        (SELECT s.sales_date AS date_created, 
                u.firstname AS customer_firstname, 
                u.lastname AS customer_lastname, 
                s.pay_id AS transaction_id, 
                GROUP_CONCAT(p.name SEPARATOR ', ') AS product_names, 
                SUM(d.quantity * p.price) AS total_amount, 
                'Sale' AS type
         FROM sales s
         LEFT JOIN users u ON u.id = s.user_id 
         LEFT JOIN details d ON d.sales_id = s.id
         LEFT JOIN products p ON p.id = d.product_id
         WHERE s.sales_date BETWEEN '$startDate' AND '$endDate'
         GROUP BY s.id, u.firstname, u.lastname)

        UNION ALL

        (SELECT t.date_created, 
                u.firstname AS owner_firstname, 
                u.lastname AS owner_lastname, 
                t.transaction_id, 
                s.service_name, 
                s.price AS total_amount, 
                'Transaction' AS type
         FROM transactions t
         LEFT JOIN services s ON s.service_id = t.service_id
         LEFT JOIN users u ON u.id = t.owner_id
         WHERE t.date_created BETWEEN '$startDate' AND '$endDate')
         
        ORDER BY date_created DESC
    ";

    $result = $conn->query($query);

    // Prepare output
    $output = '';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Format the date
            $date = date('M d, Y', strtotime($row['date_created']));
            // Buyer/Owner Name
            $buyerName = $row['customer_firstname'] . ' ' . $row['customer_lastname'];
            if (empty($buyerName)) {
                $buyerName = $row['owner_firstname'] . ' ' . $row['owner_lastname'];
            }
            // Transaction ID and Service/Product Name
            $transactionId = $row['transaction_id'];
            $productNames = !empty($row['product_names']) ? $row['product_names'] : $row['service_name'];
            $amount = '&#8369; ' . number_format($row['total_amount'], 2);
            // Sale or Transaction Type
            $type = $row['type'];

            // Output the row
            $output .= "
                <tr>
                    <td>$date</td>
                    <td>$buyerName</td>
                    <td>$transactionId</td>
                    <td>$productNames</td>
                    <td>$amount</td>
                    <td>$type</td> <!-- Sale or Transaction -->
                    <td>";
            
            // Only display "View" button for Sales
            if ($type == 'Sale') {
                $output .= "
                        <button type='button' class='btn btn-info btn-sm btn-flat' data-toggle='modal' data-target='#viewSaleModal' data-saleid='$transactionId'>
                            <i class='fa fa-search'></i> View
                        </button>
                    ";
            } else {
                $output .= ""; // For transactions, do not show the "View" button
            }

            $output .= "</td></tr>";
        }
    } else {
        $output = "<tr><td colspan='7'>No records found.</td></tr>";
    }

    echo $output;
    $conn->close();
} else {
    echo "No data available.";
}
?>
