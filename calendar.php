<?php
include('includes/header.php');
include('includes/session.php');
?>
<style>
    /* Make sure clickable days (enabled) have a pointer cursor */
    .fc-daygrid-day:not(.fc-daygrid-day-disabled),
    .fc-timegrid-slot-lane:not(.fc-timegrid-slot-disabled) {
        cursor: pointer;
        /* Pointer cursor for enabled slots */
    }

    /* Make sure disabled days/times have a normal cursor and are not interactive */
    .fc-daygrid-day-disabled,
    .fc-timegrid-slot-disabled {
        pointer-events: none;
        /* Disable clicks */
        opacity: 0.3;
        /* Gray out past dates/times */
        cursor: not-allowed;
        /* Change cursor to 'not-allowed' for disabled slots */
    }

    /* Ensure the pointer cursor is not shown on disabled days */
    .fc-daygrid-day.fc-daygrid-day-disabled,
    .fc-timegrid-slot-lane.fc-timegrid-slot-disabled {
        cursor: not-allowed !important;
        /* Force 'not-allowed' cursor on disabled days */
        background-color: #f8f9fa;
        /* Slightly lighten disabled days' background */
    }
</style>

<body class="hold-transition layout-top-nav sidebar-collapse">
    <div class="wrapper">
        <?php include('includes/navbar.php'); ?>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <!-- /.col -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


    <!-- /.content-wrapper -->
    <?php include('includes/footer.php'); ?>
    <?php include('includes/appointment_modal.php'); ?>
    </div><!-- ./wrapper -->

    <?php include('includes/scripts.php'); ?>
    <script>
  $(document).ready(function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true, // Allow selecting days and times
        validRange: {
            start: new Date() // Allow selecting today and future dates
        },
        select: function(info) {
            var selectedDate = info.start.toLocaleDateString('en-CA'); // Get the date in 'YYYY-MM-DD' format

            // Display the selected date in the <p> element
            $('#displaySelectedDate').text('Selected Date: ' + selectedDate);

            // Set the selected date in the hidden input field
            $('#selectedDateInput').val(selectedDate);

            // Show the modal
            $('#set').modal('show');
        },
        contentHeight: 'auto' // Adjust the height of the calendar dynamically
    });

    calendar.render();
});

// To retrieve the selected date from the hidden input field
function getSelectedDate() {
    var selectedDate = $('#selectedDateInput').val();
    console.log("Selected date: " + selectedDate);
    return selectedDate;
}

</script>
</body>

</html>