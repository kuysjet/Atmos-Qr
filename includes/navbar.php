  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="admin_dashboard.php" class="nav-link">Home</a>
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
        <a href="#" class="nav-link" id="darkModeToggleBtn">
          <i class="fas fa-moon"></i>
          <i class="fas fa-sun text-warning d-none"></i>
        </a>
      </li>
      <!-- Profile -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <a class="dropdown-item" id="profileDropdown" href="#" role="button" data-toggle="modal" data-target="#viewProfileModal">
            <i class="fas fa-user-cog fa-sm fa-fw mr-2"></i> Profile
            <span class="float-right text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" id="changePasswordDropdown" href="#" role="button" data-toggle="modal" data-target="#changePasswordModal">
            <i class="fas fa-key fa-sm fa-fw mr-2"></i> Change Password
            <span class="float-right text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Logout
              <span class="float-right text-sm"></span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->



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
                        <label for="vfirstname">First Name</label>
                        <input type="text" class="form-control" id="vfirstname" name="firstname" value="<?php echo $firstname; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="vlastname">Last Name</label>
                        <input type="text" class="form-control" id="vlastname" name="lastname" value="<?php echo $lastname; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="vemail">Email</label>
                        <input type="email" class="form-control" id="vemail" name="email" value="<?php echo $email; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="vusername">Username</label>
                        <input type="text" class="form-control" id="vusername" name="username" value="<?php echo $username; ?>" readonly>
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



