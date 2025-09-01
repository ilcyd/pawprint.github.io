<?php
include 'includes/session.php';
include 'includes/format.php';
?>
<?php include('includes/header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include('includes/navbar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
    </div> -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Reports</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Total Sales</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="box">
              <div class="box-header with-border">
                <div class="float-right">
                  <form method="POST" class="form-inline" action="sales_print.php" id="printForm">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                      <input type="text" class="form-control" id="reservation" name="date_range">
                    </div>
                    <button type="submit" class="btn btn-success btn-sm btn-flat ml-2" name="print">
                      <span class="glyphicon glyphicon-print"></span> Print
                    </button>
                  </form>

                </div>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-bordered w-100">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Transaction#</th>
                        <th>Service/Item</th>
                        <th>Amount</th>
                        <th>Full Details</th>
                      </tr>
                    </thead>
                    <tbody id="sales-data">
                      <?php
                      // Set default date range to today
                      $startDate = date('Y-m-d');
                      $endDate = date('Y-m-d');

                      // Query sales
                      $salesQuery = "SELECT s.*, u.firstname AS customer_firstname, u.lastname AS customer_lastname 
                                     FROM sales s
                                     LEFT JOIN users u ON u.id = s.user_id 
                                     WHERE s.sales_date BETWEEN '$startDate' AND '$endDate' 
                                     ORDER BY s.sales_date DESC";
                      $salesResult = $conn->query($salesQuery);

                      // Query transactions
                      $transactionsQuery = "SELECT t.transaction_id, t.service_id, t.date_created, s.service_name, s.price, u.firstname AS owner_firstname, u.lastname AS owner_lastname 
                                            FROM transactions t
                                            LEFT JOIN services s ON s.service_id = t.service_id
                                            LEFT JOIN users u ON u.id = t.owner_id
                                            WHERE t.date_created BETWEEN '$startDate' AND '$endDate'
                                            ORDER BY t.date_created DESC";
                      $transactionsResult = $conn->query($transactionsQuery);

                      // Fetch sales data and display
                      if ($salesResult->num_rows > 0) {
                        while ($sale = $salesResult->fetch_assoc()) {
                          $date = date('M d, Y', strtotime($sale['sales_date']));
                          $buyerName = $sale['customer_firstname'] . ' ' . $sale['customer_lastname'];
                          $transactionId = $sale['pay_id']; // Using pay_id for transaction number
                          $serviceName = 'N/A'; // No specific service for sales


                          echo "
                            <tr>
                              <td>$date</td>
                              <td>$buyerName</td>
                              <td>$transactionId</td>
                              <td>$serviceName</td>
                              <td></td>
                              <td>
                                <button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='" . $sale['id'] . "'>
                                  <i class='fa fa-search'></i> View
                                </button>
                              </td>
                            </tr>
                          ";
                        }
                      }

                      // Fetch transactions data and display
                      if ($transactionsResult->num_rows > 0) {
                        while ($transaction = $transactionsResult->fetch_assoc()) {
                          $date = date('M d, Y', strtotime($transaction['date_created']));
                          $buyerName = $transaction['owner_firstname'] . ' ' . $transaction['owner_lastname'];
                          $transactionId = $transaction['transaction_id']; // Correctly using transaction_id
                          $serviceName = $transaction['service_name'];
                          $amount = '&#8369; ' . number_format($transaction['price'], 2);

                          echo "
                            <tr>
                              <td class='hidden'></td>
                              <td>$date</td>
                              <td>$buyerName</td>
                              <td>$transactionId</td>
                              <td>$serviceName</td>
                              <td>$amount</td>
                              <td>
                                <button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='" . $transaction['transaction_id'] . "'>
                                  <i class='fa fa-search'></i> View
                                </button>
                              </td>
                            </tr>
                          ";
                        }
                      }

                      $conn->close();
                      ?>
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
    <?php include '../includes/profile_modal.php'; ?>

  </div>
  <!-- Modal -->
  <div class="modal fade" id="viewSaleModal" tabindex="-1" role="dialog" aria-labelledby="viewSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewSaleModalLabel">Sale Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Content will be dynamically loaded here -->
          <div id="saleDetailsContent"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <?php include 'includes/scripts.php'; ?>

  <script>
    $(function() {
      function fetchSalesData(startDate, endDate) {
        $.ajax({
          type: 'POST',
          url: 'fetch_sales.php',
          data: {
            start_date: startDate,
            end_date: endDate
          },
          success: function(response) {
            $('#sales-data').html(response);
          }
        });
      }

      // Initialize the date range picker
      $('#reservation').daterangepicker({
        locale: {
          format: 'YYYY-MM-DD'
        },
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
          'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
      }, function(start, end) {
        $('#reservation').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        fetchSalesData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      });

      // Initial fetch for today's transactions
      var today = moment().format('YYYY-MM-DD');
      fetchSalesData(today, today);


      $(document).on('click', '.btn-info', function(e) {
        e.preventDefault();

        // Get the sale ID from the button's data attribute
        var saleId = $(this).data('saleid');

        // Perform the AJAX request to fetch sale details
        $.ajax({
          type: 'POST',
          url: 'view_sale_details.php', // PHP file that fetches sale details
          data: {
            id: saleId
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              // Populate the modal with the sale details
              $('#saleDetailsContent').html(response.details); // Assuming 'details' contains the HTML content
              $('#viewSaleModal').modal('show'); // Show the modal
            } else {
              alert("Failed to load sale details.");
            }
          },
          error: function(xhr, status, error) {
            alert("An error occurred: " + error);
          }
        });
      });


    });
  </script>
</body>

</html>