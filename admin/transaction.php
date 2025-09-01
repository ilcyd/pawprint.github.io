<?php
include 'includes/session.php';
include 'includes/header.php';

// Fetch transactions from the database
$sql_transactions = "SELECT * FROM transactions";  // Fetch all transactions
$transactions = mysqli_query($conn, $sql_transactions);
?>

<!-- Add styles and scripts for DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Transactions</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Transactions Table -->
                            <div class="card">
                                <div class="card-body">
                                    <h4>Transaction List</h4>
                                    <table id="transactions-table" class="display">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Owner</th>
                                                <th>Pet</th>
                                                <th>Service</th>
                                                <th>Service Price</th>
                                                <!-- <th>Type</th> -->
                                                <th>Date Created</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($transaction = mysqli_fetch_assoc($transactions)) { ?>
                                                <tr>
                                                    <td><?php echo $transaction['transaction_id']; ?></td>
                                                    <td>
                                                        <?php
                                                        // Fetch owner details
                                                        $owner_id = $transaction['owner_id'];
                                                        $owner_sql = "SELECT firstname, lastname FROM users WHERE id = $owner_id";
                                                        $owner_result = mysqli_query($conn, $owner_sql);
                                                        $owner = mysqli_fetch_assoc($owner_result);
                                                        echo $owner['firstname'] . ' ' . $owner['lastname'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        // Fetch pet details
                                                        $pet_id = $transaction['pet_id'];
                                                        $pet_sql = "SELECT pet_name FROM pets WHERE pet_id = $pet_id";
                                                        $pet_result = mysqli_query($conn, $pet_sql);
                                                        $pet = mysqli_fetch_assoc($pet_result);
                                                        echo $pet['pet_name'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        // Fetch service details
                                                        $service_id = $transaction['service_id'];
                                                        $service_sql = "SELECT service_name FROM services WHERE service_id = $service_id";
                                                        $service_result = mysqli_query($conn, $service_sql);
                                                        $service = mysqli_fetch_assoc($service_result);
                                                        echo $service['service_name'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        // Fetch service price
                                                        $price_sql = "SELECT price FROM services WHERE service_id = $service_id";
                                                        $price_result = mysqli_query($conn, $price_sql);
                                                        $price = mysqli_fetch_assoc($price_result);
                                                        echo '₱' . number_format($price['price'], 2);
                                                        ?>
                                                    </td>
                                                    <!-- <td>
                                                        <?php if ($transaction['type'] == 0) { ?>
                                                            <span class="text-danger">No Variants</span>
                                                        <?php } else { ?>
                                                            <?php echo $transaction['type']; ?>
                                                        <?php } ?>
                                                    </td> -->
                                                    <td><?php echo $transaction['date_created']; ?></td>
                                                    <td>
                                                        <?php echo ($transaction['status'] == 1) ? 'Paid' : 'Unpaid'; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($transaction['status'] == 0) { ?>
                                                            <!-- Form to update payment status -->
                                                            <form action="update_payment.php" method="POST" style="display:inline;">
                                                                <input type="hidden" name="transaction_id" value="<?php echo $transaction['id']; ?>">
                                                                <button type="submit" class="btn btn-success btn-sm">Received Payment</button>
                                                            </form>
                                                        <?php } else { ?>
                                                            <button class="btn btn-warning btn-sm" disabled>Paid</button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/scripts.php'; ?>

        <script>
            // Initialize the DataTable
            $(document).ready(function() {
                $('#transactions-table').DataTable({
                    "order": [
                        [0, 'desc']
                    ] // Assuming column 6 (Date Created) is where you want to apply descending order
                });
            });
        </script>
    </div>
</body>

</html>