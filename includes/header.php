
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="dist/img/icon.png">
  <title>ATMOS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Include Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

    <!-- CSS for navbar and body text in dark mode -->
  <style>
    /* Navbar dark mode */
    .dark-mode .main-header {
      background-color: #343a40; /* Dark background color */
      color: #ffffff; /* Light text color */
      border-color: #343a40;
    }

    /* Body text in dark mode */
    .dark-mode body {
      color: #ffffff; /* Light text color */
    }

    /* Icon colors in dark mode */
    .dark-mode .nav-link .fa-moon,
    .dark-mode .nav-link .fa-sun {
      color: #ffffff; /* Light color for icons */
    }

    /* Nav-item text color in dark mode */
    .dark-mode .nav-item .nav-link {
      color: grey; /* Light text color */
    }

    /* Hover color for navbar items in dark mode */
    .dark-mode .nav-item:hover .nav-link {
    color: #ffffff; /* Light color when hovered */
    }

  /* Modal content text color in dark mode */
  .dark-mode .modal-content {
    color: #ffffff; /* Light text color */
  }

  /* Student name color in dark mode */
  .dark-mode #studentName {
    color: #ffffff; /* White text color */
  }

    /* Dropdown list hover color in dark mode */
  .dark-mode .dropdown-menu .dropdown-item:hover {
    background-color: #ffffff; /* White background color */
    color: #343a40; /* Dark text color */
  }

    /* Dark mode for DataTables buttons */
  .dark-mode .dt-button.dropdown-toggle {
      background-color: #343a40 !important; /* Dark background color */
      border-color: #343a40 !important; /* Dark border color */
  }

  .dark-mode .dt-button.dropdown-toggle:hover {
      background-color: #23272b !important; /* Dark background color on hover */
      border-color: #23272b !important; /* Dark border color on hover */
  }

  .dark-mode .dt-button-collection .dropdown-menu {
      background-color: #343a40 !important; /* Dark background color */
  }

  .dark-mode .dt-button-collection .dropdown-menu .dt-button {
      color: #ffffff !important; /* Light text color */
  }

  .dark-mode .dt-button-collection .dropdown-menu .dt-button:hover {
      color: #343a40 !important; /* Light text color on hover */
  }
  
      /* Custom CSS for dropdown list in DataTable buttons in dark mode */
      .dark-mode .dt-button-collection .dropdown-menu {
        background-color: #343a40; /* Dark background color */
        color: #ffffff; /* Light text color */
    }

    /* Custom CSS for dropdown items in DataTable buttons in dark mode */
    .dark-mode .dt-button-collection .dropdown-menu a {
        color: #ffffff; /* Light text color */
    }

    /* Custom CSS for dropdown items hover effect in DataTable buttons in dark mode */
    .dark-mode .dt-button-collection .dropdown-menu a:hover {
        background-color: #ffffff; /* White background color */
        color: #343a40; /* Dark text color */
    }
  </style>

  <style>
  /* Custom CSS to adjust the size of SweetAlert dialog */
  .swal2-popup {
      font-size: 0.8rem; /* Adjust font size */
      width: 20rem; /* Adjust width */
  }

  .dataTables_wrapper {
      overflow-x: auto; /* Enable horizontal scrolling for DataTables */
  }

  /* Adjust the font size and padding for all pagination buttons */
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    font-size: 14px; /* Adjust the base font size */
    padding: 4px 8px; /* Adjust the base padding */
  }

  /* Remove padding for the pagination button numbers */
  .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
  .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current) {
    padding: 2px; /* Remove padding */
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    /* Adjust font size and padding for smaller devices */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      font-size: 12px;
      padding: 3px 6px;
    }
  }

  @media (max-width: 576px) {
    /* Further adjustments for extra small devices */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      font-size: 10px;
      padding: 2px 4px;
    }
  }

  </style>




<script>
// Function to set the title based on the current page
function setPageTitle() {
  var pageTitle = "ATMOS"; // Default title
  var path = window.location.pathname; // Get the current path

  // Check if the path ends with the desired PHP file name
  if (path.endsWith("/admin_dashboard.php")) {
    pageTitle = "ATMOS | Admin Dashboard";
  } else if (path.endsWith("/academic_year.php")) {
    pageTitle = "ATMOS | Academic Year";
  } else if (path.endsWith("/college.php")) {
    pageTitle = "ATMOS | College";
  } else if (path.endsWith("/senior_high.php")) {
    pageTitle = "ATMOS | Senior High";
  } else if (path.endsWith("/faculty.php")) {
    pageTitle = "ATMOS | Faculty";
  } else if (path.endsWith("/department.php")) {
    pageTitle = "ATMOS | Department";
  } else if (path.endsWith("/position.php")) {
    pageTitle = "ATMOS | Position";
  } else if (path.endsWith("/event.php")) {
    pageTitle = "ATMOS | Event";
  }else if (path.endsWith("/registrar.php")) {
    pageTitle = "ATMOS | Registrar";
  }else if (path.endsWith("/report.php")) {
    pageTitle = "ATMOS | Report";
  }



  // Update the document title
  document.title = pageTitle;
}

// Call the function when the page loads
window.onload = function() {
  setPageTitle();
};
</script>