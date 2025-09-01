<?php
// Include necessary files
include ('includes/header.php');
include ('includes/session.php');

// Handle pet deletion
if (isset($_POST['pet_id'])) {
  $pet_id = $_POST['pet_id'];

  // Perform delete operation (soft delete by updating delete_flag)
  $delete_query = "UPDATE pets SET delete_flag = 1 WHERE pet_id = ?";
  $stmt = $conn->prepare($delete_query);
  $stmt->bind_param("i", $pet_id);

  if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
    exit; // Important: Stop further execution after successful deletion
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Error deleting pet: ' . $conn->error]);
    exit;
  }

}

// Fetch pets data
$userid = $user['id'];
$qry = mysqli_query($conn, "SELECT p.*, s.species_name AS species_name, b.breed_name AS breed_name
                            FROM pets p
                            JOIN species s ON p.species_id = s.species_id
                            JOIN breeds b ON p.breed_id = b.breed_id
                            WHERE p.owner_id = $userid AND p.delete_flag = 0") or die(mysqli_error($conn));
                            // Calculate age

?>

<style>
  .content-wrapper {
            background-image: url('images/bg1.jpg');
            background-size: cover;
            /* or use 'contain' if you want to see the entire image */
            background-position: center;
            /* centers the image */
            background-repeat: no-repeat;
            /* prevents the image from repeating */
            height: 100vh;
            /* makes the wrapper take the full height of the viewport */
        }
</style>

<body class="layout-top-nav sidebar-collapse">
  <div class="wrapper">
    <?php include ('includes/navbar.php'); ?>

    <div class="content-wrapper">
      <div class="container">
        <div class="content">
          <div class="row">
            <div class="col-sm-12">
              <!-- <h2>Your Pets</h2> -->
              <!-- Button to trigger modal -->
              <button type="button" class="btn btn-primary mb-3 mt-5" data-toggle="modal" data-target="#addPetModal">
                Add New Pet
              </button>
              <table class="table table-striped" id="example1" style="width: 100%;" >
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Species</th>
                    <th>Breed</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_array($qry)) {
                    $birthdate = new DateTime($row['birthdate']);
                    $today = new DateTime();
                    $age = $today->diff($birthdate); ?>
                    <tr>
                      <td><?php echo $row['pet_name']; ?></td>
                      <td><?php echo $row['species_name']; ?></td>
                      <td><?php echo $row['breed_name']; ?></td>
                      <td><?php echo $row['gender']; ?></td>
                      <td>
                      <?php 
                      echo $age->y . ' years and ' . $age->m . ' months old';
                    ?>
                      </td>
                      <td>
                        <form method="post" class="delete-pet-form">
                          <input type="hidden" name="pet_id" value="<?php echo $row['pet_id']; ?>">
                          <button type="button" class="btn btn-danger delete-pet-btn">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col-sm-9 -->

            <!-- /.col-sm-3 -->
          </div><!-- /.row -->
        </div><!-- /.content -->
      </div><!-- /.container -->
    </div><!-- /.content-wrapper -->

    <?php include ('includes/footer.php'); ?>
    <?php include ('includes/pet_modal.php'); ?>
    <?php include ('includes/appointment_modal.php'); ?>
  </div><!-- ./wrapper -->

  <?php include ('includes/scripts.php'); ?>

  <script>
    // AJAX request to handle pet deletion
    $(document).on('click', '.delete-pet-btn', function () {
      var form = $(this).closest('form');
      var pet_id = form.find('input[name="pet_id"]').val();

      Swal.fire({
        title: 'Delete Pet',
        text: 'Are you sure you want to delete this pet?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: 'pet_delete.php',
            data: {
              'pet_id': pet_id
            },
            dataType: 'json', // Expect JSON response
            success: function (response) {
              if (response.status === 'success') {
                Swal.fire({
                  title: 'Deleted!',
                  text: 'Pet has been deleted.',
                  icon: 'success'
                }).then((result) => {
                  location.reload(); // Reload the page after deletion
                });
              } else {
                Swal.fire({
                  title: 'Error',
                  text: 'Failed to delete pet. Please try again.',
                  icon: 'error'
                });
              }
            },
            error: function (xhr, status, error) {
              console.error('Error deleting pet:', error);
              Swal.fire({
                title: 'Error',
                text: 'Failed to delete pet. Please try again.',
                icon: 'error'
              });
            }
          });
        }
      });
    });
  </script>
</body>

</html>