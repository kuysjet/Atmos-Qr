<?php 
include 'database/db.php'; 

include 'includes/header.php'; 

?>

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">
  <!-- Multiselect option cdn-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

<style>
/* Custom CSS for multiselect options */
.multiselect-container li a:hover {
    background-color: #007bff !important; /* Primary color */
    color: #fff !important; /* Text color */
    width: 100%; /* Max width */
    display: block; /* Ensure full width */
}

.multiselect-container li.active a {
    background-color: #007bff !important; /* Primary color */
    color: #fff !important; /* Text color */
    width: 100%; /* Max width */
    display: block; /* Ensure full width */
}

</style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


<?php 
  include 'includes/navbar.php';
  include 'includes/sidebar.php';
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3>Event</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-12 text-sm-right">
              <div class="mr-2 small"><b>Philippine Standard Time</b></div>
            </div>
            <div class="col-sm-12 text-sm-right">
              <div id="philippine-date-time" class="small"></div>
            </div>
          </div>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="card">
              <div class="card-header">
                <marquee width="100%" direction="left"> <b>A t t e n d a n c e &nbsp; M o n i t o r i n g &nbsp; - &nbsp; Q R &nbsp; C o d e</b></marquee>
              </div>
              <div class="card-header m-0">
                <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addEventModal">
                  <i class="fas fa-th-list"></i> Add New
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="eventsTable" class="display table table-bordered">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Event Name</th>
                    <th>Venue</th>
                    <th>Start DateTime</th>
                    <th>End DateTime</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include 'includes/footer.php';?>
  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/datetime.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

<script>
  $(document).ready(function() {
    // Destroy existing DataTable instance
    if ($.fn.DataTable.isDataTable('#eventsTable')) {
      $('#eventsTable').DataTable().destroy();
    }

    // Initialize DataTable with new settings
    var table = $('#eventsTable').DataTable({
      "ajax": "crud_events.php",
      "columns": [
        { "data": null, "render": function(data, type, row, meta) {
            return meta.row + 1; // Add auto-increment number starting from 1
          }
        },
        { "data": "event_name" },
        { "data": "event_venue" },
        { "data": "start_datetime" },
        { "data": "end_datetime" },
        {
          "data": null,
          "render": function(data, type, row) {
            return '<i class="fas fa-edit edit-btn text-success mr-2" title="Edit"></i>' +
                  '<i class="fas fa-trash-alt delete-btn text-danger" title="Delete"></i>';
          }
        }
      ],
      "responsive": true,
      "lengthChange": false, 
      "autoWidth": false,
      "dom": 'Bfrtip', 
      "buttons": [
        {
          extend: 'colvis',
          text: '<i class="fas fa-eye"></i>',
          className: 'btn-sm btn-light border',
        }
      ]
  }).buttons().container().appendTo('#eventsTable_wrapper .col-md-6:eq(0)');


// Handle form submission
$('#addEventForm').submit(function(event) {
    event.preventDefault(); // Prevent default form submission

    // Serialize form data
    var formData = $(this).serialize();

    // Send Ajax request to add the event
    $.ajax({
        url: 'add_event.php', // PHP script to handle insertion
        method: 'POST',
        data: formData,
        dataType: 'json', // Expect JSON response
        success: function(response) {
            // Check if insertion was successful
            if (response.status === 'success') {
                // Clear form fields
                $('#addEventForm')[0].reset();
                // Close the modal
                $('#addEventModal').modal('hide');
                // Reload DataTable to display the new event
                $('#eventTable').DataTable().ajax.reload();
                // Show success message using SweetAlert
                Swal.fire({
                    title: 'Success',
                    text: 'Event added successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                // Show error message using SweetAlert
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to add event.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            // Show error message using SweetAlert
            Swal.fire({
                title: 'Error',
                text: 'Failed to add event. Error: ' + error,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});





});



</script>




<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for adding a new event -->
        <form id="addEventForm">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="academicYear" class="form-label">Academic Year</label>
              <select class="form-control col-md-12" id="academicYear" name="academicYear" required>
                  <option value="">Select Academic Year</option>
                  <?php
                  // Query to select academic years
                  $query = "SELECT * FROM academic_years";

                  // Execute the query
                  $result = mysqli_query($conn, $query);

                  // Check if records are found
                  if ($result && mysqli_num_rows($result) > 0) {
                      // Loop through each academic year
                      while ($row = mysqli_fetch_assoc($result)) {
                          // Output an option for each academic year
                          echo "<option value='" . $row['id'] . "'>" . $row['academic_year'] . "</option>";
                      }
                  } else {
                      echo "<option value=''>No academic years found</option>";
                  }
                  ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="eventName" class="form-label">Event Name</label>
              <input type="text" class="form-control" id="eventName" name="eventName" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="venue" class="form-label">Event Venue</label>
              <textarea class="form-control" id="venue" name="venue" required></textarea>
            </div>

            <div class="col-md-6">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="startDatetime" class="form-label">Start Datetime</label>
              <input type="datetime-local" class="form-control" id="startDatetime" name="startDatetime" required>
            </div>

            <div class="col-md-6">
              <label for="endDatetime" class="form-label">End Datetime</label>
              <input type="datetime-local" class="form-control" id="endDatetime" name="endDatetime" required>
            </div>
          </div>

          <!-- Registrar Select Dropdown -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="registrar" class="form-label">Registrar</label>
              <!-- Dropdown list for registrar -->
              <select class="form-control" id="registrar" name="registrar" required>
                  <option value="">Select Registrar</option>
                  <?php
                  // Check if the connection is successful
                  if ($conn) {
                      // Query to select registrars from the users table
                      $query = "SELECT u.id, CONCAT(u.firstname, ' ', u.lastname) AS name FROM users u JOIN user_types ut ON u.user_type_id = ut.id WHERE ut.name = 'registrar'";
                      $result = mysqli_query($conn, $query);

                      // Check if any registrars are found
                      if ($result && mysqli_num_rows($result) > 0) {
                          // Loop through each registrar
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='{$row['id']}'>{$row['name']}</option>";
                          }
                      } else {
                          echo "<option value=''>No registrars found</option>";
                      }
                  } else {
                      echo "<option value=''>Connection failed</option>";
                  }
                  ?>
              </select>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
          <i class="fas fa-times"></i> Close
        </button>
        <button type="button" class="btn btn-primary btn-sm" id="saveEventBtn">
          <i class="fas fa-save"></i> Save
        </button>
      </div>
    </div>
  </div>
</div>




<!-- <script>
$(document).ready(function() {
    $('#respondents').multiselect({
        buttonWidth: '100%', // Adjust as needed
        maxHeight: 200, // Adjust as needed
        onChange: function(option, checked) {
            // Check if "Add All" option is selected
            if ($(option).val() === 'all') {
                if (checked) {
                    // Select all other options
                    $('#respondents option').not(':selected').prop('selected', true);
                } else {
                    // Deselect all other options
                    $('#respondents option:selected').prop('selected', false);
                }
                // Update the multiselect
                $('#respondents').multiselect('refresh');
            }
        }
    });
});
</script> -->


</body>
</html>
