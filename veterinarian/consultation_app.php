<?php
include 'includes/session.php';
include 'includes/header.php';

// Get consultation ID from the URL and validate it
$consultation_id = isset($_GET['consult_id']) ? intval($_GET['consult_id']) : 0;

// Updated SQL query
$sql = "
    SELECT c.weight, c.temperature, c.cbc, c.chw, c.ana, c.bab, c.ehr, c.diagnosis, c.prescription, c.schedule,
           p.pet_id, p.pet_name, p.gender, p.birthdate,
           s.species_name AS species_name, b.breed_name AS breed_name,
           u1.id AS owner_id, u1.firstname AS owner_firstname, u1.lastname AS owner_lastname,
           u2.id AS vet_id, u2.firstname AS vet_firstname, u2.lastname AS vet_lastname
    FROM consultation c
    LEFT JOIN pets p ON c.pet_id = p.pet_id
    LEFT JOIN species s ON p.species_id = s.species_id
    LEFT JOIN breeds b ON p.breed_id = b.breed_id
    LEFT JOIN users u1 ON p.owner_id = u1.id
    LEFT JOIN users u2 ON c.vet_id = u2.id
    WHERE c.consult_id = ?";


// Bind and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $consultation_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    echo "No consultation found for the provided ID.";
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
                                <form action="consult_insert.php" method="POST">
                                <input type="hidden" name="consult_id" value="<?php echo $consultation_id; ?>"> <!-- Pass the correct consultation ID -->

    <input type="hidden" name="pet_id" value="<?php echo $consultation['pet_id']; ?>">
    <input type="hidden" name="owner_id" value="<?php echo $consultation['owner_id']; ?>">
    <input type="hidden" name="vet_id" value="<?php echo $consultation['vet_id']; ?>">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="weight" class="form-label"><strong>Weight:</strong></label>
                                                <div class="input-group">
                                                    <input type="text" name="weight" id="weight" class="form-control" required placeholder="Enter weight">
                                                    <span class="input-group-text">kg</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="temperature" class="form-label"><strong>Temperature:</strong></label>
                                                <div class="input-group">
                                                    <input type="text" name="temperature" id="temperature" class="form-control" required placeholder="Enter temperature">
                                                    <span class="input-group-text">°C</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="cbc" class="form-label"><strong>CBC (Complete Blood Count):</strong></label>
                                                <input type="text" name="cbc" id="cbc" class="form-control" placeholder="Enter CBC results">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="chw" class="form-label"><strong>CHW (Clinical Health Worker Assessment):</strong></label>
                                                <input type="text" name="chw" id="chw" class="form-control" placeholder="Enter CHW assessment">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="ana" class="form-label"><strong>ANA (Antinuclear Antibody Test):</strong></label>
                                                <input type="text" name="ana" id="ana" class="form-control" placeholder="Enter ANA results">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="bab" class="form-label"><strong>BAB (Bordetella Antibody Test):</strong></label>
                                                <input type="text" name="bab" id="bab" class="form-control" placeholder="Enter BAB results">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="ehr" class="form-label"><strong>EHR (Electronic Health Record):</strong></label>
                                                <input type="text" name="ehr" id="ehr" class="form-control" placeholder="Enter EHR information">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="diagnosis" class="form-label"><strong>Diagnosis:</strong></label>
                                                <input type="text" name="diagnosis" id="diagnosis" class="form-control" placeholder="Enter diagnosis">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="prescription" class="form-label"><strong>Prescription:</strong></label>
                                            <input type="text" name="prescription" id="prescription" class="form-control" placeholder="Enter prescription details">
                                        </div>

                                        <?php
// Set the timezone to Philippines
date_default_timezone_set('Asia/Manila');

// Check if the current date is the scheduled date
$scheduled_date = new DateTime($consultation['schedule']);
$today = new DateTime();
$today->setTime(0, 0); // Set time to 00:00:00 for today


if ($scheduled_date->format('Y-m-d') === $today->format('Y-m-d')) {
    echo '<button type="submit" class="btn btn-success">Insert Data</button>';
}
?>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End of Details Row -->
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/scripts.php'; ?>
    </div>
</body>
</html>
