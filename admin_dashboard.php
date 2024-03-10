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

// #Pie Chart
// Fetch count of college students by courses from the database
$queryCollegeCourses = "SELECT course_name, COUNT(*) AS count FROM collegestudents
                        INNER JOIN courses ON collegestudents.CourseID = courses.id
                        GROUP BY course_name";
$resultCollegeCourses = mysqli_query($conn, $queryCollegeCourses);
$collegeCoursesData = [];
while ($row = mysqli_fetch_assoc($resultCollegeCourses)) {
    $collegeCoursesData[$row['course_name']] = $row['count'];
}

// Fetch count of senior high students by strands from the database
$querySeniorHighStrands = "SELECT strand_name, COUNT(*) AS count FROM seniorhighstudents
                           INNER JOIN strands ON seniorhighstudents.StrandID = strands.id
                           GROUP BY strand_name";
$resultSeniorHighStrands = mysqli_query($conn, $querySeniorHighStrands);
$seniorHighStrandsData = [];
while ($row = mysqli_fetch_assoc($resultSeniorHighStrands)) {
    $seniorHighStrandsData[$row['strand_name']] = $row['count'];
}


// Fetch count of listed registrants for college students by courses and levels
$queryCollege = "SELECT courses.course_name, levels.level_name, COUNT(*) AS count 
                FROM collegestudents 
                INNER JOIN courses ON collegestudents.CourseID = courses.id 
                INNER JOIN levels ON collegestudents.LevelID = levels.id 
                GROUP BY courses.course_name, levels.level_name";
$resultCollege = mysqli_query($conn, $queryCollege);
$collegeData = [];
while ($row = mysqli_fetch_assoc($resultCollege)) {
    $collegeData[$row['course_name'] . ' - ' . $row['level_name']] = $row['count'];
}

// Fetch count of listed registrants for senior high students by strands and grades
$querySeniorHigh = "SELECT strands.strand_name, grades.grade_name, COUNT(*) AS count 
                    FROM seniorhighstudents 
                    INNER JOIN strands ON seniorhighstudents.StrandID = strands.id 
                    INNER JOIN grades ON seniorhighstudents.GradeID = grades.id 
                    GROUP BY strands.strand_name, grades.grade_name";
$resultSeniorHigh = mysqli_query($conn, $querySeniorHigh);
$seniorHighData = [];
while ($row = mysqli_fetch_assoc($resultSeniorHigh)) {
    $seniorHighData[$row['strand_name'] . ' - ' . $row['grade_name']] = $row['count'];
}

// Calculate total count of listed registrants
$totalRegistrants = array_sum($collegeData) + array_sum($seniorHighData);

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
              <!-- Donut Chart -->
              <div class="col-md-6">
                <div class="card card-danger">
                  <div class="card-header">
                    <h3 class="card-title m-0">Courses and Strands</h3>
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
                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col-md-6 -->
              <!-- Horizontal Bar Chart -->
              <div class="col-md-6">
                <div class="card card-success">
                  <div class="card-header">
                    <h3 class="card-title m-0">Levels and Grades</h3>
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
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.col-12 -->
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
    // Fetch data for donut chart from PHP variables
    var collegeCoursesData = <?php echo json_encode($collegeCoursesData); ?>;
    var seniorHighStrandsData = <?php echo json_encode($seniorHighStrandsData); ?>;

    //-------------
    //- DONUT CHART -
    //-------------
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
    var donutData = {
      labels: Object.keys(collegeCoursesData).concat(Object.keys(seniorHighStrandsData)),
      datasets: [{
        data: Object.values(collegeCoursesData).concat(Object.values(seniorHighStrandsData)),
        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#8A2BE2', '#008B8B', '#BDB76B'],
      }]
    };
    var donutOptions = {
      maintainAspectRatio: false,
      responsive: true,
      cutoutPercentage: 65, // Adjust this value to control the size of the hole in the center of the donut
    };
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    });
  });
</script>

<script>
  $(function () {
    // Fetch data for bar chart from PHP variables
    var collegeData = <?php echo json_encode($collegeData); ?>;
    var seniorHighData = <?php echo json_encode($seniorHighData); ?>;
    // Automatic color generation for bar chart bars
    var barChartColors = generateColors(Object.keys(collegeData).length + Object.keys(seniorHighData).length);

    //-------------
    //- HORIZONTAL BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = {
      labels: Object.keys(collegeData).concat(Object.keys(seniorHighData)),
      datasets: [
        {
          label: 'Registrants',
          backgroundColor: barChartColors,
          borderColor: barChartColors,
          borderWidth: 1,
          data: Object.values(collegeData).concat(Object.values(seniorHighData))
        }
      ]
    }
    var barChartOptions = {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
    new Chart(barChartCanvas, {
      type: 'horizontalBar',
      data: barChartData,
      options: barChartOptions
    });

    // Function to generate minimal colors dynamically
    function generateColors(numColors) {
      var colors = [];
      var minimalColors = ['#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#fd7e14', '#28a745', '#20c997', '#17a2b8', '#ffc107', '#dc3545'];
      for (var i = 0; i < numColors; i++) {
        colors.push(minimalColors[i % minimalColors.length]);
      }
      return colors;
    }
  });
</script>


</body>
</html>
