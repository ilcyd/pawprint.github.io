<?php
include 'includes/session.php';
include 'includes/format.php';
?>
<?php include('includes/header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include('includes/navbar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Transactions</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Total Transactions</li>
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
                  <form method="POST" class="form-inline" action="transactions.php">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                      <input type="text" class="form-control" id="reservation" name="date_range">
                    </div>
                    <button type="button" class="btn btn-success btn-sm btn-flat ml-2" id="btn-print">
                      <span class="glyphicon glyphicon-print"></span> Print
                    </button>
                  </form>
                </div>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered w-100">
                    <thead>
                      <tr>
                        <th>Transaction ID</th>
                        <th>Service</th>
                        <th>Service Price</th>
                      </tr>
                    </thead>
                    <tbody id="transaction-data">
                      <!-- Dynamic transaction data will be loaded here -->
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

  <?php include 'includes/scripts.php'; ?>

  <script>
    $(function () {
      function fetchTransactions(startDate, endDate) {
        $.ajax({
          type: 'POST',
          url: 'fetch_transactions.php', // Create this file to fetch transactions
          data: { start_date: startDate, end_date: endDate },
          success: function (response) {
            $('#transaction-data').html(response);
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
        fetchTransactions(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      });

      // Initial fetch for today's transactions
      var today = moment().format('YYYY-MM-DD');
      fetchTransactions(today, today);

      // Print button functionality
      $('#btn-print').click(function() {
        var dateRange = $('#reservation').val();
        window.open('transactions_print.php?date_range=' + dateRange, '_blank');
      });
    });
  </script>
</body>

</html>
