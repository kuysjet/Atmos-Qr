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

?>

<?php include 'includes/header.php'; ?>

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
          <h3>Faculty</h3>
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
                <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addFacultyModal">
                  <i class="fas fa-user-plus"></i> Add New
                </button>
                <button type="button" class="btn btn-success float-end btn-sm" data-toggle="modal" data-target="#importFacultyCsvModal">
                  <i class="fas fa-file-import"></i> Import CSV
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="facultyTable" class="display table table-bordered" style="display: none;">
                  <thead>
                  <tr>
                    <th>
                      <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <input name="select_all" value="1" id="select-all" type="checkbox">
                        <i class="fas fa-trash-alt text-danger" id="bulkDeleteBtn"></i>
                      </div>
                    </th>
                    <th>No.</th>
                    <th>ID Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Department</th>
                    <th>Position</th>
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
<!-- Enable downloading for qr code -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<!-- Include html2canvas library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/datetime.js"></script>
<script src="dist/js/pro-pass-toggle.js"></script>


<script>
$(document).ready(function() {
  // Show the table after the page reloads and the DataTable is initialized
  $('#facultyTable').show();
  // Destroy existing DataTable instance
  if ($.fn.DataTable.isDataTable('#facultyTable')) {
    $('#facultyTable').DataTable().destroy();
  }

  // Initialize DataTable with new settings
  var table = $('#facultyTable').DataTable({
    "ajax": "crud_faculty.php",
    "columns": [
      {
        data: null,
        render: function(data, type, row) {
          return `
            <div style="text-align: center;">
              <input type="checkbox" class="dt-checkbox" value="${row.ID}">
            </div>`;
        },
        orderable: false,
        className: 'dt-body-center',
      },
      { "data": null, "render": function(data, type, row, meta) {
          return meta.row + 1; // Add auto-increment number starting from 1
        }
      },
      { "data": "IdentificationNumber" },
      { "data": "FirstName" },
      { "data": "LastName" },
      { "data": "Email" },
      { "data": "DepartmentName" },
      { "data": "PositionName" },
      {
        "data": null,
        "render": function(data, type, row) {
          return '<button type="button" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>' +
                '<button type="button" class="btn btn-danger btn-sm delete-btn mx-1"><i class="fas fa-trash-alt"></i></button>' +
                '<button type="button" class="btn btn-info btn-sm view-qr-btn" data-id="' + row.IdentificationNumber + '"><i class="fas fa-qrcode"></i></button>';
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
              extend: 'collection',
              text: '<i class="fas fa-file-export"></i>',
              className: 'btn-sm btn-light border mr-1',
              buttons: [
                {
              extend: 'csv',
              text: '<i class="fas fa-file-csv"></i> CSV',
              exportOptions: {
                  columns: [2, 3, 4, 5, 6, 7]
              }
          },
          {
              extend: 'excel',
              text: '<i class="far fa-file-excel"></i> Excel',
              exportOptions: {
                  columns: [1, 2, 3, 4, 5, 6, 7]
              }
          },
          {
              extend: 'pdf',
              text: '<i class="far fa-file-pdf"></i> PDF',
              exportOptions: {
                  columns: [1, 2, 3, 4, 5, 6, 7]
              }
          },
          {
              extend: 'print',
              text: '<i class="fas fa-print"></i> Print',
              exportOptions: {
                  columns: [1, 2, 3, 4, 5, 6, 7]
              }
          }

        ]
      },
      {
        extend: 'colvis',
        text: '<i class="fas fa-eye"></i>',
        className: 'btn-sm btn-light border',
      }
    ]
  });

  $(document).tooltip();


  // Handle click on "Select all" control
  $('#select-all').on('click', function(){
    var rows = table.rows({ 'search': 'applied' }).nodes();
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });

  // Handle click on checkbox to set state of "Select all" control
  $('#facultyTable tbody').on('change', 'input[type="checkbox"]', function(){
    if(!this.checked){
      var el = $('#select-all').get(0);
      if(el && el.checked && ('indeterminate' in el)){
        el.indeterminate = true;
      }
    }
  });


  // Submit form for adding new faculty
  $('#addFacultyForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    // Serialize form data
    var formData = $(this).serialize();
    // Send AJAX request to add faculty
    $.ajax({
      url: 'crud_faculty.php', // PHP script to handle insertion
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          // Reload DataTable upon successful addition
          table.ajax.reload();
          // Reset form fields
          $('#addFacultyForm')[0].reset();
          // Close modal
          $('#addFacultyModal').modal('hide');
          // Show success message
          Swal.fire("Success", "New faculty added successfully!", "success");
        } else {
          // Show error message if addition failed
          Swal.fire("Error", "Failed to add faculty", "error");
        }
      },
      error: function(xhr, status, error) {
        // Show error message if AJAX request fails
        console.error(xhr.responseText);
        Swal.fire("Error", "Failed to add faculty", "error");
      }
    });
  });



