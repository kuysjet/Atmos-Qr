<?php
session_start();

include 'database/db.php';

// Check if the user is not logged in or is not an administrator
if (!isset($_SESSION['username']) || $_SESSION['user_type_id'] != 1) {
    // Redirect to the login page 
    header('Location: index.php');
    // exit(); // Stop further execution
    exit();
}

// Fetch user details of the current administrator from the database
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username' AND user_type_id = 1";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch the user data
    $row = mysqli_fetch_assoc($result);
    
    // Assign user details to variables
    $id = $row['id'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $username = $row['username'];

} else {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
}

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

<?php include 'includes/header.php'; ?>

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="//code.highcharts.com/css/highcharts.css">

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
                    <label for="academicYearFilter">Academic Year:</label>
                      <select id="academicYearFilter" class="form-control">`
                      <option value="" disabled selected>Select Academic Year</option>
                      <?php echo $academicYearsOptions; ?>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <label for="eventsFilter">Events:</label>
                      <select id="eventsFilter" class="form-control">
                      <option value="" disabled selected>Select Event</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <label for="userTypeFilter">Filter by User Type:</label>
                      <select id="userTypeFilter" class="form-control">
                          <option value="" disabled selected>Select User Type</option>
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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="//code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
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
<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/datetime.js"></script>
<script src="dist/js/pro-pass-toggle.js"></script>


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
                key = course + '-' + strand + '-' + level;
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



</body>
</html>


