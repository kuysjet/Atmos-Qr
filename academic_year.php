<?php
session_start();

// Check if the user is not logged in or is not a registrar
if (!isset($_SESSION['username']) || $_SESSION['user_type_id'] != 1) {
    // Redirect to the login page
    header('Location: index.php');
    exit(); // Stop further execution
}

include 'database/db.php';
include 'includes/header.php'; 
?>

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">


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
          <h3>Academic Year</h3>
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
      <div class="card">
              <div class="card-header">
                <marquee width="100%" direction="left"> <b>A t t e n d a n c e &nbsp; M o n i t o r i n g &nbsp; - &nbsp; Q R &nbsp; C o d e</b></marquee>
              </div>
              <div class="card-header m-0">
              <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addAcademicYearModal">
                <i class="fas fa-plus"></i> Add New
              </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="academicyearTable" class="display table table-bordered">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Academic Year</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/datetime.js"></script>


<script>
$(document).ready(function() {
  // Destroy existing DataTable instance
  if ($.fn.DataTable.isDataTable('#academicyearTable')) {
    $('#academicyearTable').DataTable().destroy();
  }

  // Initialize DataTable with new settings
  var table = $('#academicyearTable').DataTable({
    "ajax": "crud_academic_year.php",
    "columns": [
      { "data": null, "render": function(data, type, row, meta) {
          return meta.row + 1; // Add auto-increment number starting from 1
        }
      },
      { "data": "academic_year" },
      {
        "data": "status",
        "render": function(data, type, row) {
          if(data == 'active') {
            return '<button class="btn btn-success toggle-btn btn-sm" data-id="' + row.ID + '">Active</button>';
          } else {
            return '<button class="btn btn-secondary toggle-btn btn-sm" data-id="' + row.ID + '">Inactive</button>';
          }
        }
      },
      {
        "data": null,
        "render": function(data, type, row) {
          return '<button type="button" class="btn btn-sm btn-danger delete-btn"><i class="fas fa-trash-alt"></i></button>';
        }
      }
    ],
    "responsive": {
        details: {
          renderer: function(api, rowIdx, columns) {
            var data = $.map(columns, function(col, i) {
              return col.hidden ?
                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                '<td>' + col.title + ':' + '</td> ' +
                '<td>' + col.data + '</td>' +
                '</tr>' :
                '';
            }).join('');
            return data ? $('<table/>').append(data) : false;
          }
        }
      },
    "lengthChange": false, 
    "autoWidth": false,
    "dom": 'Bfrtip', 
    "buttons": [
      {
        extend: 'colvis',
        text: '<i class="fas fa-eye"></i>',
        className: 'btn-sm btn-light border',
      }
    ]
  });

  $(document).tooltip();

  // Submit form for adding new academic year
  $('#addAcademicYearForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    // Serialize form data
    var formData = $(this).serialize();
    // Send AJAX request to add academic year
    $.ajax({
      url: 'crud_academic_year.php', // PHP script to handle insertion
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          // Reload DataTable upon successful addition
          table.ajax.reload();
          // Reset form fields
          $('#addAcademicYearForm')[0].reset();
          // Close modal
          $('#addAcademicYearModal').modal('hide');
          // Show success message using SweetAlert
          Swal.fire("Success", "New academic year added successfully!", "success");
        } else if (response.status === 'error' && response.message === 'duplicate') {
          // Show duplicate entry message using SweetAlert
          Swal.fire("Error", "Academic year already exists. Please choose a different year.", "error");
        } else {
          // Show error message using SweetAlert
          Swal.fire("Error", "Failed to add academic year", "error");
        }
      },
      error: function(xhr, status, error) {
        // Show error message using SweetAlert if AJAX request fails
        console.error(xhr.responseText);
        Swal.fire("Error", "Failed to add academic year", "error");
      }
    });
  });

  // Toggle button click event handler
  $('#academicyearTable').on('click', '.toggle-btn', function() {
    var academic_yearId = $(this).data('id');
    var status = $(this).hasClass('btn-success') ? 'inactive' : 'active';

    // Show confirmation modal using SweetAlert
    Swal.fire({
      title: "Are you sure?",
      text: "Do you want to change the status of this academic year?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, change it!"
    }).then((result) => {
      if (result.isConfirmed) {
        // User confirmed status change, proceed with AJAX request
        $.ajax({
          url: 'crud_academic_year.php',
          method: 'POST',
          dataType: 'json',
          data: { academic_year_id: academic_yearId, status: status },
          success: function(response) {
            if (response.status === 'success') {
              // Reload table upon successful update
              table.ajax.reload();
              // Show success message using SweetAlert
              Swal.fire("Success", "Academic year status updated successfully", "success");
            } else {
              // Show error message using SweetAlert
              Swal.fire("Error", response.message, "error");
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Show error message using SweetAlert
            Swal.fire("Error", "Failed to update academic year status", "error");
          }
        });
      } else {
        // User canceled status change
        Swal.fire({
          title: "Cancelled",
          text: "Academic Year status change canceled.",
          icon: "info",
          customClass: {
                  popup: 'small-swal' // Apply custom class for styling
              },
        });
      }
    });
  });

  // Delete button click event handler
  $('#academicyearTable').on('click', '.delete-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    var academic_yearId = rowData['ID'];
    var academic_year = rowData['academic_year'];

    // Show Swal confirmation dialog
    Swal.fire({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this academic year!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d9534f",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
      customClass: {
            popup: 'small-swal' // Apply custom class for styling
        }
    }).then((result) => {
      if (result.isConfirmed) {
        // User confirmed deletion, proceed with AJAX request
        $.ajax({
          url: 'crud_academic_year.php',
          method: 'POST',
          dataType: 'json',
          data: { academic_year_id: academic_yearId },
          success: function(response) {
            if (response.status === 'success') {
              // Reload table upon successful deletion
              table.ajax.reload();
              // Show success message using Swal
              Swal.fire("Success", response.message, "success");
            } else {
              // Show error message using Swal
              Swal.fire("Error", response.message, "error");
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Show error message using Swal
            Swal.fire("Error", "Failed to delete academic year", "error");
          }
        });
      } else {
          // User canceled deletion
          Swal.fire({
              title: "Cancelled",
              text: "Academic Year deletion cancelled.",
              icon: "info",
              customClass: {
                  popup: 'small-swal' // Apply custom class for styling
              },
          });
        }
    });
});



});
</script>




