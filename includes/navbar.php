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
          <a href="#" class="dropdown-item" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray"></i> Logout
              <span class="float-right text-muted text-sm"></span>
          </a>

        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
