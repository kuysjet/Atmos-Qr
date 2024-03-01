<?php include 'includes/header.php'; ?>

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
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
                  <div class="col-md-2">
                    <label for="academicYearFilter">Academic Year:</label>
                    <select id="academicYearFilter" class="form-control">
                      <option value="2023-2024">2023-2024</option>
                      <option value="2022-2023">2022-2023</option>
                      <!-- Add more options as needed -->
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label for="eventsFilter">Events:</label>
                    <select id="eventsFilter" class="form-control">
                      <option value="Event 1">Event 1</option>
                      <option value="Event 2">Event 2</option>
                      <!-- Add more options as needed -->
                    </select>
                  </div>
                  <div class="col-md-2">
                      <label for="userTypeFilter">Select Attendees Type:</label>
                      <select id="userTypeFilter" class="form-control">
                          <option value="college">College</option>
                          <option value="high_school">Senior High School</option>
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
                        <p>Sample Event</p>
                      </div>
                      <!-- Event Description column -->
                      <div class="col-md-6">
                        <strong>Event Description:</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </div>
                    <div class="row mb-6">
                      <!-- Event Venue column -->
                      <div class="col-md-6">
                        <strong>Event Venue:</strong>
                        <p>Sample Venue</p>
                      </div>
                      <!-- Event Start Date/Time column -->
                      <div class="col-md-3">
                        <strong>Event Start Date/Time:</strong>
                        <p>February 15, 2024, 10:00 AM</p>
                      </div>
                      <!-- Event End Date/Time column -->
                      <div class="col-md-3">
                        <strong>Event End Date/Time:</strong>
                        <p>February 15, 2024, 6:00 PM</p>
                      </div>
                    </div>
                  </div>
                </div>
                <table id="reportTable" class="display table table-bordered">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Level</th>
                    <th>Strand</th>
                    <th>Grade</th>
                    <th>Section</th>
                    <th>Position</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1</td>
                    <td>Cedrick Embestro</td>
                    <td>BSCS</td>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Manuel Monge</td>
                    <td></td>
                    <td></td>
                    <td>ABM</td>
                    <td>11</td>
                    <td>A</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Carlos Tanay</td>
                    <td>Entrep</td>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Cynel Taduran</td>
                    <td>ACT</td>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td> </td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Jetro Bagasala</td>
                    <td>BSCS</td>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td> </td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
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
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
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


<script>
$(function () {
    const table = $("#reportTable").DataTable({
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
                text: '<i class="far fa-file-excel"></i> Excel'
            },
            {
                extend: 'pdf',
                text: '<i class="far fa-file-pdf"></i> PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print'
            }
        ]
    },
    {
        extend: 'colvis',
        text: '<i class="fas fa-eye"></i>',
        className: 'btn-sm btn-light border'
    }
]
    });

        // Handle user type change
        $('#userTypeFilter').change(function() {
        var userType = $(this).val();
        updateTableColumns(userType);
    });

    // Function to update DataTable columns and data based on user type
    function updateTableColumns(userType) {
        var columns = [];
        var data = [];

        // Define columns and data based on user type
        if (userType === "college") {
            columns = [
                { title: '#' },
                { title: 'Name' },
                { title: 'Course' },
                { title: 'Level' },
                { title: 'Strand', visible: false },
                { title: 'Grade', visible: false },
                { title: 'Section', visible: false },
                { title: 'Position', visible: false },
                { title: 'Time In' },
                { title: 'Time Out' }
            ];
            data = [
                ['1', 'Cedrick Embestro', 'BSCS', '4', '', '', '', '', '', ''],
                ['2', 'Manuel Monge', 'BSCS', '2', '', '', '', '', '', ''],
                ['3', 'Carlos Tanay', 'Entrep', '4', '', '', '', '', '', ''],
                ['4', 'Cynel Taduran', 'ACT', '4', '', '', '', '', '', ''],
                ['5', 'Jetro Bagasala', 'BSCS', '4', '', '', '', '', '', '']
            ];
        } else if (userType === "high_school") {
            columns = [
                { title: '#' },
                { title: 'Name' },
                { title: '', visible: false },
                { title: '', visible: false },
                { title: 'Strand' },
                { title: 'Grade' },
                { title: 'Section' },
                { title: '', visible: false },
                { title: 'Time In' },
                { title: 'Time Out' }
            ];
            data = [
                ['1', 'John Doe', '', '', 'STEM', '11', 'A', '', '', ''],
                ['2', 'Jane Smith', '', '', 'ABM', '12', 'B', '', '', ''],
                ['3', 'Mark Johnson', '', '', 'HUMSS', '11', 'C', '', '', ''],
                ['4', 'Sarah Williams', '', '', 'GAS', '12', 'D', '', '', ''],
                ['5', 'Michael Brown', '', '', 'TVL', '10', 'E', '', '', '']
            ];
        } else if (userType === "faculty") {
            columns = [
                { title: '#' },
                { title: 'Name' },
                { title: '', visible: false },
                { title: '', visible: false },
                { title: '', visible: false },
                { title: '', visible: false },
                { title: '', visible: false },
                { title: 'Position' },
                { title: 'Time In' },
                { title: 'Time Out' }
            ];
            data = [
                ['1', 'Dr. John Doe', '', '', '', '', '', 'Professor', '', ''],
                ['2', 'Prof. Jane Smith', '', '', '', '', '', 'Assistant Professor', '', ''],
                ['3', 'Mr. Mark Johnson', '', '', '', '', '', 'Instructor', '', ''],
                ['4', 'Ms. Sarah Williams', '', '', '', '', '', 'Lecturer', '', ''],
                ['5', 'Dr. Michael Brown', '', '', '', '', '', 'Adjunct Professor', '', '']
            ];
        }

        // Clear existing DataTable columns and data
        table.clear();

        // Add columns and data to DataTable
        columns.forEach(function(column, index) {
            table.column(index).visible(column.visible !== false); // Hide columns if specified
            table.column(index).header().innerHTML = column.title; // Set column titles
        });
        table.rows.add(data).draw(); // Add rows and redraw DataTable
    }


    table.buttons().container().appendTo('#reportTable_wrapper .col-md-6:eq(0)');

    // Create chart
    const chart = Highcharts.chart('demo-output', {
        chart: {
            type: 'pie',
            styledMode: true,
        },
        title: {
            text: 'Attendees Count by Course and Strand'
        },
        series: [{
            data: chartData(table)
        }],
        credits: {
            enabled: false   
        }
    });

    // On each draw, update the data in the chart
    table.on('draw.dt', function () {
        chart.series[0].setData(chartData(table));
    });

    function chartData(table) {
        var counts = {};

        // Count the number of entries for each unique combination of Course and Strand
        table
            .rows({ filter: 'applied' })
            .every(function () {
                var row = this.data();
                var course = row[2]; // Assuming the Course column is at index   2
                var strand = row[4]; // Assuming the Strand column is at index   4

                // Combine Course and Strand into a single key
                var key = course + '-' + strand;

                if (counts[key]) {
                    counts[key] +=   1;
                } else {
                    counts[key] =   1;
                }
            });

        return Object.entries(counts).map((entry) => ({
            name: entry[0], // This will be the combined Course-Strand key
            y: entry[1]
        }));
    }
});


</script>



</body>
</html>
