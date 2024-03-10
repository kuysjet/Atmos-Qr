
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="dist/img/icon.png">
  <title>ATMOS</title>

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




  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


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
    font-size: 14px; /* Adjust the font size as needed */
    padding: 4px 8px; /* Adjust the padding as needed */
  }

  /* Remove padding for the pagination button numbers */
  .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
  .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current) {
    padding: 2px; /* Remove padding */
  }
  </style>
