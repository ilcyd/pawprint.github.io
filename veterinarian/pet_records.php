<?php
include 'includes/session.php';
include 'includes/header.php';

// Get pet_id and owner_id from the URL
$pet_id = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0;
$owner_id = isset($_GET['owner_id']) ? intval($_GET['owner_id']) : 0;

// Fetch pet details including species and breed names
$sql = "SELECT 
            pets.pet_name, 
            users.firstname, 
            users.lastname, 
            species.species_name,
            breeds.breed_name,
            pets.gender, 
            pets.birthdate 
        FROM pets 
        LEFT JOIN users ON pets.owner_id = users.id 
        LEFT JOIN species ON pets.species_id = species.species_id
        LEFT JOIN breeds ON pets.breed_id = breeds.breed_id
        WHERE pets.pet_id = $pet_id";
$result = mysqli_query($conn, $sql);
$pet = mysqli_fetch_assoc($result);

$vaccineSql = "
    SELECT 
        v.id, 
        v.schedule, 
        v.vet_id, 
        v.weight, 
        v.manufacturer, 
        u.firstname,
        u.lastname,
        vt.name AS type 
    FROM 
        vaccination v
    LEFT JOIN 
        vaccine_types vt ON v.type = vt.id 
    LEFT JOIN
        users u ON v.vet_id = u.id
    WHERE 
        v.pet_id = $pet_id
";

$vaccines = mysqli_query($conn, $vaccineSql);

$vaccineRecSql = "
    SELECT 
        vr.vr_id, 
        vr.date_taken, 
        vr.vet_id, 
        vr.weight, 
        vr.manufacturer, 
        u.firstname,
        u.lastname,
        vt.name AS type 
    FROM 
        vaccine_records vr
    LEFT JOIN 
        vaccine_types vt ON vr.type = vt.id 
    LEFT JOIN
        users u ON vr.vet_id = u.id
    WHERE 
        vr.pet_id = $pet_id
";

$vaccinesRec = mysqli_query($conn, $vaccineRecSql);

// Fetch consultations for the pet
$consultationSql = "
    SELECT 
          c.consult_id, 
          c.vet_id, 
          c.pet_id,
          c.schedule,
          u.firstname,
          u.lastname
      FROM 
          consultation c
      LEFT JOIN
          users u ON c.vet_id = u.id
      WHERE 
          c.pet_id = $pet_id";
$consultations = mysqli_query($conn, $consultationSql);

// Fetch consultations record for the pet
$consultationRecSql = "
    SELECT 
          cr.cr_id, 
          cr.vet_id, 
          cr.pet_id,
          cr.date_recorded,
          u.firstname,
          u.lastname
      FROM 
          consult_records cr
      LEFT JOIN
          users u ON cr.vet_id = u.id
      WHERE 
          cr.pet_id = $pet_id";
$consultationsRec = mysqli_query($conn, $consultationRecSql);
?>

