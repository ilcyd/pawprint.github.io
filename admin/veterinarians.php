<?php
include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $valid_id_type = mysqli_real_escape_string($conn, $_POST['valid_id_type']);
    
    // Handle file uploads
    $valid_id = '';
    $profile = '';

    if (isset($_FILES['valid_id']) && $_FILES['valid_id']['error'] == 0) {
        $valid_id_dir = '../images/'; // Directory to store the valid ID image
        $valid_id_file = $valid_id_dir . basename($_FILES['valid_id']['name']);
        move_uploaded_file($_FILES['valid_id']['tmp_name'], $valid_id_file);
        $valid_id = basename($_FILES['valid_id']['name']); // Save the filename
    }

    if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
        $profile_dir = '../images/'; // Directory to store the profile picture
        $profile_file = $profile_dir . basename($_FILES['profile']['name']);
        move_uploaded_file($_FILES['profile']['tmp_name'], $profile_file);
        $profile = basename($_FILES['profile']['name']); // Save the filename
    }

    // Hash the default password
    $password = password_hash('vet123', PASSWORD_DEFAULT);

    // Insert the veterinarian into the database
    $sql = "INSERT INTO users (email, firstname, middlename, lastname, address, contact, valid_id_type, valid_id, profile, type, status, password) 
            VALUES ('$email', '$firstname', '$middlename', '$lastname', '$address', '$contact', '$valid_id_type', '$valid_id', '$profile', 1, 1, '$password')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Veterinarian added successfully.';
    } else {
        $_SESSION['error'] = 'Error adding veterinarian: ' . mysqli_error($conn);
    }

    header('location: veterinarians.php');
    exit();
}
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
              <h1 class="m-0">Veterinarians</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Veterinarians</li>
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
                  <button class="btn btn-primary" data-toggle="modal" data-target="#addVeterinarianModal">
                    <i class="fa fa-plus"></i> Add New Veterinarian
                  </button>
                </div>

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
                          <th>Vet ID</th>
                          <th>Profile</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT users.*, valid_id_type.name as valid_id_type_name FROM users 
                            LEFT JOIN valid_id_type ON users.valid_id_type = valid_id_type.id
                            WHERE users.status = 1 AND users.type = 1"; // Fetch users with type 1 (veterinarians)
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
                                <td><img src='" . $valid_id . "' height='70px' width='70px'></td>
                                <td><img src='" . $profile . "' height='70px' width='70px'></td>
                            </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='10'><center>No veterinarians found.</center></td></tr>";
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

    <!-- Add Veterinarian Modal -->
    <div class="modal fade" id="addVeterinarianModal" tabindex="-1" role="dialog" aria-labelledby="addVeterinarianModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addVeterinarianModalLabel">Add New Veterinarian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
              </div>
              <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" name="firstname" id="firstname" required>
              </div>
              <div class="form-group">
                <label for="middlename">Middle Name</label>
                <input type="text" class="form-control" name="middlename" id="middlename">
              </div>
              <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" name="lastname" id="lastname" required>
              </div>
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address">
              </div>
              <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" class="form-control" name="contact" id="contact">
              </div>
              <div class="form-group">
                <label for="valid_id_type">Valid ID Type</label>
                <select class="form-control" name="valid_id_type" id="valid_id_type">
                  <option value="Vet ID">Vet ID</option>
                </select>
              </div>
              <div class="form-group">
                <label for="valid_id">Upload Vet ID</label>
                <input type="file" class="form-control" name="valid_id" id="valid_id">
              </div>
              <div class="form-group">
                <label for="profile">Upload Profile Picture</label>
                <input type="file" class="form-control" name="profile" id="profile">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Veterinarian</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/users_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      $(document).on('click', '.approve', function(e) {
        e.preventDefault();
        $('#approve').modal('show');
        var id = $(this).data('id');
        $('#approveUserId').val(id); // Populate the hidden input field with the data-id value
      });

      $(document).on('click', '.denied', function(e) {
        e.preventDefault();
        $('#denied').modal('show');
        var id = $(this).data('id');
        $('#denyUserId').val(id); // Populate the hidden input field with the data-id value
      });

      $(document).on('click', '.status', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });
    });
  </script>
</body>

</html>