<?php
include 'includes/session.php';
include 'includes/header.php';
?>

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
              <h1 class="m-0">Pet Health Records</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Pet Health Records</li>
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
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Pet Name</th>
                          <th>Owner Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT 
                                  pets.pet_id, 
                                  pets.pet_name, 
                                  users.id AS owner_id, 
                                  CONCAT(users.firstname, ' ', users.lastname) AS owner_name
                                FROM pets 
                                LEFT JOIN users ON pets.owner_id = users.id
                                WHERE pets.delete_flag = 0";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                              <tr>
                                <td>" . htmlspecialchars($row['pet_name']) . "</td>
                                <td>" . htmlspecialchars($row['owner_name']) . "</td>
                                <td>
                                    <a class='btn btn-info btn-sm view-more btn-flat' href='pet_records.php?pet_id=" . htmlspecialchars($row['pet_id']) . "&owner_id=" . htmlspecialchars($row['owner_id']) . "'>View More</a>
                                </td>
                              </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='3'><center>No records found.</center></td></tr>";
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
  </div>

  <?php include 'includes/scripts.php'; ?>

</body>

</html>
