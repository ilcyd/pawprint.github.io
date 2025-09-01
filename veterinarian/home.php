<?php
include 'includes/session.php';
include 'includes/format.php';

$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
  $year = $_GET['year'];
}

// Fetch monthly sales data for the specified year
$sales = array();
$months = array();


if ($conn) {
  // Fetch monthly sales data for the specified year
  for ($month = 1; $month <= 12; $month++) {
    $query = "SELECT SUM(details.quantity * products.price) AS total_sales 
              FROM details 
              LEFT JOIN sales ON sales.id = details.sales_id 
              LEFT JOIN products ON products.id = details.product_id 
              WHERE YEAR(sales.sales_date) = '$year' AND MONTH(sales.sales_date) = '$month'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $sales[] = isset($row['total_sales']) ? (float) $row['total_sales'] : 0;
    $months[] = date("F", mktime(0, 0, 0, $month, 1));
  }
} else {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>

<?php include ('includes/header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
    </div>

    <?php include ('includes/navbar.php'); ?>
    <?php include ('includes/sidebar.php'); ?>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-blue">
                <div class="inner">
                  <?php
                  $query = "SELECT *, COUNT(*) AS numrows FROM appointments";
                  $result = mysqli_query($conn, $query);
                  $prow = mysqli_fetch_assoc($result);

                  echo "<h3>" . $prow['numrows'] . "</h3>";
                  ?>
                  <p>Total Appointments</p>
                </div>
                <div class="icon">
                  <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-green">
                <div class="inner">
                  <?php
                  $query = "SELECT *, COUNT(*) AS numrows FROM consultation";
                  $result = mysqli_query($conn, $query);
                  $prow = mysqli_fetch_assoc($result);

                  echo "<h3>" . $prow['numrows'] . "</h3>";
                  ?>
                  <p>Total Consultation</p>
                </div>
                <div class="icon">
                  <i class="fa fa-barcode"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <?php
                  $query = "SELECT *, COUNT(*) AS numrows FROM vaccination";
                  $result = mysqli_query($conn, $query);
                  $urow = mysqli_fetch_assoc($result);

                  echo "<h3>" . $urow['numrows'] . "</h3>";
                  ?>
                  <p>Total Vaccination</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <?php
                  $query = "SELECT *, COUNT(*) AS numrows FROM vaccination";
                  $result = mysqli_query($conn, $query);
                  $urow = mysqli_fetch_assoc($result);

                  echo "<h3>" . $urow['numrows'] . "</h3>";
                  ?>
                  <p>Records</p>
                </div>
                <div class="icon">
                  <i class="fa fa-money"></i>
                </div>
                <a href="sales.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Monthly Sales Report</h3>
                  <div class="box-tools pull-right">
                    <form class="form-inline">
                      <div class="form-group">
                        <label>Select Year: </label>
                        <select class="form-control input-sm" id="select_year">
                          <?php
                          for ($i = 2015; $i <= 2065; $i++) {
                            $selected = ($i == $year) ? 'selected' : '';
                            echo "
                            <option value='" . $i . "' " . $selected . ">" . $i . "</option>
                          ";
                          }
                          ?>
                        </select>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <br>
                    <div id="legend" class="text-center"></div>
                    <canvas id="barChart" style="height:350px; width:200%;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

      </section>
    </div>
    <?php include 'includes/footer.php'; ?>

  </div>

  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function () {
      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: {
          labels: <?php echo json_encode($months); ?>,
          datasets: [{
            label: 'SALES',
            data: <?php echo json_encode($sales); ?>,
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          legend: {
            display: false
          }
        }
      });

      document.getElementById('legend').innerHTML = barChart.generateLegend();
    });

    $(function () {
      $('#select_year').change(function () {
        window.location.href = 'home.php?year=' + $(this).val();
      });
    });
  </script>
</body>

</html>