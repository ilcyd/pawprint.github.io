<?php
include 'includes/session.php';
include 'includes/header.php';
$currentDate = date('Y-m-d');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Vaccination</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">All Vaccination</li>
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
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Owner Name</th>
                          <th>Pet Name</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT v.id, v.owner_id, v.pet_id, CONCAT(u.firstname, ' ', u.middlename, ' ', u.lastname) AS owner_name,
                                   p.pet_name
                               FROM vaccination v
                               INNER JOIN users u ON v.owner_id = u.id
                               INNER JOIN pets p ON v.pet_id = p.pet_id
                               WHERE v.delete_flag = 0";

                        // Prepare statement
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result && $result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            echo "
                              <tr>
                                <td>" . $row['owner_name'] . "</td>
                                <td>" . $row['pet_name'] . "</td>
                                <td>
                                  <button class='btn btn-primary btn-sm view-details' 
                                          data-owner-id='" . $row['owner_id'] . "' 
                                          data-pet-id='" . $row['pet_id'] . "' 
                                          data-vaccine-id='" . $row['id'] . "'
                                          data-toggle='modal' 
                                          data-target='#vaccinationModal'>
                                    View Details
                                  </button>
                                </td>
                              </tr>
                            ";
                          }
                        } else {
                          echo "<tr><td colspan='3'>No vaccinations found.</td></tr>";
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

    <!-- Vaccination Details Modal -->
    <div class="modal fade" id="vaccinationModal" tabindex="-1" role="dialog" aria-labelledby="vaccinationModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="vaccinationModalLabel">Vaccination Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="vaccinationDetails"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <?php include 'includes/footer.php'; ?>
  </div>

  <?php include 'includes/scripts.php'; ?>

  <script>
    $(document).ready(function () {
      // Handle click event on view details button
      $(document).on('click', '.view-details', function () {
        var ownerId = $(this).data('owner-id');
        var petId = $(this).data('pet-id');
        var vaccineId = $(this).data('vaccine-id');

        $.ajax({
          type: 'POST',
          url: 'get_vaccination_details.php',
          data: { owner_id: ownerId, pet_id: petId, id: vaccineId },
          dataType: 'html',
          success: function (response) {
            $('#vaccinationDetails').html(response);
            // Set vaccine id in the form for update
            $('#vaccineId').val(vaccineId);
            $('#vaccinationModal').modal('show');
          },
          error: function () {
            alert('Error retrieving vaccination details.');
          }
        });
      });

      // Handle form submission for updating schedule and marking done
      $(document).on('submit', '#updateScheduleForm', function (e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $(this);
        var vaccineId = form.find('input[name="vaccine_id"]').val();
        var newSchedule = form.find('input[name="new_schedule"]').val();
        var vaccineType = form.find('input[name="vaccine_type"]').val();

        // Calculate next schedule based on vaccine type
        var nextSchedule;
        var daysToAdd = vaccineType === 'Vaccination' ? 15 : 30; // Adjust the condition based on your vaccine types
        var newDate = new Date(newSchedule);
        newDate.setDate(newDate.getDate() + daysToAdd);
        nextSchedule = newDate.toISOString().split('T')[0];

        // Make AJAX request to update the vaccination schedule
        $.ajax({
          type: 'POST',
          url: 'vaccine_update_schedule.php',
          data: {
            vaccine_id: vaccineId,
            new_schedule: newSchedule,
            next_schedule: nextSchedule,
            status: 1 // Marking the first vaccine as done
          },
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              alert('Schedule updated successfully.');
              $('#vaccinationModal').modal('hide');
              location.reload(); // Reload the page to reflect changes
            } else {
              alert('Failed to update schedule. Please try again.');
            }
          },
          error: function () {
            alert('Error updating schedule.');
          }
        });
      });

      // Handle click event on "Done" button
      $(document).on('click', '.mark-done', function () {
        var vaccineId = $(this).data('vaccine-id');

        $.ajax({
          type: 'POST',
          url: 'vaccine_update_status.php', // PHP script to handle status update
          data: {
            vaccine_id: vaccineId,
            status: 1 // Mark as done
          },
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              alert('Vaccination status updated to done.');
              location.reload(); // Reload the page to reflect changes
            } else {
              alert('Failed to update status. Please try again.');
            }
          },
          error: function () {
            alert('Error updating status.');
          }
        });
      });
      // Handle click event on "Done" button
      $(document).on('click', '.mark-done2', function () {
        var vaccineId = $(this).data('vaccine-id');

        $.ajax({
          type: 'POST',
          url: 'vaccine_update_status2.php', // PHP script to handle status update
          data: {
            vaccine_id: vaccineId,
            status: 1 // Mark as done
          },
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              alert('Vaccination status updated to done.');
              location.reload(); // Reload the page to reflect changes
            } else {
              alert('Failed to update status. Please try again.');
            }
          },
          error: function () {
            alert('Error updating status.');
          }
        });
      });
    });
  </script>

</body>

</html>