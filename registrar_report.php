<?php
session_start()
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ATMOS | Registrar</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
  <link rel="stylesheet" href="//code.highcharts.com/css/highcharts.css">
</head>
<body>
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
      <!-- Profile -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user fa-fw mr-2 text-gray"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <i class="fas fa-user-cog fa-sm fa-fw mr-2 text-gray"></i> Profile
            <span class="float-right text-muted text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray"></i> Logout
            <span class="float-right text-muted text-sm"></span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="logout.php" class="btn btn-primary">Yes, Logout</a>
      </div>
    </div>
  </div>
</div>


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="https://www.facebook.com/ACLCCollegeIRIGA/" class="brand-link">
      <img src="dist/img/amalogo.png" alt="ACLC Logo" class="brand-image img-circle elevation-2" style="opacity: .8; width: 30px;">
      <span class="brand-text font-weight-light text-white"><small>ACLC COLLEGE IRIGA INC.</small></span>
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
          <a href="#" class="d-block">Registrar</a>
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
            <h3 class="m-0">Reports</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="registrar_dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Registrar Page</li>
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
                <marquee class="pt-1" width="100%" direction="left"> <b>A t t e n d a n c e &nbsp; M o n i t o r i n g &nbsp; - &nbsp; Q R &nbsp; C o d e</b></marquee>
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
                    <th>Role</th>
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
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Level</th>
                    <th>Strand</th>
                    <th>Grade</th>
                    <th>Section</th>
                    <th>Role</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                  </tr>
                  </tfoot>
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
