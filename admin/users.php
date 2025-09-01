<?php
include 'includes/session.php';
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
    </div>

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Users</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Pending Users</li>
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

                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Email</th>
                          <th>First Name</th>
                          <th>Middle Name</th>
                          <th>Last Name</th>
                          <th>Address</th>
                          <th>Contact</th>
                          <th>Valid ID Type</th>
                          <th>Valid ID</th>
                          <th>Profile</th>
                          <th>Tools</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT users.*, valid_id_type.name as valid_id_type_name FROM users 
                    LEFT JOIN valid_id_type ON users.valid_id_type = valid_id_type.id
                    WHERE users.status = 0";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $profile = (!empty($row['profile'])) ? '../images/' . $row['profile'] : '../images/profile.jpg';
                            $valid_id = (!empty($row['valid_id'])) ? '../images/' . $row['valid_id'] : '../images/valid_id.jpg';
                            echo "
                    <tr>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['firstname'] . "</td>
                        <td>" . $row['middlename'] . "</td>
                        <td>" . $row['lastname'] . "</td>
                        <td>" . $row['address'] . "</td>
                        <td>" . $row['contact'] . "</td>
                        <td>" . $row['valid_id_type_name'] . "</td>
                        <td><img src='" . $valid_id . "' height='70px' width='70px'></td>
                        <td><img src='" . $profile . "' height='70px' width='70px'></td>
                        <td>
                            <button class='btn btn-success btn-sm approve btn-flat' data-id='" . $row['id'] . "'> Approve</button>
                            <button class='btn btn-danger btn-sm denied btn-flat' data-id='" . $row['id'] . "'> Deny</button>
                        </td>
                    </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='11'><center>No pending users found.</center></td></tr>";
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
    <?php include 'includes/users_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function () {
      $(document).on('click', '.approve', function (e) {
        e.preventDefault();
        $('#approve').modal('show');
        var id = $(this).data('id');
        $('#approveUserId').val(id); // Populate the hidden input field with the data-id value
      });

      $(document).on('click', '.denied', function (e) {
        e.preventDefault();
        $('#denied').modal('show');
        var id = $(this).data('id');
        $('#denyUserId').val(id); // Populate the hidden input field with the data-id value
      });

      $(document).on('click', '.status', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });
    });

  </script>
</body>

</html>