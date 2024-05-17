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
  <link rel="icon" type="image/x-icon" href="dist/img/new-icon.png">
  <title>ATMOS | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Include Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">   -->
  <link rel="stylesheet" href="dist/css/dark-table.css"></link>

  <style>
      /* Styling for scroll buttons */
  .scroll-to-top {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
}

.scroll-to-bottom {
  position: fixed;
  bottom: 70px;
  right: 20px;
  z-index: 1000;
}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php include 'includes/scroll-button.php'; ?>

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
      <li class="nav-item mx-1">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- Dark mode toggle link -->
      <li class="nav-item">
        <a href="#" class="nav-link px-1" id="darkModeToggleBtn">
          <i class="fas fa-sun text-warning"></i>
          <i class="fas fa-moon d-none"></i>
        </a>
      </li>
      <!-- Profile -->
      <li class="nav-item dropdown">
        <a class="nav-link d-flex justify-content-center align-items-center" data-toggle="dropdown" href="#">
          <i class="fas fa-user-circle fa-fw " style="font-size: 18px"></i>
          <i class="fas fa-caret-down fa-xs"></i>
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
      <span class="brand-text" style="font-size: small;"><b>ACLC COLLEGE OF IRIGA INC.</b></span>
    </a>

    <!-- active link change -->
    <?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <i class="fas fa-user-circle fa-2x mr-2 text-gray"></i>
        </div>
        <div class="info">
            <span class="d-block text-light"><?php echo "$firstName $lastName"; ?></span>
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
              <div class="mr-3 small"><b>Philippine Standard Time</b></div>
            </div>
            <div class="col-sm-12 text-sm-right">
              <div id="philippine-date-time" style="font-size: 15px;"></div>
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
            <div class="row">
                <div class="col-md-3">
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
                <div class="col-md-4 ml-auto mt-1 position-relative">
                    <label for="searchBox" class="form-label mb-0">Search:</label>
                    <div class="form-group">
                        <input type="text" class="form-control rounded-pill pr-4" id="searchBox" placeholder="Enter keywords">
                        <span id="resetSearch" class="input-group-addon position-absolute" style="right: 18px; top: 55%; transform: translateY(-50%);"><i class="fas fa-times" style="color: grey; font-size: smaller;"></i></span>
                    </div>
                </div>
            </div>

            <hr class="mt-0">

            <div class="row">
            <?php
            // Function to calculate the status of an event
            function calculateEventStatus($eventDate, $loginTime, $logoutTime)
            {
                // Set the default time zone to UTC+8
                date_default_timezone_set('Asia/Manila'); // Example for the Philippines, adjust if needed
            
                $currentDate = date('Y-m-d'); // Get the current date in 'Y-m-d' format
                $currentTime = date('H:i:s'); // Get the current time in 24-hour format 'H:i:s'
            
                // Event is Done if it's a past event or today's event has finished
                if ($eventDate < $currentDate || ($eventDate == $currentDate && $currentTime > $logoutTime)) {
                    return 'Done';
                }
                // Event is Ongoing if it's the current date and the current time is between login and logout time
                elseif ($eventDate == $currentDate && $loginTime <= $currentTime && $currentTime <= $logoutTime) {
                    return 'Ongoing';
                }
                // For future events or today's events that have not started yet
                else {
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
                                    <span class="badge badge-<?php echo $status == 'Pending' ? 'warning' : ($status == 'Ongoing' ? 'primary' : 'success'); ?> mr-2"><?php echo $status; ?></span>
                                    <!-- Card tools -->
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize" style="box-shadow: none !important;">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" style="box-shadow: none !important;">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body text-center">
                                <!-- Display the event details -->
                                <p><strong>Event Name:</strong> <?php echo $row['event_name']; ?></p>
                                <!-- <p><strong>Academic Year:</strong> <?php echo $row['academic_year']; ?></p> -->
                                <p><strong>Venue:</strong> <?php echo $row['event_venue']; ?></p>
                                <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                                <p><strong>Date:</strong> <?php echo date('l, F j, Y', strtotime($row['event_date'])); ?></p>
                                <p><strong>Login Time:</strong> <?php echo date('h:i A', strtotime($row['log_in'])); ?></p>
                                <p><strong>Logout Time:</strong> <?php echo date('h:i A', strtotime($row['log_out'])); ?></p>
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
                                            echo '<button class="btn btn-secondary fa-lg rounded-pill" title="Disabled" style="width: 100px; opacity: 0.15;" disabled><i class="fas fa-qrcode" style="border: 2px solid; border-radius: 50%; padding: 5px;"></i></a>';
                                        } else {
                                            // Otherwise, enable the button and pass event details as parameters
                                            echo '<a href="scanner.php?eventId=' . $row['id'] . '&eventName=' . urlencode($row['event_name']) . '" class="btn btn-primary border border-warning fa-lg rounded-pill btn-glow" title="Scan Qr" style="width: 120px;"><i class="fas fa-qrcode" style="border: 2px solid; border-radius: 50%; padding: 5px;"></i></a>';
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
                echo "<div class='col-md-12 text-center'><div style='background-color: #f0f0f0; padding: 10px; border-radius: 20px;'><p style='margin: 0; color:black'>No events assigned</p></div></div>";
            }
            ?>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php include 'includes/footer.php';?>

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


// Reset search input when reset icon is clicked
$('#resetSearch').on('click', function() {
    $('#searchBox').val(''); // Clear search input
    $('.card').show(); // Show all cards
});

// Filter cards based on search input
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
                <div class="row">
                    <!-- Profile Image Icon -->
                    <div class="col-md-6 mt-2">
                        <div class="text-center py-2 border border-info rounded mb-2">
                            <i class="fas fa-user-circle text-gray" style="font-size: 130px"></i>
                        </div>
                    </div>
                    <!-- Profile View Form -->
                    <div class="col-md-6">
                        <form id="viewProfileForm">
                            <div class="form-group">
                                <label for="vfirstname">First Name</label>
                                <input type="text" class="form-control" id="vfirstname" name="firstname" value="<?php echo $firstName; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vlastname">Last Name</label>
                                <input type="text" class="form-control" id="vlastname" name="lastname" value="<?php echo $lastName; ?>" readonly>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Email and Username Fields -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="vemail">Email</label>
                            <input type="email" class="form-control" id="vemail" name="email" value="<?php echo $email; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="vusername">Username</label>
                            <input type="text" class="form-control" id="vusername" name="username" value="<?php echo $username; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
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
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="savePasswordChangesBtn"><i class="fas fa-save fa-sm"></i> Save Changes</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
