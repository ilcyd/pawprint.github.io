<?php
include 'includes/session.php';
include 'includes/header.php';

// Get consultation ID from the URL and validate it
$consultation_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch consultation details from consult_records along with associated pet and owner
$sql = "
    SELECT cr.cr_id, cr.owner_id, cr.pet_id, cr.vet_id, cr.weight, cr.temperature, cr.cbc, cr.chw, cr.ana, cr.bab, cr.ehr, 
           cr.diagnosis, cr.prescription, cr.date_recorded, 
           p.pet_name, p.gender, p.birthdate,
           s.species_name AS species_name, b.breed_name AS breed_name,
           u.firstname AS owner_firstname, u.lastname AS owner_lastname
    FROM consult_records cr
    LEFT JOIN pets p ON cr.pet_id = p.pet_id
    LEFT JOIN species s ON p.species_id = s.species_id
    LEFT JOIN breeds b ON p.breed_id = b.breed_id
    LEFT JOIN users u ON p.owner_id = u.id
    WHERE cr.cr_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $consultation_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    echo "No consultation found for the provided ID." ;
    exit;
}

$consultation = mysqli_fetch_assoc($result);

// Calculate age
$birthdate = new DateTime($consultation['birthdate']);
$today = new DateTime();
$age = $today->diff($birthdate);

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
        <button onclick="window.history.back();" class="btn btn-secondary mb-3">Back</button>

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
                        <?php echo htmlspecialchars($consultation['pet_name']); ?>
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
                        <?php echo htmlspecialchars($consultation['owner_firstname'] . ' ' . $consultation['owner_lastname']); ?>
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
                  <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($consultation['species_name']); ?></div>

                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Breed</div>
                  <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($consultation['breed_name']); ?></div>

                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Sex</div>
                  <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($consultation['gender']); ?></div>

                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Birthdate</div>
                  <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($consultation['birthdate']); ?></div>

                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Age</div>
                  <div class="h5 mb-1 font-weight-bold text-gray-800">
                    <?php 
                      echo $age->y . ' years and ' . $age->m . ' months old';
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-8">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-success">Consultation Details</h6>
                </div>
                <div class="card-body">
                  <div class="mb-4">
                    <p><strong>Weight:</strong> <?php echo htmlspecialchars($consultation['weight']); ?> kg</p>
                    <p><strong>Temperature:</strong> <?php echo htmlspecialchars($consultation['temperature']); ?> °C</p>
                    <p><strong>CBC (Complete Blood Count):</strong> <?php echo htmlspecialchars($consultation['cbc']); ?></p>
                    <p><strong>CHW (Clinical Health Worker Assessment):</strong> <?php echo htmlspecialchars($consultation['chw']); ?></p>
                    <p><strong>ANA (Antinuclear Antibody Test):</strong> <?php echo htmlspecialchars($consultation['ana']); ?></p>
                    <p><strong>BAB (Bordetella Antibody Test):</strong> <?php echo htmlspecialchars($consultation['bab']); ?></p>
                    <p><strong>EHR (Electronic Health Record):</strong> <?php echo htmlspecialchars($consultation['ehr']); ?></p>
                    <p><strong>Diagnosis:</strong> <?php echo htmlspecialchars($consultation['diagnosis']); ?></p>
                    <p><strong>Prescription:</strong> <?php echo htmlspecialchars($consultation['prescription']); ?></p>
                    <p><strong>Date Taken:</strong> <?php echo htmlspecialchars($consultation['date_recorded']); ?></p>
                  </div>
                </div>
              </div>
            </div><!-- End of Details Row -->
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
  </div>
</body>
</html>
