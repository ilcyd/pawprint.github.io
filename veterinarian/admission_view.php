<?php
include 'includes/session.php';
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
    </div>

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 justify-content-center">
        <div class="col-sm-12 text-center">
          <h1 class="h3 mb-0 text-gray-800">Pet Patient Record</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row"> <!-- Begin of Row -->
        <div class="col-xl-8 col-md-8 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">PET NAME</div>
                </div>
                <div class="col mr-2">
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    Sample Pet Name
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-4 ml-auto">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">OWNER NAME</div>
                </div>
                <div class="col mr-2">
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    Sample Owner Name
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- End of Row -->

      <div class="row"><!-- Begin Details Row -->
        <div class="col-lg-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-success">Details</h6>
            </div>
            <div class="card-body">
              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Species</div>
              <div class="h5 mb-1 font-weight-bold text-gray-800">Dog</div>

              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Breed</div>
              <div class="h5 mb-1 font-weight-bold text-gray-800">Shih Tzu</div>

              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Sex</div>
              <div class="h5 mb-1 font-weight-bold text-gray-800">Male</div>
              
              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Birthdate</div>
              <div class="h5 mb-1 font-weight-bold text-gray-800">2014-07-25</div>

              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Age</div>
              <div class="h5 mb-1 font-weight-bold text-gray-800">deducted from birthdate</div>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-success">Admission Details</h6>
    </div>
    <div class="card-body">
      <div class="mb-4">
        <p><strong>Cage Admitted:</strong> Sample Cage A</p>
        <p><strong>Admission Date:</strong> 2024-10-01</p>
        <p><strong>Discharge Date:</strong> 2024-10-10</p>
        <p><strong>Reason for Admission:</strong> Routine check-up</p>
        <p><strong>Veterinarian In Charge:</strong> Dr. Jane Doe</p>
        <p><strong>Special Instructions:</strong> Monitor for 24 hours post-admission</p>
        <p><strong>Date Recorded:</strong> 2024-10-01</p>
      </div>
    </div>
  </div>
</div>





      </div><!-- End of Details Row -->
    </div>
  </section>
</div>

<?php include 'includes/footer.php'; ?>

<?php include 'includes/scripts.php'; ?>
</body>
</html>
