<?php 
  include 'includes/session.php';
  include 'includes/format.php'; 
?>
<?php include ('includes/header.php') ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include ('includes/navbar.php'); ?>
  <?php include ('includes/sidebar.php'); ?>

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
                <form method="POST" class="form-inline" action="salesbycategory.php">
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
                      <th>Product Category</th>
                      <th>Quantity Sold</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php

$query = "SELECT category.name AS category_name, 
                 SUM(details.quantity) AS total_quantity, 
                 SUM(products.price * details.quantity) AS total_amount
          FROM details 
          LEFT JOIN sales ON sales.id = details.sales_id 
          LEFT JOIN products ON products.id = details.product_id 
          LEFT JOIN category ON category.id = products.category_id 
          GROUP BY category.name
          ORDER BY category.name";

$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "
          <tr>
            <td>".$row['category_name']."</td>
            <td>".$row['total_quantity']."</td>
          </tr>
        ";
    }
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

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

<?php include 'includes/scripts.php'; ?>

<script>
$(function() {
  $('#reservation').daterangepicker({
    locale: {
      format: 'YYYY-MM-DD'
    }
  });

  $('#datepicker_add').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  });

  $('#datepicker_edit').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  });

  $('.timepicker').timepicker({
    showInputs: false
  });

  $('#reservationtime').daterangepicker({
    timePicker: true,
    timePickerIncrement: 30,
    locale: {
      format: 'MM/DD/YYYY h:mm A'
    }
  });

  $('#daterange-btn').daterangepicker(
    {
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate: moment()
    },
    function(start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
  );
});
</script>
</body>
</html>
