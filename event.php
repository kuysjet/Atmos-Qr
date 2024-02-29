<?php include 'includes/header.php'; ?>

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">

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
              <div class="mr-4 small"><b>Philippine Standard Time</b></div>
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
                    <!-- <th>Academic Year</th> -->
                    <th>Event Name</th>
                    <th>Venue</th>
                    <!-- <th>Description</th> -->
                    <th>Start DateTime</th>
                    <th>End DateTime</th>
                    <!-- <th>Respondent</th>
                    <th>Assigned Registrar</th> -->
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


<script>
$(function () {
  $("#eventsTable").DataTable({
    "responsive": true,
    "lengthChange": false, 
    "autoWidth": false,
    "orderable": true,
    "dom": 'Bfrtip', 
    "buttons": [
      {
        extend: 'colvis',
        text: '<i class="fas fa-eye"></i>',
        className: 'btn-sm btn-light border',
      }
    ],
  }).buttons().container().appendTo('#eventsTable_wrapper .col-md-6:eq(0)');
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
              <select class="form-control col-md-12" id="academicYear" name="academicYear">
                  <?php
                  // Establish a connection to the database
                  include 'database/db.php'; 

                  // Check if the connection is successful
                  if ($conn) {
                      // Query to select academic years
                      $query = "SELECT * FROM academic_years";

                      // Execute the query
                      $result = mysqli_query($conn, $query);

                      // Check if records are found
                      if (mysqli_num_rows($result) > 0) {
                          // Loop through each academic year
                          while ($row = mysqli_fetch_assoc($result)) {
                              // Output an option for each academic year
                              echo "<option value='" . $row['id'] . "'>" . $row['academic_year'] . "</option>";
                          }
                      } else {
                          echo "<option value=''>No academic years found</option>";
                      }

                      // Close the database connection
                      mysqli_close($conn);
                  } else {
                      echo "<option value=''>Connection failed</option>";
                  }
                  ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="eventName" class="form-label">Event Name</label>
              <input type="text" class="form-control" id="eventName" name="eventName">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="venue" class="form-label">Venue</label>
              <textarea class="form-control" id="venue" name="venue"></textarea>
            </div>

            <div class="col-md-6">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="startDatetime" class="form-label">Start Datetime</label>
              <input type="datetime-local" class="form-control" id="startDatetime" name="startDatetime">
            </div>

            <div class="col-md-6">
              <label for="endDatetime" class="form-label">End Datetime</label>
              <input type="datetime-local" class="form-control" id="endDatetime" name="endDatetime">
            </div>
          </div>

          <!-- Respondents and Registrar Select Dropdowns -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Respondents</label>
              <!-- Dropdown list with checkboxes for selecting respondents -->
              <select class="form-control col-md-12" id="respondents" name="respondents[]" multiple>
              <?php
                    // Establish a connection to the database
                    include 'database/db.php'; 

                    // Check if the connection is successful
                    if ($conn) {
                        // Query to select courses and levels from college_students
                        $query = "SELECT DISTINCT Course, Level FROM CollegeStudents";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='college:{$row['Course']}:{$row['Level']}'>{$row['Course']} - Level {$row['Level']}</option>";
                        }

                        // Query to select strands, grades, and sections from seniorhigh_students
                        $query = "SELECT DISTINCT Strand, Grade, Section FROM SeniorHighStudents";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='seniorhigh:{$row['Strand']}:{$row['Grade']}:{$row['Section']}'>{$row['Strand']} - Grade {$row['Grade']} - Section {$row['Section']}</option>";
                        }

                        // Query to select departments from faculties
                        $query = "SELECT DISTINCT DepartmentID FROM faculties";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Assuming you have a table 'departments' to fetch department names
                            $departmentQuery = "SELECT DepartmentName FROM Departments WHERE ID={$row['DepartmentID']}";
                            $departmentResult = mysqli_query($conn, $departmentQuery);
                            $departmentRow = mysqli_fetch_assoc($departmentResult);
                            echo "<option value='faculty:{$departmentRow['DepartmentName']}'>{$departmentRow['DepartmentName']}</option>";
                        }

                        // Close the database connection
                        mysqli_close($conn);
                    } else {
                        echo "<option value=''>Connection failed</option>";
                    }
                    ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="registrar" class="form-label">Registrar</label>
              <!-- Dropdown list for registrar -->
              <select class="form-control" id="registrar" name="registrar">
                  <?php
                  // Establish a connection to the database
                  include 'database/db.php'; 

                  // Check if the connection is successful
                  if ($conn) {
                      // Query to select registrars from the users table
                      $query = "SELECT u.id, CONCAT(u.firstname, ' ', u.lastname) AS name FROM users u JOIN user_types ut ON u.user_type_id = ut.id WHERE ut.name = 'registrar'";
                      $result = mysqli_query($conn, $query);

                      // Check if any registrars are found
                      if (mysqli_num_rows($result) > 0) {
                          // Loop through each registrar
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='{$row['id']}'>{$row['name']}</option>";
                          }
                      } else {
                          echo "<option value=''>No registrars found</option>";
                      }

                      // Close the database connection
                      mysqli_close($conn);
                  } else {
                      echo "<option value=''>Connection failed</option>";
                  }
                  ?>
              </select>
          </div>
        </form>
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



<script>
  // JavaScript code to show and hide modal
  document.getElementById('openModalBtn').addEventListener('click', function() {
    $('#addEventModal').modal('show');
  });

  // Optional: Close modal when Save button is clicked
  document.getElementById('saveEventBtn').addEventListener('click', function() {
    $('#addEventModal').modal('hide');
  });
</script>


</body>
</html>
