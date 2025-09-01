<?php
include 'includes/session.php';
include 'includes/format.php';
include('includes/header.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include('includes/navbar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
    </div>

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
                  <form method="POST" class="form-inline" action="salesbyproduct.php">
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
                  <table id="example1" class="table table-bordered w-100">
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th>Quantity Sold</th>
                      </tr>
                    </thead>
                    <tbody id="transaction-data">
  <!-- Fetched data will be inserted here -->
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
        function fetchQuantitySold(startDate, endDate) {
            $.ajax({
                type: 'POST',
                url: 'fetch_quantity.php', // Adjust the path if necessary
                data: { start_date: startDate, end_date: endDate },
                success: function (response) {
                    $('#transaction-data').html(response); // Adjust the ID to your table body
                },
                error: function () {
                    alert("Failed to fetch data.");
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
            fetchQuantitySold(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        });

        // Initial fetch for today's sales
        var today = moment().format('YYYY-MM-DD');
        fetchQuantitySold(today, today);
    });
</script>

</body>

</html>
