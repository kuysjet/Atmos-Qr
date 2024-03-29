<?php
session_start();

include 'database/db.php';

// Check if the user is not logged in or is not a registrar
if (!isset($_SESSION['username']) || $_SESSION['user_type_id'] != 2) {
    // Redirect to the login page
    header('Location: index.php');
    exit(); // Stop further execution
}

// Fetch the ID of the logged-in registrar and their first name and last name
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    // No registrar found with the given username
    echo "Error: Registrar not found.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$registrarId = $row['id'];
$firstName = $row['firstname'];
$lastName = $row['lastname'];
$email = $row['email'];

// Fetch events assigned to the logged-in registrar with their academic years
$query = "SELECT events.*, academic_years.academic_year 
          FROM events 
          INNER JOIN academic_years ON events.academic_year_id = academic_years.id
          WHERE events.registrar_id = $registrarId AND academic_years.status = 'Active'";
$result = mysqli_query($conn, $query);


// Fetch academic years from the academic_years table
$academicYearsQuery = "SELECT * FROM academic_years";
$academicYearsResult = mysqli_query($conn, $academicYearsQuery);

// Check if query was successful
if ($academicYearsResult && mysqli_num_rows($academicYearsResult) > 0) {
    // Academic years found, generate options for academic years dropdown
    $academicYearsOptions = '';
    while ($yearRow = mysqli_fetch_assoc($academicYearsResult)) {
        $academicYearsOptions .= '<option value="' . $yearRow['academic_year'] . '">' . $yearRow['academic_year'] . '</option>';
    }
} else {
    // No academic years found
    $academicYearsOptions = '<option value="">No Academic Years Found</option>';
}

// Fetch events related to the selected academic year
$eventsQuery = "SELECT * FROM events";
$eventsResult = mysqli_query($conn, $eventsQuery);

// Check if query was successful
if ($eventsResult && mysqli_num_rows($eventsResult) > 0) {
    // Events found, display them
    $eventsList = '<option value="">Select Event</option>';
    while ($eventRow = mysqli_fetch_assoc($eventsResult)) {
        $eventsList .= '<option value="' . $eventRow['id'] . '">' . $eventRow['event_name'] . '</option>';
    }
} else {
    // No events found
    $eventsList = '<option value="">No Events Found</option>';
}


