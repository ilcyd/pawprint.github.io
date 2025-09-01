<?php
include 'includes/session.php';
include 'includes/header.php';

// Fetch orders from the database
$sql_orders = "SELECT orders.id, orders.date_created, orders.total_with_tax, users.firstname, users.lastname 
               FROM orders
               JOIN users ON orders.customer_id = users.id 
               ORDER BY orders.date_created DESC";
$result_orders = mysqli_query($conn, $sql_orders);

// Check if the query was successful
if (!$result_orders) {
    die("Error fetching orders: " . mysqli_error($conn));
}

?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>
        <div class="content-wrapper">
            <h2>Orders List</h2>
            <table class="table table-bordered" id="ordersTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Grand Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($result_orders)) { ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?></td>
                            <td><?php echo date('F j, Y, g:i a', strtotime($order['date_created'])); ?></td> <!-- Format date -->
                            <td>₱<?php echo number_format($order['total_with_tax'], 2); ?></td>
                            <td>
                                <a href="view_invoice.php?order_id=<?php echo $order['id']; ?>" target="_blank" class="btn btn-primary btn-sm">
                                    View & Print Invoice
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/scripts.php'; ?>
        <script>
            $(document).ready(function() {
                $('table').DataTable({
                    "ordering": true, // Enable sorting
                    "paging": true, // Enable pagination
                    "searching": true, // Enable search functionality
                    "order": [
                        [0, 'desc']
                    ]
                });
            });
        </script>

    </div>
</body>

</html>