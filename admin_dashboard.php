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


</body>
</html>
