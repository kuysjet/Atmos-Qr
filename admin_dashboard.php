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

// Fetch count of events from the database
$query = "SELECT COUNT(*) AS eventCount FROM events";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$eventCount = $row['eventCount'];

// Fetch count of finished events based on current date
$currentDate = date('Y-m-d');
$queryFinishedEvents = "SELECT COUNT(*) AS finishedEventCount FROM events WHERE event_date < '$currentDate'";
$resultFinishedEvents = mysqli_query($conn, $queryFinishedEvents);
$rowFinishedEvents = mysqli_fetch_assoc($resultFinishedEvents);
$finishedEventCount = $rowFinishedEvents['finishedEventCount'];

// Fetch count of ongoing events based on current date
$queryOngoingEvents = "SELECT COUNT(*) AS ongoingEventCount FROM events WHERE event_date = '$currentDate'";
$resultOngoingEvents = mysqli_query($conn, $queryOngoingEvents);
$rowOngoingEvents = mysqli_fetch_assoc($resultOngoingEvents);
$ongoingEventCount = $rowOngoingEvents['ongoingEventCount'];

// Fetch count of listed registrants for college students
$queryCollege = "SELECT COUNT(*) AS collegeCount FROM collegestudents";
$resultCollege = mysqli_query($conn, $queryCollege);
$rowCollege = mysqli_fetch_assoc($resultCollege);
$collegeCount = $rowCollege['collegeCount'];

// Fetch count of listed registrants for senior high students
$querySeniorHigh = "SELECT COUNT(*) AS seniorHighCount FROM seniorhighstudents";
$resultSeniorHigh = mysqli_query($conn, $querySeniorHigh);
$rowSeniorHigh = mysqli_fetch_assoc($resultSeniorHigh);
$seniorHighCount = $rowSeniorHigh['seniorHighCount'];

// Fetch count of listed registrants for faculties
$queryFaculty = "SELECT COUNT(*) AS facultyCount FROM faculties";
$resultFaculty = mysqli_query($conn, $queryFaculty);
$rowFaculty = mysqli_fetch_assoc($resultFaculty);
$facultyCount = $rowFaculty['facultyCount'];

// Calculate total count of listed registrants
$totalRegistrants = $collegeCount + $seniorHighCount + $facultyCount;

?>

<?php include 'includes/header.php'; ?>

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
          <h3>Dashboard</h3>
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
                <!-- Info boxes -->
                <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Events</span>
                <span class="info-box-number"><?php echo $eventCount; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Listed Registrants</span>
                <span class="info-box-number"><?php echo $totalRegistrants; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Finished Events</span>
                <span class="info-box-number"><?php echo $finishedEventCount; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">On-Going Events</span>
                <span class="info-box-number"><?php echo $ongoingEventCount; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      <!-- Charts -->
      <div class="col-12">
        <div class="row">
          <!-- Pie Chart -->
          <div class="col-md-6">
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          
          <!-- Bar Chart -->
          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
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
<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/datetime.js"></script>
<script src="dist/js/pro-pass-toggle.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>




<!-- Page specific script -->
<script>
  $(function () {
    //-------------
    //- PIE CHART -
    //-------------
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: [
          'BSCS',
          'BSEnterp',
          'BSAIS',
          'ACT',
          'ABM',
          'HUMSS',
          'GAS', 
          'TVL'
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100,200,80],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#8A2BE2', '#008B8B', '#BDB76B'],
        }
      ]
    }
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = {
      labels  : ['BSCS', 'BSentrep', 'BSAIS', 'ACT', 'ABM', 'HUMSS', 'GAS'],
      datasets: [
        {
          label               : 'Attendees',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Total Students',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }
    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
  })
</script>

</body>
</html>