?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="dist/img/icon.png">
  <title>ATMOS | Report</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Include Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  -->
  <link rel="stylesheet" href="dist/css/dark-table.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="//code.highcharts.com/css/highcharts.css">
  
  

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="registrar_dashboard.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- Dark mode toggle link -->
      <li class="nav-item">
        <a href="#" class="nav-link" id="darkModeToggleBtn">
          <i class="fas fa-moon"></i>
          <i class="fas fa-sun text-warning d-none"></i>
        </a>
      </li>
      <!-- Profile -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user fa-fw text-gray"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <a class="dropdown-item" id="profileDropdown" href="#" role="button" data-toggle="modal" data-target="#viewProfileModal">
            <i class="fas fa-user-cog fa-sm fa-fw mr-2 text-gray"></i> Profile
            <span class="float-right text-muted text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" id="changePasswordDropdown" href="#" role="button" data-toggle="modal" data-target="#changePasswordModal">
            <i class="fas fa-key fa-sm fa-fw mr-2 text-gray"></i> Change Password
            <span class="float-right text-muted text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray"></i> Logout
              <span class="float-right text-muted text-sm"></span>
          </a>

        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->



  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="https://www.facebook.com/ACLCCollegeIRIGA/" class="brand-link"">
      <img src="dist/img/amalogo.png" alt="ACLC Logo" class="brand-image img-circle elevation-2" style="opacity: .8; width: 32px;">
      <span class="brand-text" style="font-size: small;"><b>ACLC COLLEGE IRIGA INC.</b></span>
    </a>

    <!-- active link change -->
    <?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <i class="fas fa-user-cog fa-lg mr-2 text-gray pl-1 mt-2"></i>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo "$firstName $lastName"; ?></a>
        </div>
      </div>

      <!-- Get the current page filename without path -->
      <?php $page = basename($_SERVER['PHP_SELF']);?>  

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="registrar_dashboard.php" class="nav-link <?= $page == 'registrar_dashboard.php' ? 'active text-white' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="registrar_report.php" class="nav-link <?= $page == 'registrar_report.php' ? 'active text-white' : '' ?>">
              <i class="fas fa-chart-bar nav-icon"></i>
              <p>Reports</p>
            </a>
          </li>
            
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3>Report</h3>
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
      <div id="demo-output" style="margin-bottom: 1em;" class="chart-display"></div>
      <div class="card">
              <div class="card-header">
                <marquee width="100%" direction="left"> <b>A t t e n d a n c e &nbsp; M o n i t o r i n g &nbsp; - &nbsp; Q R &nbsp; C o d e</b></marquee>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mb-2">
                  <div class="col-md-3">
                    <label class="m-0" for="academicYearFilter">Academic Year:</label>
                      <select id="academicYearFilter" class="form-control">`
                      <option value="" disabled selected>Select Academic Year</option>
                      <?php echo $academicYearsOptions; ?>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <label class="m-0" for="eventsFilter">Events:</label>
                      <select id="eventsFilter" class="form-control">
                      <option value="" disabled selected>Select Event</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <label class="m-0" for="userTypeFilter">Filter by Registrant Type:</label>
                      <select id="userTypeFilter" class="form-control">
                          <option value="" disabled selected>Select Registrant Type</option>
                          <option value="college">College</option>
                          <option value="high_school">Senior High</option>
                          <option value="faculty">Faculty</option>
                      </select>
                  </div>
                </div>
                <div class="card shadow-md">
                    <div class="card-body">
                        <div class="row mb-6">
                            <!-- Event Name column -->
                            <div class="col-md-6">
                                <strong>Event Name:</strong>
                                <p id="eventName"></p>
                            </div>
                            <!-- Event Description column -->
                            <div class="col-md-6">
                                <strong>Event Description:</strong>
                                <p id="eventDescription"></p>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <!-- Event Venue column -->
                            <div class="col-md-6">
                                <strong>Event Venue:</strong>
                                <p id="eventVenue"></p>
                            </div>
                            <!-- Event Date -->
                            <div class="col-md-2">
                                <strong>Event Date:</strong>
                                <p id="eventDate"></p>
                            </div>
                            <!-- Event Login Time column -->
                            <div class="col-md-2">
                                <strong>Login Time:</strong>
                                <p id="loginTime"></p>
                            </div>
                            <!-- Event Logout Time column -->
                            <div class="col-md-2">
                                <strong>Logout Time:</strong>
                                <p id="logoutTime"></p>
                            </div>
                        </div>
                      </div>
                  </div>
                  <table id="reportTable" class="display table table-bordered" style="display: none;">
                    <thead>
                      <tr>
                          <th>No.</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th class="course-header">Course</th>
                          <th class="level-header">Level</th>
                          <th class="strand-header">Strand</th>
                          <th class="grade-header">Grade</th>
                          <th class="section-header">Section</th>
                          <th class="position-header">Position</th>
                          <th>Time In</th>
                          <th>Time Out</th>
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
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<script src="//code.highcharts.com/highcharts.js"></script>
<!-- <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/datetime.js"></script>

<script>
  $(document).ready(function(){
    $('#academicYearFilter').change(function(){
        var academicYear = $(this).val();
        $.ajax({
            url: 'report_get_events.php',
            type: 'post',
            data: {academicYear: academicYear},
            success:function(response){
                $('#eventsFilter').html(response);
            }
        });
        // Reset the filter by user type dropdown to "Select User Type"
        $('#userTypeFilter').val('');
    });

    $('#eventsFilter').change(function(){
        var eventId = $(this).val();
        if(eventId) {
            $.ajax({
                url: 'report_fetch_event_details.php',
                type: 'post',
                data: {eventId: eventId},
                success:function(response){
                    var eventData = JSON.parse(response);
                    // Update event details in the card
                    $('#eventName').text(eventData.event_name);
                    $('#eventDescription').text(eventData.description);
                    $('#eventVenue').text(eventData.event_venue);
                    $('#eventDate').text(eventData.event_date);
                    $('#loginTime').text(eventData.log_in);
                    $('#logoutTime').text(eventData.log_out);
                }
            });
            // Fetch attendance data for the selected event
            $.ajax({
                url: 'report_fetch_attendance.php',
                type: 'post',
                data: {eventId: eventId},
                success:function(response){
                    $('#reportTable tbody').html(response);
                }
            });
            // Reset the filter by user type dropdown to "Select User Type"
            $('#userTypeFilter').val('');
        } else {
            // If no event is selected, clear event details in the card
            $('#eventName').text('');
            $('#eventDescription').text('');
            $('#eventVenue').text('');
            $('#eventDate').text('');
            $('#loginTime').text('');
            $('#logoutTime').text('');
            // Clear attendance table
            $('#reportTable tbody').empty();
        }
    });

    // Function to get event data from the card
    function getEventDataFromCard() {
        var eventData = {};

        // Get the content of each event detail from the card
        eventData.eventName = $('#eventName').text().trim();
        eventData.eventDescription = $('#eventDescription').text().trim();
        eventData.eventVenue = $('#eventVenue').text().trim();
        eventData.eventDate = $('#eventDate').text().trim();
        eventData.loginTime = $('#loginTime').text().trim();
        eventData.logoutTime = $('#logoutTime').text().trim();

        return eventData;
    }

    // DataTable initialization
    var table = $("#reportTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "orderable": true,
        "dom": 'Bfrtip', // Ensure the buttons container is included
        "buttons": [
            {
                extend: 'collection',
                text: '<i class="fas fa-file-export"></i>',
                className: 'btn-sm btn-light border mr-1',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="far fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: ':visible' // Only include visible columns in the print
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="far fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: ':visible' // Only include visible columns in the print
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        exportOptions: {
                            columns: ':visible' // Only include visible columns in the print
                    },
                        customize: function(win) {
                            var eventData = getEventDataFromCard();
                            // Prepend event details above the table in two columns with borders in the print view
                            $(win.document.body).prepend(
                        '<div class="print-header">' +
                            '<table class="event-details">' +
                                '<tr style="border: 1px solid #ddd;">' +
                                    '<td><strong>Event Name:</strong></td>' +
                                    '<td colspan="6">' + eventData.eventName + '</td>' +
                                    '<td><strong>Event Venue:</strong></td>' +
                                    '<td colspan="6">' + eventData.eventVenue + '</td>' +
                                '</tr>' +
                                '<tr style="border: 1px solid #ddd;">' +
                                    '<td><strong>Event Description:</strong></td>' +
                                    '<td colspan="12">' + eventData.eventDescription + '</td>' +
                                '</tr>' +
                                '<tr style="border: 1px solid #ddd;">' +
                                    '<td><strong>Event Date:</strong></td>' +
                                    '<td colspan="3">' + eventData.eventDate + '</td>' +
                                    '<td><strong>Login Time:</strong></td>' +
                                    '<td colspan="3">' + eventData.loginTime + '</td>' +
                                    '<td><strong>Logout Time:</strong></td>' +
                                    '<td colspan="3">' + eventData.logoutTime + '</td>' +
                                    
                                '</tr>' +
                        
                            '</table>' +
                            '<style>' +
                                '.print-header { margin-bottom: 20px; }' +
                                '.event-details { border-collapse: collapse; width: 100%; }' +
                                '.event-details th, .event-details td { border: 1px solid #ddd; padding: 8px; }' +
                                '.dataTables_info { display: none; }' + // Hide table title
                            '</style>' +
                        '</div>'
                            );


                            // Modify the print view to start numbering from 1 in the "No." column
                            var startIndex = 1;
                            $(win.document.body).find('table.dataTable thead tr th').eq(0).text('No.');
                            $(win.document.body).find('table.dataTable tbody tr').each(function(index) {
                                $(this).find('td').eq(0).text(startIndex + index);
                            });
                            
                            // Hide DataTable title
                            $(win.document.body).find('h1').hide();
                        }
                    }
                ]
            }
        ],
        "columnDefs": [ {
            "targets": 0, // Targeting the first column (index 0)
            "data": null, // Use data from the current row
            "render": function(data, type, row, meta) {
                return meta.row + 1; // Add auto-increment number starting from 1
            }
        } ],
    });

// Handle user type change
$('#userTypeFilter').change(function() {
    var userType = $(this).val();
    // Check if an event is selected
    if ($('#eventsFilter').val()) {
        updateTableColumns(userType);
        // Show or hide the table based on user type selection
        if (userType === "") {
            $('#reportTable').hide();
        } else {
            $('#reportTable').show();
        }
    } else {
        // If no event is selected, show an alert to select an event first
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select an event first.',
        });
    }
});

// Function to update DataTable columns and data based on user type
function updateTableColumns(userType) {
    var columns = [];

    // Define columns based on user type
    if (userType === "college") {
        columns = [
            { title: 'No.' },
            { title: 'First Name' },
            { title: 'Last Name' },
            { title: 'Course' },
            { title: 'Level' },
            { title: '', visible: false },
            { title: '', visible: false },
            { title: '', visible: false },
            { title: '', visible: false },
            { title: 'Time In' },
            { title: 'Time Out' }
        ];
        // Show/hide headers based on user type
        $(".course-header").show();
        $(".level-header").show();
        $(".strand-header").hide();
        $(".grade-header").hide();
        $(".section-header").hide();
        $(".position-header").hide();
    } else if (userType === "high_school") {
        columns = [
            { title: 'No.' },
            { title: 'First Name' },
            { title: 'Last Name' },
            { title: '', visible: false },
            { title: '', visible: false },
            { title: 'Strand' },
            { title: 'Grade' },
            { title: 'Section' },
            { title: '', visible: false },
            { title: 'Time In' },
            { title: 'Time Out' }
        ];
        // Show/hide headers based on user type
        $(".course-header").hide();
        $(".level-header").hide();
        $(".strand-header").show();
        $(".grade-header").show();
        $(".section-header").show();
        $(".position-header").hide();
    } else if (userType === "faculty") {
        columns = [
            { title: 'No.' },
            { title: 'First Name' },
            { title: 'Last Name' },
            { title: '', visible: false },
            { title: '', visible: false },
            { title: '', visible: false },
            { title: '', visible: false },
            { title: '', visible: false },
            { title: 'Position' },
            { title: 'Time In' },
            { title: 'Time Out' }
        ];
        // Show/hide headers based on user type
        $(".course-header").hide();
        $(".level-header").hide();
        $(".strand-header").hide();
        $(".grade-header").hide();
        $(".section-header").hide();
        $(".position-header").show();
    }

    // Clear existing DataTable columns
    table.clear();


    // Fetch attendance data for the selected user type
    $.ajax({
        url: 'report_fetch_attendance.php',
        type: 'post',
        data: {eventId: $('#eventsFilter').val(), userType: userType},
        success:function(response){
            // Clear existing data
            table.clear().draw();
            // Add fetched data to DataTable
            table.rows.add($(response)).draw();
        }
    });
}


    table.buttons().container().appendTo('#reportTable_wrapper .col-md-6:eq(0)');

    // Create chart
    const chart = Highcharts.chart('demo-output', {
        chart: {
            type: 'pie',
            styledMode: true,
        },
        title: {
            text: 'Attendance Overview'
        },
        series: [{
            data: chartData(table)
        }],
        credits: {
            enabled: false   
        }
    });

    // Function to update chart title based on data availability
    function updateChartTitle(data) {
        if (data.length > 0) {
            chart.setTitle({ text: 'Attendance Overview' });
        } else {
            chart.setTitle({ text: 'No Data Available' });
        }
    }

    // On each draw, update the data in the chart and title
    table.on('draw.dt', function () {
        const data = chartData(table);
        chart.series[0].setData(data);
        updateChartTitle(data);
    });

    function chartData(table) {
    var counts = {};

    // Define the column indexes for Course, Strand, Level, and Position based on user type
    var courseColumnIndex;
    var strandColumnIndex;
    var levelColumnIndex;
    var positionColumnIndex;

    // Determine the column indexes based on the selected user type
    var userType = $('#userTypeFilter').val();
    if (userType === "college") {
        courseColumnIndex = 3; // Assuming Course column is at index 3
        strandColumnIndex = 5; // Assuming Strand column is at index 5
        levelColumnIndex = 4; // Assuming Level column is at index 4
        positionColumnIndex = -1; // No position column for college
    } else if (userType === "high_school") {
        courseColumnIndex = 5; // Assuming Strand column is at index 5
        strandColumnIndex = 6; // Assuming Grade column is at index 6
        levelColumnIndex = -1; // No level column for high school
        positionColumnIndex = -1; // No position column for high school
    } else if (userType === "faculty") {
        courseColumnIndex = -1; // No course column for faculty
        strandColumnIndex = -1; // No strand column for faculty
        levelColumnIndex = -1; // No level column for faculty
        positionColumnIndex = 8; // Assuming Position column is at index 8
    }

    // Count the number of entries for each unique combination of Course, Strand, and Level
    table
        .rows({ filter: 'applied' })
        .every(function () {
            var row = this.data();
            var course = courseColumnIndex !== -1 ? row[courseColumnIndex] : ''; // Course data if available
            var strand = strandColumnIndex !== -1 ? row[strandColumnIndex] : ''; // Strand data if available
            var level = levelColumnIndex !== -1 ? row[levelColumnIndex] : ''; // Level data if available
            var position = positionColumnIndex !== -1 ? row[positionColumnIndex] : ''; // Position data if available

            // Combine Course, Strand, and Level into a single key if all are available
            var key = '';
            if (courseColumnIndex !== -1 && strandColumnIndex !== -1 && levelColumnIndex !== -1) {
                key = course + '-' + strand + '' + level;
            } else if (courseColumnIndex !== -1 && strandColumnIndex !== -1) {
                key = course + '-' + strand;
            } else if (courseColumnIndex !== -1) {
                key = course;
            }

            // Use Position as key if available and no Course, Strand, and Level combination
            if (positionColumnIndex !== -1 && key === '') {
                key = position;
            }

            if (counts[key]) {
                counts[key] += 1;
            } else {
                counts[key] = 1;
            }
        });

    // Convert counts object to an array of objects with name and y properties
    return Object.entries(counts).map((entry) => ({
        name: entry[0], // This will be the combined Course-Strand-Level key or Position
        y: entry[1]
    }));
}

});
</script>


<script>

$(document).ready(function() {
    $('#toggleCurrentPassword').click(function(){
        togglePasswordVisibility('#currentPassword');
    });

    $('#toggleNewPassword').click(function(){
        togglePasswordVisibility('#newPassword');
    });

    $('#toggleConfirmPassword').click(function(){
        togglePasswordVisibility('#confirmPassword');
    });

    // Clear input fields when modal is hidden
    $('#changePasswordModal').on('hidden.bs.modal', function () {
        $('#changePasswordForm').trigger('reset');
    });

    // Handle form submission
    $('#savePasswordChangesBtn').click(function() {
        var currentPassword = $('#currentPassword').val();
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        // Validate form fields
        if (currentPassword === '' || newPassword === '' || confirmPassword === '') {
            Swal.fire('Error', 'Please fill in all fields.', 'error');
            return;
        }

        if (newPassword !== confirmPassword) {
            Swal.fire('Error', 'New password and confirm password do not match.', 'error');
            return;
        }

        // Send data to the server for password change
        $.ajax({
            type: 'POST',
            url: 'registrar_change_password.php', // Replace with the actual endpoint for changing password
            data: {
                currentPassword: currentPassword,
                newPassword: newPassword
            },
            success: function(response) {
                // Handle success response
                response = JSON.parse(response);
                if (response.success) {
                    Swal.fire('Success', 'Password changed successfully.', 'success').then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            $('#changePasswordModal').modal('hide');
                        }
                    });
                } else {
                    // Check if the current password is incorrect
                    if (response.message === 'Current password is incorrect.') {
                        Swal.fire('Error', 'Current password is incorrect.', 'error');
                    } else {
                        Swal.fire('Error', 'An error occurred while changing the password. Please try again later.', 'error');
                    }
                }
            },
            error: function(xhr, status, error) {
                // Handle error response
                Swal.fire('Error', 'An error occurred while changing the password. Please try again later.', 'error');
                console.error(xhr.responseText);
            }
        });
    });



  function togglePasswordVisibility(inputId) {
      var input = $(inputId);
      var icon = input.parent().find('.fa');

      if (input.attr('type') === 'password') {
          input.attr('type', 'text');
          icon.removeClass('fa-eye-slash').addClass('fa-eye');
      } else {
          input.attr('type', 'password');
          icon.removeClass('fa-eye').addClass('fa-eye-slash');
      }
  }
});

</script>


<!-- View Profile Modal -->
<div class="modal fade" id="viewProfileModal" tabindex="-1" role="dialog" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="viewProfileModalLabel">View Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Profile View Form -->
                <form id="viewProfileForm">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstName; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastName; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Change Password Form -->
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggleCurrentPassword"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" name="newPassword">
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggleNewPassword"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggleConfirmPassword"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="savePasswordChangesBtn"><i class="fas fa-save"></i> Save Changes</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


</body>
</html>
