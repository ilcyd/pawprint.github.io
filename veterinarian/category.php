<?php
// Include necessary files
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
              <h1 class="m-0">Appointments</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">All Appointments</li>
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
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Appointment Details Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Content to display appointment details -->
            <div id="appointmentDetails"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Custom Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id="confirmationMessage">Are you sure you want to proceed with this action?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="confirmAction">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <?php include 'includes/footer.php'; ?>
  </div>

  <?php include 'includes/scripts.php'; ?>

  <script>
    $(document).ready(function() {
      // Fetch appointments from the server
      $.ajax({
        type: 'POST',
        url: 'get_appointments_for_calendar.php', // Fetch data for the calendar
        dataType: 'json',
        success: function(data) {
          // Initialize FullCalendar
          var calendar = new FullCalendar.Calendar($('#calendar')[0], {
            initialView: 'dayGridMonth',
            events: data.events,
            eventClick: function(info) {
              var appointmentId = info.event.id;
              $.ajax({
                type: 'POST',
                url: 'get_appointment_details.php',
                data: {
                  id: appointmentId
                },
                dataType: 'html',
                success: function(response) {
                  $('#appointmentDetails').html(response);
                  $('#appointmentModal').modal('show');
                },
                error: function(xhr, status, error) {
                  alert('Error retrieving appointment details.');
                }
              });
            },
          });

          // Render the calendar
          calendar.render();
        },
        error: function(xhr, status, error) {
          alert('Error loading appointments.');
        }
      });

      // Handle 'Approve' button click
      $(document).on('click', '#approve-btn', function() {
        var appointmentId = $(this).data('id');

        // Update the confirmation message dynamically and show the confirmation modal
        $('#confirmationMessage').text('Are you sure you want to approve this appointment?');
        $('#confirmationModal').data('action', 'approve').data('id', appointmentId).modal('show');
      });

      // Handle 'Mark as Done' button click
      $(document).on('click', '#mark-done-btn', function() {
        var appointmentId = $(this).data('id');

        // Update the confirmation message dynamically and show the confirmation modal
        $('#confirmationMessage').text('Are you sure you want to mark this appointment as done?');
        $('#confirmationModal').data('action', 'done').data('id', appointmentId).modal('show');
      });

      // Handle the confirmation button click in the confirmation modal
      $('#confirmAction').click(function() {
        var action = $('#confirmationModal').data('action');
        var appointmentId = $('#confirmationModal').data('id');

        if (action === 'approve') {
          // Approve the appointment
          $.ajax({
            type: 'POST',
            url: 'appointment_approve.php', // This will approve the appointment
            data: {
              id: appointmentId
            },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                alert('Appointment approved successfully.');
                $('#appointmentModal').modal('hide'); // Close the appointment modal
                location.reload(); // Reload the page to update the status (this will work now)
              } else {
                alert('Failed to approve the appointment.');
                location.reload(); // Reload the page to update the status (this will work now)

              }
            },
            error: function(xhr, status, error) {
              console.error('Error:', error);
              alert('Error approving the appointment.');
              location.reload(); // Reload the page to update the status (this will work now)

            }
          });
        } else if (action === 'done') {
          // Mark the appointment as done
          $.ajax({
            type: 'POST',
            url: 'mark_as_done.php', // This will update the status to "Done"
            data: {
              appointment_id: appointmentId
            },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                alert('Appointment marked as done.');
                $('#appointmentModal').modal('hide'); // Close the appointment modal
                location.reload(); // Reload the page to reflect the updated status
              } else {
                alert('Failed to mark appointment as done.');
              }
            },
            error: function(xhr, status, error) {
              console.error('Error:', error);
              alert('Error marking appointment as done.');
            }
          });
        }

        // Close the confirmation modal
        $('#confirmationModal').modal('hide');
      });

    });
  </script>

</body>

</html>