<style>
  /* Custom CSS to change the color of selected services in Select2 dropdown to blue */
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff;
    /* Change the background color of selected services to blue */
    color: #fff;
    /* Change the text color of selected services to white */
    border-color: #007bff;
    /* Change the border color of selected services to blue */
  }
</style>

<!-- Set Appointment for Pets -->
<div class="modal fade" id="set" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Set Appointment for Pets</b></h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

        <form class="form-horizontal" method="POST" action="appointment_add.php">
          <p id="displaySelectedDate"></p>
          <input type="hidden" id="selectedDateInput" name="appointment_date">

          <div class="form-group">

            <label for="pet" class="col-sm-3 control-label">Pet's Name</label>
            <div class="col-sm-9">
              <select class="form-control" id="pet" name="pet" required>
                <option value="">Select Pet</option>
                <!-- Options will be dynamically populated -->
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="veterinarian" class="col-sm-3 control-label">Veterinarian</label>
            <div class="col-sm-9">
              <select class="form-control" id="veterinarian" name="veterinarian" required>
                <option value="">Select Veterinarian</option>
                <!-- Options will be dynamically populated -->
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="service_id" class="control-label">Service(s)</label>
            <select name="service_id[]" id="service_id" class="form-control form-control-border select2" multiple required>
              <option value="" disabled>Select Service(s)</option>
              <?php
              $services_query = "SELECT service_id, service_name, price FROM services";
              $services_result = $conn->query($services_query);
              while ($row = $services_result->fetch_assoc()):
                // Check if the price is NULL and format the option accordingly
                $display_text = $row['service_name'];
                if (!is_null($row['price'])) {
                  $display_text .= " (₱" . $row['price'] . ")";
                }
              ?>
                <option value="<?= $row['service_id'] ?>"><?= $display_text ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div id="vaccineTypeContainer" class="form-group" style="display: none;">
            <label for="vaccine_type" class="col-sm-3 control-label">Vaccine Type</label>
            <div class="col-sm-9">
              <select class="form-control" id="vaccine_type" name="vaccine_type">
                <?php
                $query = "SELECT * FROM vaccine_types";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                  // Build options for vaccine types dropdown
                  $options = '<option value="">Select Vaccine Type</option>';
                  while ($row = mysqli_fetch_assoc($result)) {
                    $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '(₱' . $row['price'] . ')</option>';
                  }
                  echo $options;
                } else {
                  echo '<option value="">No Vaccine Types available</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div id="dewormingContainer" class="form-group" style="display: none;">
            <label for="deworming" class="col-sm-3 control-label">Deworming Type</label>
            <div class="col-sm-9">
              <select class="form-control" id="deworming" name="deworming">
                <?php
                $query = "SELECT * FROM deworming";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                  // Build options for deworming types dropdown
                  $options = '<option value="">Select Deworming Type</option>';
                  while ($row = mysqli_fetch_assoc($result)) {
                    $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '(₱' . $row['price'] . ')</option>';
                  }
                  echo $options;
                } else {
                  echo '<option value="">No Deworming Types available</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div id="surgeryContainer" class="form-group" style="display: none;">
            <label for="surgery" class="col-sm-3 control-label">Surgery Type</label>
            <div class="col-sm-9">
              <select class="form-control" id="surgery" name="surgery">
                <?php
                $query = "SELECT * FROM surgery";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                  // Build options for surgery types dropdown
                  $options = '<option value="">Select Surgery Type</option>';
                  while ($row = mysqli_fetch_assoc($result)) {
                    $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '(₱' . $row['price'] . ')</option>';
                  }
                  echo $options;
                } else {
                  echo '<option value="">No Surgery Types available</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                class="fa fa-close"></i>
              Close</button>
            <button type="submit" class="btn btn-success btn-flat" name="set_appointment"><i
                class="fa fa-check-square-o"></i>
              Set Appointment</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var appointmentTimeSelect = document.getElementById('appointment_time');
    var appointmentDateInput = document.getElementById('appointment_date');
    var serviceIdSelect = document.getElementById('service_id');
    var vaccineTypeContainer = document.getElementById('vaccineTypeContainer');
    var dewormingContainer = document.getElementById('dewormingContainer');
    var surgeryContainer = document.getElementById('surgeryContainer');
    var now = new Date();
    var currentHour = now.getHours();
    var currentMinute = now.getMinutes();

    // Fetch open_time and close_time from PHP variables
    var openTime = '<?php echo '09:00'; ?>'; // Example: '09:00'
    var closeTime = '<?php echo '21:30'; ?>'; // Example: '21:30'

    // Convert openTime and closeTime to Date objects for comparison
    var openTimeDate = parseTime(openTime);
    var closeTimeDate = parseTime(closeTime);

    // Function to populate appointment times based on selected date
    function populateAppointmentTimes(selectedDate) {
      var isToday = isSameDate(selectedDate, now);

      // Clear existing options
      appointmentTimeSelect.innerHTML = '';

      // Populate the select with time options in 30-minute intervals
      var nextValidTime = new Date(selectedDate);
      nextValidTime.setHours(openTimeDate.hour);
      nextValidTime.setMinutes(openTimeDate.minute);

      // Generate time options from openTime to closeTime
      while (nextValidTime.getHours() < closeTimeDate.hour || (nextValidTime.getHours() === closeTimeDate.hour && nextValidTime.getMinutes() <= closeTimeDate.minute)) {
        var option = document.createElement('option');
        var timeString = formatAMPM(nextValidTime) + ' - ' + formatAMPM(new Date(nextValidTime.getTime() + 30 * 60000)); // 30 minutes later
        option.value = timeString;
        option.textContent = timeString;
        appointmentTimeSelect.appendChild(option);

        nextValidTime.setMinutes(nextValidTime.getMinutes() + 30);
      }

      // Handle service-specific logic (toggle containers based on services selected)
      serviceIdSelect.addEventListener('change', function() {
        toggleServiceOptions();
      });

      toggleServiceOptions(); // Initial toggle based on selected services

    }

    function toggleServiceOptions() {
      // Hide all containers by default
      vaccineTypeContainer.style.display = 'none';
      dewormingContainer.style.display = 'none';
      surgeryContainer.style.display = 'none';

      var selectedServiceIds = Array.from(serviceIdSelect.selectedOptions).map(option => option.value);

      if (selectedServiceIds.includes('1')) { // Assume 1 = vaccine service
        vaccineTypeContainer.style.display = 'block';
      }
      if (selectedServiceIds.includes('2')) { // Assume 2 = deworming service
        dewormingContainer.style.display = 'block';
      }
      if (selectedServiceIds.includes('3')) { // Assume 3 = surgery service
        surgeryContainer.style.display = 'block';
      }
    }

    function formatAMPM(date) {
      var hours = date.getHours();
      var minutes = date.getMinutes();
      var ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12; // 12-hour format
      minutes = minutes < 10 ? '0' + minutes : minutes;
      return hours + ':' + minutes + ' ' + ampm;
    }

    function parseTime(timeString) {
      var timeParts = timeString.split(':');
      return {
        hour: parseInt(timeParts[0]),
        minute: parseInt(timeParts[1])
      };
    }

    function isSameDate(date1, date2) {
      return date1.getDate() === date2.getDate() && date1.getMonth() === date2.getMonth() && date1.getFullYear() === date2.getFullYear();
    }

    // Initialize the appointment time dropdown
    populateAppointmentTimes(now);
  });
</script>