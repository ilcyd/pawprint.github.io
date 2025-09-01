<!-- Modal for adding a new pet -->
<div class="modal fade" id="addPetModal" tabindex="-1" role="dialog" aria-labelledby="addPetModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPetModalLabel">Add New Pet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for adding a new pet -->
        <form method="post" action="pet_add.php" id="addPetForm">
          <div class="form-group">
            <label for="pet_name">Pet Name</label>
            <input type="text" class="form-control" id="pet_name" name="pet_name" required>
          </div>
          <div class="form-group">
            <label for="species">Species</label>
            <select class="form-control" id="species" name="species" required>
              <option value="">Select Species</option>
              <!-- Options will be added dynamically -->
            </select>
          </div>
          <div class="form-group">
            <label for="breed">Breed</label>
            <select class="form-control" id="breed" name="breed" required>
              <option value="">Select Breed</option>
              <!-- Options will be added dynamically -->
            </select>
          </div>
          <div class="form-group">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label for="birthdate">Birthdate</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
          </div>
          <div class="form-group">
            <label for="vaccinated">Has your pet been vaccinated?</label>
            <select class="form-control" id="vaccinated" name="vaccinated" required>
              <option value="">Select</option>
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
          <div id="vaccine_div" style="display: none;">
            <div class="form-group">
              <label for="vaccine_type">What vaccine did your pet receive?</label>
              <select class="form-control" id="vaccine_type" name="vaccine_type">
                <option value="">Select Vaccine</option>
                <!-- Options will be added dynamically -->
              </select>
            </div>
          </div>

          <!-- You can add more fields as necessary -->

          <button type="submit" class="btn btn-primary" name="add_pet">Add Pet</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for dynamic display of vaccine type dropdown -->
<script>
  $(document).ready(function () {
    $('#species').change(function () {
      var speciesId = $(this).val();
      $.ajax({
        url: 'get_vaccines.php',
        type: 'GET',
        data: { species_id: speciesId },
        success: function (data) {
          var vaccineSelect = $('#vaccine_type');
          vaccineSelect.empty();
          vaccineSelect.append('<option value="">Select Vaccine</option>');
          $.each(data, function (index, vaccine) {
            vaccineSelect.append('<option value="' + vaccine.id + '">' + vaccine.name + '</option>');
          });
        }
      });
    });

    $('#vaccinated').change(function () {
      toggleVaccineSelect();
    });

    function toggleVaccineSelect() {
      var vaccinatedSelect = document.getElementById('vaccinated');
      var vaccineDiv = document.getElementById('vaccine_div');

      if (vaccinatedSelect.value === '1') {
        vaccineDiv.style.display = 'block'; // Show vaccine type dropdown
      } else {
        vaccineDiv.style.display = 'none'; // Hide vaccine type dropdown
      }
    }
  });
</script>