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
                  <tbody>
                    <?php
                      $sql = "SELECT product_id, SUM(quantity) AS total_quantity_sold FROM details GROUP BY product_id ORDER BY total_quantity_sold DESC";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                          $product_id = $row['product_id'];
                          $product_name_query = "SELECT name FROM products WHERE id = '$product_id'";
                          $product_name_result = $conn->query($product_name_query);
                          $product_name_row = $product_name_result->fetch_assoc();
                          $product_name = $product_name_row['name'];

                          echo "
                            <tr>
                              <td>".$product_name."</td>
                              <td>".$row['total_quantity_sold']."</td>
                            </tr>
                          ";
                        }
                      } else {
                        echo "<tr><td colspan='2'>No records found.</td></tr>";
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
