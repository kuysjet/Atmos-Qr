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
            <h1 class="m-0">Reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Report Page</li>
            </ol>
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
                <table id="example1" class="display table table-bordered">
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>


<script>
$(function () {
    const table = $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "orderable": true,
        "dom": 'Bfrtip', // Ensure the buttons container is included
        "buttons": [
            {
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm',
                buttons: ['csv', 'excel', 'pdf', 'print']
            },
            {
              extend: 'colvis',
              text: 'Column visibility',
              className: 'btn-sm',
            }
        ]
    });

    table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

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
