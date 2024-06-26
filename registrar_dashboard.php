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

?>


<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="dist/img/icon.png">
  <title>ATMOS | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Include Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">   -->
  <link rel="stylesheet" href="dist/css/dark-table.css">

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
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="academicYearFilter" class="form-label mb-0">Filter by Academic Year:</label>
                    <select id="academicYearFilter" class="form-control">
                        <option value="">All</option>
                        <?php
                        // Fetch academic years from the database
                        $academicYearQuery = "SELECT * FROM academic_years WHERE status = 'active'";
                        $academicYearResult = mysqli_query($conn, $academicYearQuery);
                        if ($academicYearResult && mysqli_num_rows($academicYearResult) > 0) {
                            while ($academicYearRow = mysqli_fetch_assoc($academicYearResult)) {
                                echo '<option value="' . $academicYearRow['id'] . '">' . $academicYearRow['academic_year'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 ml-auto mt-1">
                    <label for="searchBox" class="form-label mb-0">Search:</label>
                    <input type="text" class="form-control" id="searchBox" placeholder="Enter keywords">
                </div>
            </div>

            <div class="row">
            <?php
            // Function to calculate the status of an event
            function calculateEventStatus($eventDate, $loginTime, $logoutTime)
            {
                $currentDate = date('Y-m-d');
                $currentTime = date('H:i:s');

                if ($eventDate < $currentDate || ($eventDate == $currentDate && $logoutTime < $currentTime)) {
                    return 'Done';
                } elseif ($eventDate == $currentDate && $currentTime < $loginTime) {
                    return 'Ongoing';
                } elseif ($eventDate == $currentDate || $loginTime <= $currentTime && $currentTime <= $logoutTime) {
                    return 'Ongoing';
                } else {
                    return 'Pending';
                }
            }
            // Check if events are found
            if ($result && mysqli_num_rows($result) > 0) {
                // Loop through each event and display it in a card
                while ($row = mysqli_fetch_assoc($result)) {
                    // Determine the status of the event using the provided function
                    $status = calculateEventStatus($row['event_date'], $row['log_in'], $row['log_out']);
                    ?>
                    <div class="col-md-4 event-card" data-academic-year-id="<?php echo $row['academic_year_id']; ?>">
                        <div class="card collapsed-card card-outline <?php echo $status == 'Pending' ? 'card-warning' : ($status == 'Ongoing' ? 'card-primary' : 'card-success'); ?>">
                            <div class="card-header">
                                <h3 class="card-title text-truncate" style="max-width: 170px;"><?php echo $row['event_name']; ?></h3>
                                <div class="card-tools">
                                    <!-- Display the status badge -->
                                    <span class="badge badge-<?php echo $status == 'Pending' ? 'warning' : ($status == 'Ongoing' ? 'primary' : 'success'); ?> ml-2"><?php echo $status; ?></span>
                                    <!-- Card tools -->
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body text-left">
                                <!-- Display the event details -->
                                <p>Academic Year: <?php echo $row['academic_year']; ?></p>
                                <p>Venue: <?php echo $row['event_venue']; ?></p>
                                <p>Description: <?php echo $row['description']; ?></p>
                                <p>Date: <?php echo $row['event_date']; ?></p>
                                <p>Login Time: <?php echo $row['log_in']; ?></p>
                                <p>Logout Time: <?php echo $row['log_out']; ?></p>
                            </div>
                            <!-- /.card-body -->
                            <!-- QR code scan button -->
                            <div class="card-footer">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                        <?php
                                        // Check if the status is 'Done' or 'Pending'
                                        if ($status === 'Done' || $status === 'Pending') {
                                            // If status is 'Done' or 'Pending', disable the button
                                            echo '<button class="btn btn-circle btn-lg btn-primary" style="border-radius: 50%; opacity: 0.15;" disabled><i class="fas fa-qrcode"></i></button>';
                                        } else {
                                            // Otherwise, enable the button and pass event details as parameters
                                            echo '<a href="scanner.php?eventId=' . $row['id'] . '&eventName=' . urlencode($row['event_name']) . '" class="btn btn-circle btn-lg btn-primary" style="border-radius: 50%;"><i class="fas fa-qrcode"></i></a>';
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <?php
                }
            } else {
                // No events found
                echo "<div class='col-md-12 text-center p-2'><div style='background-color: #f0f0f0; padding: 10px;'><p style='margin: 0; color:black'>No events assigned</p></div></div>";
            }
            ?>
        </div>
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

    
    // Event listener for academic year filter
    $('#academicYearFilter').change(function() {
    var selectedAcademicYearId = $(this).val();

    // Show or hide event cards based on the selected academic year
    if (selectedAcademicYearId === "") {
        // Show all events if no academic year is selected
        $('.event-card').show();
    } else {
        // Hide events that do not match the selected academic year
        $('.event-card').hide();
        $('.event-card[data-academic-year-id="' + selectedAcademicYearId + '"]').show();
    }
});


    // Add an event listener to the search box to filter events based on input
    $('#searchBox').on('input', function() {
        var searchText = $(this).val().toLowerCase();
        $('.card').each(function() {
            var eventName = $(this).find('.card-title').text().toLowerCase();
            if (eventName.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
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