// Submit form for importing CSV file
$('#importFacultyCsvForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = new FormData(this); // Create FormData object
    // Send AJAX request to import CSV
    $.ajax({
        url: 'import_csv_faculty.php',
        method: 'POST',
        dataType: 'json',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'success') {
                // Refresh DataTable upon successful import
                table.ajax.reload();
                // Close modal
                $('#importFacultyCsvModal').modal('hide');
                // Show success message
                Swal.fire("Success", response.message, "success");
            } else if (response.status === 'error') {
                // Show error message if import failed
                Swal.fire("Error", response.message, "error");
            } else if (response.status === 'warning') {
                // Show warning message for duplication
                Swal.fire("Warning", response.message, "warning");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Show error message if AJAX request fails
            Swal.fire("Error", "Failed to import faculties", "error");
        }
    });
});



  // Edit button click event handler
  $('#facultyTable').on('click', '.edit-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    $('#editFacultyId').val(rowData['ID']);
    $('#editIdentificationNumber').val(rowData['IdentificationNumber']);
    $('#editFirstName').val(rowData['FirstName']);
    $('#editLastName').val(rowData['LastName']);
    $('#editEmail').val(rowData['Email']);
    $('#editDepartmentName').val(rowData['DepartmentName']);
    $('#editPositionName').val(rowData['PositionName']);
    $('#editFacultyModal').modal('show');
  });

  // Submit form for editing faculty
  $('#editFacultyForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    // Serialize form data
    var formData = $(this).serialize();
    // Send AJAX request to edit faculty
    $.ajax({
      url: 'crud_faculty.php', // PHP script to handle update
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          // Reload DataTable upon successful update
          table.ajax.reload();
          // Close modal
          $('#editFacultyModal').modal('hide');
          // Show success message
          Swal.fire("Success", "Faculty information updated successfully!", "success");
        } else {
          // Show error message if update failed
          Swal.fire("Error", "Failed to update faculty information", "error");
        }
      },
      error: function(xhr, status, error) {
        // Show error message if AJAX request fails
        console.error(xhr.responseText);
        Swal.fire("Error", "Failed to update faculty information", "error");
      }
    });
  });

  // Delete button click event handler
  $('#facultyTable').on('click', '.delete-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    var facultyId = rowData['ID'];

    // Show SweetAlert confirmation dialog
    Swal.fire({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this faculty!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d9534f",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel",
      customClass: {
            popup: 'small-swal' // Apply custom class for styling
        },
    }).then((result) => {
      if (result.isConfirmed) {
        // User confirmed deletion, proceed with AJAX request
        $.ajax({
          url: 'crud_faculty.php',
          method: 'POST',
          dataType: 'json',
          data: { faculty_id: facultyId },
          success: function(response) {
            if (response.status === 'success') {
              // Reload table upon successful deletion
              table.ajax.reload();
              // Show success message using SweetAlert
              Swal.fire("Success", response.message, "success");
            } else {
              // Show error message using SweetAlert
              Swal.fire("Error", response.message, "error");
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Show error message using SweetAlert
            Swal.fire("Error", "Failed to delete faculty", "error");
          }
        });
      } else {
          // User canceled deletion
          Swal.fire({
              title: "Cancelled",
              text: "Faculty deletion cancelled.",
              icon: "info",
              customClass: {
                  popup: 'small-swal' // Apply custom class for styling
              },
          });
        }
    });
});


    // Bulk delete button click event
    $('#bulkDeleteBtn').on('click', function() {
    // Collect all checked checkboxes' values in an array
    var selectedIds = [];
    $('.dt-checkbox:checked').each(function() {
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please select at least one faculty to delete.',
      });
      return;
    }

    // SweetAlert confirmation
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete them!'
    }).then((result) => {
      if (result.isConfirmed) {
        // AJAX request to server-side script for deletion
        $.ajax({
          url: 'crud_faculty.php', // Adjust the URL to your PHP script
          type: 'POST',
          data: {
            'bulkDelete': true,
            'faculty_ids': selectedIds
          },
          success: function(response) {
            // Parse JSON response
            var data = JSON.parse(response);
            if (data.status === 'success') {
              // Optionally, refresh your DataTable here or show a success message
              Swal.fire(
                'Deleted!',
                'Selected faculties have been deleted.',
                'success'
              ).then((result) => {
                // Reload DataTable
                $('#facultyTable').DataTable().ajax.reload();
              });
            } else {
              // Handle error
              Swal.fire(
                'Failed!',
                'Failed to delete faculties: ' + data.error,
                'error'
              );
            }
          },
          error: function(xhr, status, error) {
            // Handle AJAX error
            Swal.fire(
              'Error!',
              'An error occurred: ' + error,
              'error'
            );
          }
        });
      }
    });
  });

