<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- select2 -->
<script src="plugins/select2/js/select2.min.js"></script>
<!-- sweetalert -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="plugins/fullcalendar/main.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



<script>
  $(document).ready(function() {
    // Initialize DataTable for #example1
    $('#example1').DataTable({
      "responsive": true,

    });
  });
</script>

<script>
  $(document).ready(function() {
    // Fetch provinces and populate the dropdown
    $.ajax({
      url: 'get_provinces.php',
      type: 'POST',
      success: function(response) {
        $('#province').html(response);
      }
    });
  });
  $(document).ready(function() {
    // Populate the municipality dropdown based on the selected province
    $('#province').change(function() {
      var provinceId = $(this).val();
      $.ajax({
        url: 'get_municipalities.php',
        type: 'POST',
        data: {
          province_id: provinceId
        },
        success: function(response) {
          $('#municipality').html(response);
        }
      });
    });

    // Populate the barangay dropdown based on the selected municipality
    $('#municipality').change(function() {
      var municipalityId = $(this).val();
      $.ajax({
        url: 'get_barangays.php',
        type: 'POST',
        data: {
          municipality_id: municipalityId
        },
        success: function(response) {
          $('#barangay').html(response);
        }
      });
    });
  });
</script>
<script>
  $(function() {
    $('#navbar-search-input').focus(function() {
      $('#searchBtn').show();
    });

    $('#navbar-search-input').focusout(function() {
      $('#searchBtn').hide();
    });

    getCart();

    $('#productForm').submit(function(e) {
      e.preventDefault();
      var product = $(this).serialize();
      $.ajax({
        type: 'POST',
        url: 'cart_add.php',
        data: product,
        dataType: 'json',
        success: function(response) {
          $('#callout').show();
          $('.message').html(response.message);
          if (response.error) {
            $('#callout').removeClass('callout-success').addClass('callout-danger');
          } else {
            $('#callout').removeClass('callout-danger').addClass('callout-success');
            getCart();
          }
        }
      });
    });

    $(document).on('click', '.close', function() {
      $('#callout').hide();
    });

  });

  function getCart() {
    $.ajax({
      type: 'POST',
      url: 'cart_fetch.php',
      dataType: 'json',
      success: function(response) {
        $('#cart_menu').html(response.list);
        $('.cart_count').html(response.count);
      }
    });
  }
</script>
<script>
  $(document).ready(function() {
    // Fetch species and populate the dropdown
    $.ajax({
      url: 'fetch_species.php',
      type: 'POST',
      success: function(response) {
        $('#species').html(response);
      }
    });

    // Populate the breed dropdown based on the selected species
    $('#species').change(function() {
      var speciesId = $(this).val();
      $.ajax({
        url: 'fetch_breeds.php',
        type: 'POST',
        data: {
          species_id: speciesId
        },
        success: function(response) {
          $('#breed').html(response);
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Fetch species and populate the dropdown
    $.ajax({
      url: 'fetch_pets.php', // Assuming fetch_species.php is correct, change it accordingly
      type: 'POST',
      success: function(response) {
        $('#pet').html(response);
      },
      error: function() {
        alert('Error fetching species data.');
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Fetch species and populate the dropdown
    $.ajax({
      url: 'fetch_veterinarian.php', // Assuming fetch_species.php is correct, change it accordingly
      type: 'POST',
      success: function(response) {
        $('#veterinarian').html(response);
      },
      error: function() {
        alert('Error fetching species data.');
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Fetch species and populate the dropdown
    $.ajax({
      url: 'fetch_services.php', // Assuming fetch_species.php is correct, change it accordingly
      type: 'POST',
      success: function(response) {
        $('#service').html(response);
      },
      error: function() {
        alert('Error fetching species data.');
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Initialize Select2 for multiple select
    $('.select2').select2({
      width: '100%'
    });

    // Populate vaccine type based on selected services
    $('#service_id').change(function() {
      var selectedServices = $(this).val();

      // Check if service_id=2 (vaccine) is selected
      if (selectedServices && selectedServices.includes('2')) {
        $('#vaccineTypeContainer').show();

        // Fetch vaccine types via AJAX
        $.ajax({
          url: 'fetch_vaccine_types.php',
          type: 'POST',
          data: {
            service_ids: selectedServices
          },
          success: function(response) {
            $('#vaccine_type').html(response);
          }
        });
      } else {
        $('#vaccineTypeContainer').hide();
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Initialize Select2 for multiple select
    $('.select2').select2({
      width: '100%'
    });

    // Populate vaccine type based on selected services
    $('#service_id').change(function() {
      var selectedServices = $(this).val();

      // Check if service_id=2 (vaccine) is selected
      if (selectedServices && selectedServices.includes('3')) {
        $('#dewormingContainer').show();

        // Fetch vaccine types via AJAX
        $.ajax({
          url: 'fetch_deworming.php',
          type: 'POST',
          data: {
            service_ids: selectedServices
          },
          success: function(response) {
            $('#deworming').html(response);
          }
        });
      } else {
        $('#dewormingContainer').hide();
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Initialize Select2 for multiple select
    $('.select2').select2({
      width: '100%'
    });

    // Populate vaccine type based on selected services
    $('#service_id').change(function() {
      var selectedServices = $(this).val();

      // Check if service_id=2 (vaccine) is selected
      if (selectedServices && selectedServices.includes('4')) {
        $('#surgeryContainer').show();

        // Fetch vaccine types via AJAX
        $.ajax({
          url: 'fetch_surgery.php',
          type: 'POST',
          data: {
            service_ids: selectedServices
          },
          success: function(response) {
            $('#surgery').html(response);
          }
        });
      } else {
        $('#surgeryContainer').hide();
      }
    });
  });
</script>