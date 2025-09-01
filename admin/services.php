<?php
// Include session management
include 'includes/session.php';
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
 <div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
   <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
  </div>

  <?php
  // Include navbar and sidebar
  include 'includes/navbar.php';
  include 'includes/sidebar.php';
  ?>

  <div class="content-wrapper">
   <div class="content-header">
    <div class="container-fluid">
     <div class="row mb-2">
      <div class="col-sm-6">
       <h1 class="m-0">Services</h1>
      </div>
      <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Services</li>
       </ol>
      </div>
     </div>
    </div>
   </div>

   <section class="content">
    <div class="container-fluid">
     <div class="row">
      <div class="col">
       <div class="card">
        <div class="card-header">
         <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="addservices"><i
           class="fa fa-plus"></i> New</a>
        </div>
        <div class="card-body">
         <div class="table-responsive">
          <table id="example1" class="table table-bordered table-striped">
           <thead>
            <tr>
             <th>Service Name</th>
             <th>Price</th>
             <th>Tools</th>
            </tr>
           </thead>
           <tbody>
            <?php
            // Query to fetch services based on WHERE clause
            $sql = "SELECT * FROM services WHERE delete_flag = 0";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
             while ($row = mysqli_fetch_assoc($result)) {
              echo "
                                                        <tr>
                                                            <td>" . $row['service_name'] . "</td>
                                                            <td>" . $row['price'] . "</td>
                                                            <td>
                                                                <button class='btn btn-success btn-sm edit btn-flat'
                                                                    data-service_id='" . $row['service_id'] . "'> Edit</button>
                                                                <button class='btn btn-danger btn-sm delete btn-flat'
                                                                    data-service_id='" . $row['service_id'] . "'> Delete</button>
                                                            </td>
                                                        </tr>
                                                        ";
             }
            } else {
             echo "<tr><td colspan='3'>No services found.</td></tr>";
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

  <?php
  // Include footer and modal for editing services
  include 'includes/footer.php';
  include 'includes/service_modal.php';
  ?>
 </div>

 <?php
 // Include scripts for functionality
 include 'includes/scripts.php';
 ?>

 <script>
  $(function () {
   $(document).on('click', '.edit', function (e) {
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('service_id');
    console.log('Edit ID:', id); // Debugging: Log the ID
    getRow(id);
   });

   $(document).on('click', '.delete', function (e) {
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('service_id');
    console.log('Delete ID:', id); // Debugging: Log the ID
    getRow(id);
   });
  });

  function getRow(id) {
   $.ajax({
    type: 'POST',
    url: 'service_row.php',
    data: {
     service_id: id
    },
    dataType: 'json',
    success: function (response) {
     console.log('Response:', response); // Debugging: Log the response
     $('.serid').val(response.id);
     $('#edit_name').val(response.name);
     $('#edit_price').val(response.price);
    },
    error: function (xhr, status, error) {
     console.error('AJAX Error:', status, error); // Debugging: Log AJAX errors
    }
   });
  }
 </script>
</body>

</html>