// Event listener for "View QR" button clicks
$('#facultyTable').on('click', '.view-qr-btn', function() {
  // Retrieve the faculty's Identification Number from the button's data attribute
  var identificationNumber = $(this).data('id');

  // Fetch the faculty's information from the DataTable row
  var rowData = table.row($(this).closest('tr')).data();
  var firstName = rowData['FirstName'].trim();
  var lastName = rowData['LastName'].trim();

  // Construct the QR code path using the faculty's Identification Number
  var qrCodePath = 'qr_codes/' + identificationNumber + '.png';

  // Set the src attribute of the QR code image in the modal
  $('#qrCodeImage').attr('src', qrCodePath);

  // Set the filename for downloading to the faculty's first name and last name
  var filename = firstName + '_' + lastName + '_qr_code.png'; // Using faculty's first name and last name for filename
  $('#downloadQR').attr('download', filename);

  // Display the faculty's name inside the card
  $('#facultyName').text(firstName + ' ' + lastName);

  // Show the modal
  $('#viewQrCodeModal').modal('show');
});



// Function to download QR code and card from the modal
function downloadQRCodeFromModal() {
  // Get the QR code image element
  var qrCodeImage = document.getElementById('qrCodeImage');

  // Get the card element
  var cardToDownload = document.getElementById('cardToDownload');

  // Use html2canvas to capture both the QR code image and the card
  html2canvas(cardToDownload).then(function(canvas) {
    // Convert the canvas to a data URL
    var dataURL = canvas.toDataURL('image/png');

    // Create a new Blob object from the data URL
    var blob = dataURLtoBlob(dataURL);

    // Get the filename for downloading
    var filename = $('#downloadQR').attr('download');

    // Create a link element
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = filename;

    // Append the link to the body and trigger the download
    document.body.appendChild(link);
    link.click();

    // Remove the link from the body
    document.body.removeChild(link);
  });
}

// Attach click event listener to the download button in the modal
document.getElementById('downloadQR').addEventListener('click', function() {
  // Trigger downloadQRCodeFromModal function
  downloadQRCodeFromModal();
});

// Function to convert data URL to Blob object
function dataURLtoBlob(dataURL) {
  var parts = dataURL.split(';base64,');
  var contentType = parts[0].split(':')[1];
  var raw = window.atob(parts[1]);
  var rawLength = raw.length;
  var uInt8Array = new Uint8Array(rawLength);

  for (var i = 0; i < rawLength; ++i) {
    uInt8Array[i] = raw.charCodeAt(i);
  }

  return new Blob([uInt8Array], { type: contentType });
}
});
</script>






