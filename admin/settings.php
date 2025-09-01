<?php
include 'includes/session.php'; // Include your database connection script
include 'includes/header.php'; // Include your header

// Query to fetch all settings
$query = "SELECT * FROM settings";
$result = mysqli_query($conn, $query);

?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
    </div>

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Settings</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <form class="form-horizontal" action="" method="post">
            <?php if ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="form-group">
                    <label for="open_time" class="col-sm-3 control-label">Shop Open Time</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" id="open_time" name="open_time"
                               value="<?php echo htmlspecialchars($row['open_time']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="close_time" class="col-sm-3 control-label">Shop Close Time</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control" id="close_time" name="close_time"
                               value="<?php echo htmlspecialchars($row['close_time']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="crit_level" class="col-sm-3 control-label">Product Critical Level</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="crit_level" name="crit_level"
                               value="<?php echo htmlspecialchars($row['crit_level']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="discount_percent" class="col-sm-3 control-label">Discount % for Products about to expire</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="discount_percent" name="discount_percent"
                               value="<?php echo htmlspecialchars($row['discount_percent']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="discount_show_time" class="col-sm-3 control-label">When the discount shows</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="discount_show_time" name="discount_show_time"
                               value="<?php echo htmlspecialchars($row['discount_show_time']); ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="save">Save</button>
            <?php } ?>
          </form>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include 'includes/footer.php'; ?>
  </div>
  <!-- ./wrapper -->

  <?php include 'includes/scripts.php'; ?>

</body>
</html>

<?php
// Check if form is submitted
if (isset($_POST['save'])) {
    // Retrieve form data
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $crit_level = $_POST['crit_level'];
    $discount_percent = $_POST['discount_percent'];
    $discount_show_time = $_POST['discount_show_time'];

    // Check if any data exists in the settings table
    $check = "SELECT COUNT(*) as count FROM settings";
    $result = mysqli_query($conn, $check);
    $row_count = mysqli_fetch_assoc($result)['count'];

    if ($row_count > 0) {
        // Data exists, update the settings
        $sql = "UPDATE settings SET open_time = ?, close_time = ?, crit_level = ?, discount_percent = ?, discount_show_time = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $open_time, $close_time, $crit_level, $discount_percent, $discount_show_time);
    } else {
        // No data exists, insert new settings
        $sql = "INSERT INTO settings (open_time, close_time, crit_level, discount_percent, discount_show_time) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $open_time, $close_time, $crit_level, $discount_percent, $discount_show_time);
    }

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Update...',
                    text: 'Settings updated Successfully',
                }).then(function() {
                    window.location.href = 'settings.php';
                });
              </script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}
?>
