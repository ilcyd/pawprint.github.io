<?php
include 'includes/session.php';
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Disease Records</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Disease Records</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i
                      class="fa fa-plus"></i> New</a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Disease Name</th>
                          <th>Count</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT id, name, count FROM prescription_records";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                              <tr>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['count']) . "</td>
                                
                              </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='3'>No disease records found.</td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/disease_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function () {
      $(document).on('click', '.denied', function (e) {
        e.preventDefault();
        $('#denied').modal('show');
        var id = $(this).data('id');
        $('#denyDiseaseId').val(id); // Populate the hidden input field with the data-id value
      });
    });
  </script>
</body>

</html>