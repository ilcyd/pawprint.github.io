<?php
// Include necessary files
include('includes/header.php');
include('includes/session.php');

// Handle appointment deletion
if (isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];

    // Perform delete operation (soft delete by updating delete_flag)
    $delete_query = "UPDATE appointments SET delete_flag = 1 WHERE appointment_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $appointment_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
        exit; // Important: Stop further execution after successful deletion
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting appointment: ' . $conn->error]);
        exit;
    }
}

// Fetch appointments made by the current user
$userid = $user['id'];
$qry = mysqli_query($conn, "SELECT a.*, CONCAT(u.firstname, ' ', u.middlename, ' ', u.lastname) AS owner_name, p.pet_name
                            FROM appointments a
                            JOIN pets p ON a.pet_id = p.pet_id
                            JOIN users u ON a.owner_id = u.id
                            WHERE a.owner_id = $userid AND a.delete_flag = 0") or die(mysqli_error($conn));

// Format appointments for FullCalendar
$appointments = [];
while ($row = mysqli_fetch_array($qry)) {
    $appointments[] = [
        'id' => $row['id'],
        'title' => $row['owner_name'] . ' - ' . $row['pet_name'],
        'start' => $row['date'] . 'T' . $row['start_time'],
        'end' => $row['date'] . 'T' . $row['end_time'],
        'description' => $row['pet_name'], // You can add more details here
        'status' => $row['status'] // Add the status here
    ];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Appointments</title>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />

    <!-- Include Bootstrap CSS if necessary -->
    <link rel="stylesheet" href="path_to_your_bootstrap.css">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.11.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.11.0/main.min.js"></script>
</head>

<body class="layout-top-nav sidebar-collapse">
    <div class="wrapper">
        <?php include('includes/navbar.php'); ?>

        <div class="content-wrapper">
            <div class="container">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Your Appointments</h2>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Details Modal -->
        <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Owner Name:</strong> <span id="modal-owner-name"></span></p>
                        <p><strong>Pet Name:</strong> <span id="modal-pet-name"></span></p>
                        <p><strong>Date:</strong> <span id="modal-date"></span></p>
                        <p><strong>Start Time:</strong> <span id="modal-start-time"></span></p>
                        <p><strong>End Time:</strong> <span id="modal-end-time"></span></p>
                        <p><strong>Services:</strong> <span id="modal-service-names"></span></p>
                        <p><strong>Status:</strong> <span id="modal-status"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="cancel-appointment-btn" data-id="">Cancel Appointment</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
        <?php include('includes/appointment_modal.php'); ?>
    </div>

    <?php include('includes/scripts.php'); ?>

    <script>
        $(document).ready(function() {
            var calendar = new FullCalendar.Calendar($('#calendar')[0], {
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($appointments); ?>,
                eventClick: function(info) {
                    var appointment_id = info.event.id;
                    var status = info.event.extendedProps.status; // Retrieve the status

                    // Store the appointment ID in the cancel button
                    $('#cancel-appointment-btn').data('id', appointment_id);

                    // Check if the status is 1 and hide the cancel button if true
                    if (status == 1 || status == 2) {
                        $('#cancel-appointment-btn').hide();
                    } else {
                        $('#cancel-appointment-btn').show();
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'appointment_details.php',
                        data: {
                            'appointment_id': appointment_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Display the appointment details in the modal
                                $('#modal-owner-name').text(response.data.owner_name);
                                $('#modal-pet-name').text(response.data.pet_name);
                                $('#modal-date').text(response.data.date);
                                $('#modal-start-time').text(response.data.start_time);
                                $('#modal-end-time').text(response.data.end_time);
                                $('#modal-service-names').text(response.data.service_names);

                                // Display the status as "Pending" or "Approved"
                                var appointmentStatus;
                                if (response.data.status === 0) {
                                    appointmentStatus = "Pending"; // status = 0
                                } else if (response.data.status === 1) {
                                    appointmentStatus = "Approved"; // status = 1
                                } else if (response.data.status === 2) {
                                    appointmentStatus = "Done"; // status = 2
                                }

                                // Set the status text in the modal
                                $('#modal-status').text(appointmentStatus); // Assuming you have an element with the ID `modal-status` to display the status

                                // Show the modal
                                $('#appointmentModal').modal('show');
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Failed to load appointment details. Please try again.',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to load appointment details. Please try again.',
                                icon: 'error'
                            });
                        }
                    });
                }

            });

            // Render the calendar
            calendar.render();
        });

        // Handle cancellation of appointment
        $(document).on('click', '#cancel-appointment-btn', function() {
            var appointment_id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to cancel this appointment?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'appointment_delete.php',
                        data: {
                            'appointment_id': appointment_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('Cancelled!', 'The appointment has been cancelled.', 'success')
                                    .then(() => {
                                        location.reload(); // Reload the page to reflect changes
                                    });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error cancelling appointment:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to cancel the appointment. Please try again.',
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