<!-- Add Academic Year Modal -->
<div class="modal fade" id="addAcademicYearModal" tabindex="-1" role="dialog" aria-labelledby="addAcademicYearLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addAcademicYearLabel">Add New Academic Year</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addAcademicYearForm">
          <div class="form-group">
            <label for="academic_year">Academic Year</label>
            <select class="form-control" id="academic_year" name="academic_year" required>
              <option value="">Select Academic Year</option>
              <?php
              // Get the current year
              $currentYear = date("Y");
              
              // Generate options for the next 5 academic years
              $uniqueAcademicYears = array();
              for ($i = 0; $i < 5; $i++) {
                  $startYear = $currentYear + $i;
                  $endYear = $startYear + 1;
                  $academicYear = "$startYear-$endYear";
                  // Check if the academic year is already added
                  if (!in_array($academicYear, $uniqueAcademicYears)) {
                      echo "<option value=\"$academicYear\">$academicYear</option>";
                      // Add the academic year to the unique array
                      $uniqueAcademicYears[] = $academicYear;
                  }
              }
              ?>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" id="addAcademicYearBtn" disabled>Add Academic Year</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Get references to the select element and the button
    var selectElement = document.getElementById("academic_year");
    var addButton = document.getElementById("addAcademicYearBtn");
    
    // Add event listener to the select element
    selectElement.addEventListener("change", function() {
      // Enable/disable the button based on the selected value
      addButton.disabled = selectElement.value === "";
    });
    
    // Add event listener to the form submission event
    var form = document.getElementById("addAcademicYearForm");
    form.addEventListener("submit", function() {
      // Disable the button upon form submission
      addButton.disabled = true;
    });
  });
</script>







</body>
</html>
