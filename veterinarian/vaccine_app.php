<?php
include 'includes/session.php';
include 'includes/header.php';

// Get vaccination ID from the URL and validate it
$vaccination_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch vaccination details, including the associated pet, veterinarian, and owner
$sql = "
    SELECT v.schedule AS vaccine_schedule, vt.name AS vaccine_name, 
           p.pet_name, p.gender, p.birthdate, 
           s.species_name AS species_name, b.breed_name AS breed_name,
           u_owner.firstname AS owner_firstname, u_owner.lastname AS owner_lastname,
           u_vet.firstname AS vet_firstname, u_vet.lastname AS vet_lastname,
           p.owner_id AS owner_id
    FROM vaccination v
    LEFT JOIN pets p ON v.pet_id = p.pet_id
    LEFT JOIN vaccine_types vt ON v.type = vt.id
    LEFT JOIN species s ON p.species_id = s.species_id
    LEFT JOIN breeds b ON p.breed_id = b.breed_id
    LEFT JOIN users u_owner ON p.owner_id = u_owner.id
    LEFT JOIN users u_vet ON v.vet_id = u_vet.id
    WHERE v.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vaccination_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit;
}

$vaccination = $result->fetch_assoc();
if (!$vaccination) {
    echo "No vaccination found for the provided ID.";
    exit;
}

// Calculate age
$birthdate = new DateTime($vaccination['birthdate']);
$today = new DateTime();
$age = $today->diff($birthdate);

// Fetch vaccination records for the pet
// Fetch vaccination record for the specific vaccination ID
$sqlVaccines = "
    SELECT v.schedule, vt.name AS vaccine_name, 
           u_vet.firstname AS vet_firstname, u_vet.lastname AS vet_lastname, 
           v.next_schedule, v.notes, v.pet_id, v.vet_id, v.type, v.id
    FROM vaccination v
    LEFT JOIN vaccine_types vt ON v.type = vt.id
    LEFT JOIN users u_vet ON v.vet_id = u_vet.id
    WHERE v.id = ?";  // Only fetching for the specific vaccination record, based on v.id


$stmtVaccines = $conn->prepare($sqlVaccines);
$stmtVaccines->bind_param("i", $vaccination_id);
$stmtVaccines->execute();
$vaccines = $stmtVaccines->get_result();
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

          <div class="row">
            <div class="col-xl-8 col-md-8 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">PET NAME</div>
                    </div>
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo htmlspecialchars($vaccination['pet_name']); ?>
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
                        <?php echo htmlspecialchars($vaccination['owner_firstname'] . ' ' . $vaccination['owner_lastname']); ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-success">Details</h6>
                </div>
                <div class="card-body">
                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Species</div>
                  <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($vaccination['species_name']); ?></div>

                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Breed</div>
                  <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($vaccination['breed_name']); ?></div>

                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Sex</div>
                  <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($vaccination['gender']); ?></div>

                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Birthdate</div>
                  <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($vaccination['birthdate']); ?></div>

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
      <h6 class="m-0 font-weight-bold text-success">Vaccination</h6>
    </div>
    <div class="card-body">
      <?php while ($vaccine = $vaccines->fetch_assoc()): ?>
        <div class="mb-3">
          <p><strong>Vaccine Type:</strong> <?php echo htmlspecialchars($vaccine['vaccine_name']); ?></p>
          <p><strong>Veterinarian:</strong> <?php echo htmlspecialchars($vaccine['vet_firstname'] . ' ' . $vaccine['vet_lastname']); ?></p>
          <form action="vaccine_insert.php" method="POST">
            <input type="text" name="notes" class="form-control" placeholder="Enter notes here">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($vaccine['id']); ?>">
            <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($vaccine['pet_id']); ?>">
            <input type="hidden" name="owner_id" value="<?php echo htmlspecialchars($vaccination['owner_id']); ?>"> <!-- Add this line -->
            <input type="hidden" name="vaccine_schedule" value="<?php echo htmlspecialchars($vaccination['vaccine_schedule']); ?>">
            <input type="hidden" name="vaccine_id" value="<?php echo htmlspecialchars($vaccine['type']); ?>">
            <input type="hidden" name="vet_id" value="<?php echo htmlspecialchars($vaccine['vet_id']); ?>">

            <?php
            // Check if the current date is the scheduled date
            $scheduled_date = new DateTime($vaccination['vaccine_schedule']);
            $today = new DateTime();
            $today->setTime(0, 0); // Set time to 00:00:00 for today

            if ($scheduled_date->format('Y-m-d') === $today->format('Y-m-d')) {
                echo '<button type="submit" class="btn btn-success">Vaccine Injected</button>';
            }
            ?>
          </form>
        </div>
        <hr>
      <?php endwhile; ?>
    </div>
  </div>
</div>

          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
  </div>
</body>
</html>