<!-- Add Faculty Modal -->
<div class="modal fade" id="addFacultyModal" tabindex="-1" role="dialog" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addFacultyModalLabel">Add New Faculty</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addFacultyForm">
        <div class="row">
          <div class="col-md-6">
          <div class="form-group">
            <label for="identificationNumber">Identification Number</label>
            <input type="text" class="form-control" id="identificationNumber" name="identificationNumber" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required autocomplete="off">
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="departmentName">Department</label>
            <select class="form-control" id="departmentName" name="departmentName" required>
                <option value="">Select Department</option> <!-- Blank option -->
                <?php
                // Database connection code
                include 'database/db.php';

                // Query to fetch department names from the Departments table
                $query = "SELECT DepartmentName FROM Departments";
                $result = mysqli_query($conn, $query);

                // Check if query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Fetch department names and generate options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['DepartmentName'] . '">' . $row['DepartmentName'] . '</option>';
                    }
                } else {
                    // If query fails or no departments found, display an error option
                    echo '<option value="">No departments found</option>';
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </select>
          </div>

          <div class="form-group">
            <label for="positionName">Position</label>
            <select class="form-control" id="positionName" name="positionName" required>
                <option value="">Select Position</option> <!-- Blank option -->
                <?php
                // Database connection code
                include 'database/db.php';

                // Query to fetch position names from the Positions table
                $query = "SELECT PositionName FROM Positions";
                $result = mysqli_query($conn, $query);

                // Check if query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Fetch position names and generate options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['PositionName'] . '">' . $row['PositionName'] . '</option>';
                    }
                } else {
                    // If query fails or no positions found, display an error option
                    echo '<option value="">No positions found</option>';
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </select>
          </div>
          </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="addFacultyForm"><i class="fas fa-paper-plane"></i> Submit</button>
      </div>
    </div>
  </div>
</div>



<!-- Add Edit Faculty Modal -->
<div class="modal fade" id="editFacultyModal" tabindex="-1" role="dialog" aria-labelledby="editFacultyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="editFacultyModalLabel">Edit Faculty</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editFacultyForm">
        <div class="row">
          <div class="col-md-6">
          <input type="hidden" id="editFacultyId" name="editFacultyId">
          <div class="form-group">
            <label for="editIdentificationNumber">Identification Number</label>
            <input type="text" class="form-control" id="editIdentificationNumber" name="editIdentificationNumber" required>
          </div>
          <div class="form-group">
            <label for="editFirstName">First Name</label>
            <input type="text" class="form-control" id="editFirstName" name="editFirstName" required>
          </div>
          <div class="form-group">
            <label for="editLastName">Last Name</label>
            <input type="text" class="form-control" id="editLastName" name="editLastName" required>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="editEmail" required>
          </div>
          <div class="form-group">
            <label for="editDepartmentName">Department</label>
            <select class="form-control" id="editDepartmentName" name="editDepartmentName" required>
                <?php
                // Database connection code
                include 'database/db.php';

                // Query to fetch department names from the Departments table
                $query = "SELECT DepartmentName FROM Departments";
                $result = mysqli_query($conn, $query);

                // Check if query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Fetch department names and generate options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['DepartmentName'] . '">' . $row['DepartmentName'] . '</option>';
                    }
                } else {
                    // If query fails or no departments found, display an error option
                    echo '<option value="">No departments found</option>';
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </select>
          </div>

          <div class="form-group">
            <label for="editPositionName">Position</label>
            <select class="form-control" id="editPositionName" name="editPositionName" required>
                <?php
                // Database connection code
                include 'database/db.php';

                // Query to fetch position names from the Positions table
                $query = "SELECT PositionName FROM Positions";
                $result = mysqli_query($conn, $query);

                // Check if query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Fetch position names and generate options
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['PositionName'] . '">' . $row['PositionName'] . '</option>';
                    }
                } else {
                    // If query fails or no positions found, display an error option
                    echo '<option value="">No positions found</option>';
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </select>
          </div>
          </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="editFacultyForm"><i class="fas fa-save"></i> Save Changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Import CSV Modal -->
<div class="modal fade" id="importFacultyCsvModal" tabindex="-1" role="dialog" aria-labelledby="importFacultyCsvModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="importFacultyCsvModalLabel">Import CSV File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="importFacultyCsvForm" enctype="multipart/form-data">
          <div class="form-group">
            <label for="csvFile">Choose CSV File</label>
            <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="importFacultyCsvForm">Import</button>
      </div>
    </div>
  </div>
</div>



<!-- View QR Code Modal -->
<div class="modal fade" id="viewQrCodeModal" tabindex="-1" aria-labelledby="viewQrCodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="viewQrCodeModalLabel">QR Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center d-flex flex-column align-items-center justify-content-center" id="modalBodyToDownload">
        <!-- Card with Background Image inside Modal Body with Medium Size -->
        <div class="card" id="cardToDownload" style="width: 300px;">
          <img src="dist/img/Card.png" class="card-img" alt="Background Image" style="width: 100%; height: auto;">
          <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
            <!-- Logo above the QR Code -->
            <img src="dist/img/aclc_complete_logo.png" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
            <!-- QR Code Image -->
            <img id="qrCodeImage" alt="QR Code" style="width: 200px; height: auto;">
            <!-- Faculty Name -->
            <div id="facultyName" class="font-weight-bold" style="font-size: 14px; margin-top: 20px; color: black;">Faculty Name</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="downloadQR"><i class="fas fa-download"></i> Download</button>
      </div>
    </div>
  </div>
</div>



</body>
</html>
