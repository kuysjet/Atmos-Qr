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
          <span class="d-block text-light"><?php echo "$firstname $lastname"; ?></span>
        </div>
      </div>

      <!-- Get the current page filename without path -->
      <?php $page = basename($_SERVER['PHP_SELF']);?>  

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="admin_dashboard.php" class="nav-link <?= $page == 'admin_dashboard.php' ? 'active text-white' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="academic_year.php" class="nav-link <?= $page == 'academic_year.php' ? 'active text-white' : '' ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Academic Year
              </p>
            </a>
          </li>
          <li class="nav-item <?= ($page == 'faculty.php' || $page == 'senior_high.php' || $page == 'college.php' || $page == 'department.php' || $page == 'position.php') ? 'menu-open active' : '' ?>">
    <a href="#" class="nav-link <?= ($page == 'faculty.php' || $page == 'senior_high.php' || $page == 'college.php' || $page == 'department.php' || $page == 'position.php') ? 'bg-primary' : '' ?>">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Registrants
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="faculty.php" class="nav-link <?= $page == 'faculty.php' ? 'active' : '' ?>">
                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                <p class="pl-4">Faculty</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="senior_high.php" class="nav-link <?= $page == 'senior_high.php' ? 'active' : '' ?>">
                <i class="fas fa-user-graduate nav-icon"></i>
                <p class="pl-4">Senior High</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="college.php" class="nav-link <?= $page == 'college.php' ? 'active' : '' ?>">
                <i class="fas fa-user-graduate nav-icon"></i>
                <p class="pl-4">College</p>
            </a>
        </li>
        <li class="nav-item <?= ($page == 'department.php' || $page == 'position.php') ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Faculty Roles
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="department.php" class="nav-link <?= $page == 'department.php' ? 'active' : '' ?>">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p class="pl-4">Department</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="position.php" class="nav-link <?= $page == 'position.php' ? 'active' : '' ?>">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p class="pl-4">Position</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>

          <li class="nav-item">
            <a href="registrar.php" class="nav-link <?= $page == 'registrar.php' ? 'active text-white' : '' ?>">
              <i class="fas fa-user-secret nav-icon"></i>
              <p>Registrars</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="event.php" class="nav-link <?= $page == 'event.php' ? 'active text-white' : '' ?>">
              <i class="fas fa-th-list nav-icon"></i>
              <p>Events</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="report.php" class="nav-link <?= $page == 'report.php' ? 'active text-white' : '' ?>">
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