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
              <h1 class="m-0">Inventory</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">All Sub Category</li>
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
                  <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i
                      class="fa fa-plus"></i> New</a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Main Category</th>
                          <th>Sub Category Name</th>
                          <th>Tools</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT subcategory.*, category.name AS category_name 
                        FROM subcategory 
                        LEFT JOIN category ON category.id = subcategory.category_id 
                          WHERE subcategory.delete_flag = 0";
                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                            <tr>
                              <td>" . $row['category_name'] . "</td>
                              <td>" . $row['name'] . "</td>
                              <td>
                                <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['id'] . "'> Edit</button>
                                <button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'> Delete</button>
                              </td>
                            </tr>
                            ";
                          }
                        } else {
                          echo "<tr><td colspan='3'>No subcategories found.</td></tr>";
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
    <?php include 'includes/subcategory_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function () {
      $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        $('#delete').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'subcategory_row.php',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
          $('.subcatid').val(response.id);
          $('#edit_name').val(response.name);
          $('#edit_category_id').val(response.category_id);
          $('.subcatname').html(response.name);
        }
      });
    }

  </script>
</body>

</html>