<body class="hold-transition sidebar-mini layout-fixed">
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
                      <?php echo htmlspecialchars($pet['pet_name']); ?>
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
                      <?php echo htmlspecialchars($pet['firstname'] . ' ' . $pet['lastname']); ?>
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
                <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($pet['species_name']); ?></div>

                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Breed</div>
                <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($pet['breed_name']); ?></div>

                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Sex</div>
                <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($pet['gender']); ?></div>

                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Birthdate</div>
                <div class="h5 mb-1 font-weight-bold text-gray-800"><?php echo htmlspecialchars($pet['birthdate']); ?></div>

                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Age</div>
                <div class="h5 mb-1 font-weight-bold text-gray-800">
                  <?php
                  $birthdate = new DateTime($pet['birthdate']);
                  $today = new DateTime();
                  $age = $today->diff($birthdate);
                  echo $age->y . ' years and ' . $age->m . ' months old';
                  ?>
                </div>

              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <!-- Tab Links -->
            <ul class="nav nav-tabs" id="petTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="vaccine-tab" data-toggle="tab" href="#vaccine" role="tab" aria-controls="vaccine" aria-selected="true">Vaccines</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="consultation-tab" data-toggle="tab" href="#consultation" role="tab" aria-controls="consultation" aria-selected="false">Consultations</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
              </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="petTabsContent">
              <div class="tab-pane fade show active" id="vaccine" role="tabpanel" aria-labelledby="vaccine-tab">
                <h6 class="m-0 font-weight-bold text-success">Appointment</h6>
                <div class="table-responsive">
                  <table class="table table-bordered" id="example1" cellspacing="0">
                    <thead>
                      <tr>
                        <th class="text-center">Date to be Taken</th>
                        <th class="text-center">Weight</th>
                        <th class="text-center">Against</th>
                        <th class="text-center">Manufacturer</th>
                        <th class="text-center">Veterinarian</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($vaccine = mysqli_fetch_assoc($vaccines)): ?>
                        <tr>
                          <td class="text-center"><?php echo htmlspecialchars($vaccine['schedule']); ?></td>
                          <td class="text-center"><?php echo htmlspecialchars($vaccine['weight']); ?></td>
                          <td class="text-center">
                            <b>
                              <a class="btn btn-success rounded-pill" href="vaccine_app.php?id=<?php echo htmlspecialchars($vaccine['id']); ?>">
                                <?php echo htmlspecialchars($vaccine['type']); ?>
                              </a>
                            </b>
                          </td>
                          <td class="text-center"><?php echo htmlspecialchars($vaccine['manufacturer']); ?></td>
                          <td class="text-center">
                            <?php echo htmlspecialchars($vaccine['firstname']) . ' ' . htmlspecialchars($vaccine['lastname']); ?>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>

              </div>
              <div class="tab-pane fade" id="consultation" role="tabpanel" aria-labelledby="consultation-tab">
                <h6 class="m-0 font-weight-bold text-success">Appointment</h6>
                <div class="table-responsive">
                  <table class="table table-bordered" id="example3" cellspacing="0">
                    <thead>
                      <tr>
                        <th class="text-center">Appointment Consultation</th>
                        <th class="text-center">Veterinarian</th>
                        <th class="text-center">Date to be Taken</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($consultation = mysqli_fetch_assoc($consultations)): ?>
                        <tr>
                          <td class="text-center">
                            <b>
                              <a class="btn btn-success rounded-pill" href="consultation_app.php?consult_id=<?php echo htmlspecialchars($consultation['consult_id']); ?>">
                                Consultation
                              </a>
                            </b>
                          </td>
                          <td class="text-center">
                            <?php echo htmlspecialchars($consultation['firstname']) . ' ' . htmlspecialchars($consultation['lastname']); ?>
                          </td>
                          <td class="text-center"><?php echo htmlspecialchars($consultation['schedule']); ?></td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                <h6 class="m-0 font-weight-bold text-success">History of Vaccinations</h6>
                <div class="table-responsive">
                  <table class="table table-bordered" id="example2" cellspacing="0">
                    <thead>
                      <tr>
                        <th class="text-center">Date Taken</th>
                        <th class="text-center">Weight</th>
                        <th class="text-center">Against</th>
                        <th class="text-center">Manufacturer</th>
                        <th class="text-center">Veterinarian</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while ($vaccineRec = mysqli_fetch_assoc($vaccinesRec)): ?>
                        <tr>
                          <td class="text-center"><?php echo htmlspecialchars($vaccineRec['date_taken']); ?></td>
                          <td class="text-center"><?php echo htmlspecialchars($vaccineRec['weight']); ?></td>
                          <td class="text-center">
                            <b>
                              <a class="btn btn-success rounded-pill" href="vaccine_view.php?id=<?php echo htmlspecialchars($vaccineRec['vr_id']); ?>">
                                <?php echo htmlspecialchars($vaccineRec['type']); ?>
                              </a>
                            </b>
                          </td>
                          <td class="text-center"><?php echo htmlspecialchars($vaccineRec['manufacturer']); ?></td>
                          <td class="text-center">
                            <?php echo htmlspecialchars($vaccineRec['firstname']) . ' ' . htmlspecialchars($vaccineRec['lastname']); ?>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
                <h6 class="m-0 font-weight-bold text-success">History of Consultations</h6>
                <div class="table-responsive">
                  <table class="table table-bordered" id="example2" cellspacing="0">
                    <thead>
                      <tr>
                        <th class="text-center">History of Consultations</th>
                        <th class="text-center">Veterinarian</th>
                        <th class="text-center">Date Consulted</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($consultationRec = mysqli_fetch_assoc($consultationsRec)): ?>
                        <tr>
                          <td class="text-center">
                            <b>
                              <a class="btn btn-success rounded-pill" href="consultation_view.php?id=<?php echo htmlspecialchars($consultationRec['cr_id']); ?>">
                                Consultation
                              </a>
                            </b>
                          </td>
                          <td class="text-center">
                            <?php echo htmlspecialchars($consultationRec['firstname']) . ' ' . htmlspecialchars($consultationRec['lastname']); ?>
                          </td>
                          <td class="text-center"><?php echo htmlspecialchars($consultationRec['date_recorded']); ?></td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
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
</body>

</html>