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
<body class="hold-transition sidebar-mini layout-fixed">
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
          <h3>Senior High</h3>
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
            <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addSeniorHighModal">
              <i class="fas fa-user-plus"></i> Add New
            </button>
            <button type="button" class="btn btn-success float-end btn-sm" data-toggle="modal" data-target="#importSeniorHighCsvModal">
                <i class="fas fa-file-import"></i> Import CSV
            </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="seniorhighStudentsTable" class="display table table-bordered" style="display: none;">
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
                  <th>Strand</th>
                  <th>Grade</th>
                  <th>Section</th>
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
$('#seniorhighStudentsTable').show();
// Destroy existing DataTable instance
if ($.fn.DataTable.isDataTable('#seniorhighStudentsTable')) {
  $('#seniorhighStudentsTable').DataTable().destroy();
}

// Initialize DataTable with new settings
var table = $('#seniorhighStudentsTable').DataTable({
  "ajax": "crud_senior_high.php",
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
    { "data": "strand_name" },
    { "data": "grade_name" },
    { "data": "section_name" },
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
                      columns: [2, 3, 4, 5, 6, 7, 8]
                  }
              },
              {
                  extend: 'excel',
                  text: '<i class="far fa-file-excel"></i> Excel',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5, 6, 7, 8]
                  }
              },
              {
                  extend: 'pdf',
                  text: '<i class="far fa-file-pdf"></i> PDF',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5, 6, 7, 8]
                  }
              },
              {
                  extend: 'print',
                  text: '<i class="fas fa-print"></i> Print',
                  exportOptions: {
                      columns: [1, 2, 3, 4, 5, 6, 7, 8]
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
$('#seniorhighStudentsTable tbody').on('change', 'input[type="checkbox"]', function(){
  if(!this.checked){
    var el = $('#select-all').get(0);
    if(el && el.checked && ('indeterminate' in el)){
      el.indeterminate = true;
    }
  }
});


// Submit form for adding new seniorhigh student
$('#addSeniorHighForm').on('submit', function(e) {
  e.preventDefault(); // Prevent default form submission
  // Serialize form data
  var formData = $(this).serialize();
  // Send AJAX request to add student
  $.ajax({
    url: 'crud_senior_high.php', // PHP script to handle insertion
    method: 'POST',
    dataType: 'json',
    data: formData,
    success: function(response) {
      if (response.status === 'success') {
        // Reload DataTable upon successful addition
        table.ajax.reload();
        // Reset form fields
        $('#addSeniorHighForm')[0].reset();
        // Close modal
        $('#addSeniorHighModal').modal('hide');
        // Show success message
        Swal.fire("Success", "New student added successfully!", "success");
      } else {
        // Show error message if addition failed
        Swal.fire("Error", "Failed to add student", "error");
      }
    },
    error: function(xhr, status, error) {
      // Show error message if AJAX request fails
      console.error(xhr.responseText);
      Swal.fire("Error", "Failed to add student", "error");
    }
  });
});


// Submit form for importing CSV file
$('#importSeniorHighCsvForm').on('submit', function(e) {
  e.preventDefault(); // Prevent default form submission
  var formData = new FormData(this); // Create FormData object
  // Send AJAX request to import CSV
  $.ajax({
      url: 'import_csv_seniorhigh.php',
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
              $('#importSeniorHighCsvModal').modal('hide');
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
          Swal.fire("Error", "Failed to import students", "error");
      }
  });
});



// Edit button click event handler
$('#seniorhighStudentsTable').on('click', '.edit-btn', function() {
  var rowData = table.row($(this).parents('tr')).data();
  $('#editSeniorHighId').val(rowData['ID']);
  $('#editIdentificationNumber').val(rowData['IdentificationNumber']);
  $('#editFirstName').val(rowData['FirstName']);
  $('#editLastName').val(rowData['LastName']);
  $('#editEmail').val(rowData['Email']);
  $('#editStrand').val(rowData['strand_name']);
  $('#editGrade').val(rowData['grade_name']);
  $('#editSection').val(rowData['section_name']);
  $('#editSeniorHighModal').modal('show');
});

// Submit form for editing seniorhigh student
$('#editSeniorHighForm').on('submit', function(e) {
  e.preventDefault(); // Prevent default form submission
  var formData = $(this).serialize(); // Serialize form data
  // Send AJAX request to update student
  $.ajax({
    url: 'crud_senior_high.php', // PHP script to handle update
    method: 'POST',
    dataType: 'json',
    data: formData,
    success: function(response) {
      if (response.status === 'success') {
        table.ajax.reload(); // Reload DataTable upon successful update
        $('#editSeniorHighModal').modal('hide'); // Close modal
        Swal.fire("Success", "Student information updated successfully!", "success"); // Show success message
      } else {
        Swal.fire("Error", "Failed to update student information", "error"); // Show error message if update failed
      }
    },
    error: function(xhr, status, error) {
      console.error(xhr.responseText);
      Swal.fire("Error", "Failed to update student information", "error"); // Show error message if AJAX request fails
    }
  });
});

// Delete button click event handler
$('#seniorhighStudentsTable').on('click', '.delete-btn', function() {
  var rowData = table.row($(this).parents('tr')).data();
  var studentId = rowData['ID'];

  // Show SweetAlert confirmation dialog
  Swal.fire({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this student!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d9534f",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    customClass: {
        popup: 'small-swal' // Apply custom class for styling
    },
  }).then((result) => {
    if (result.isConfirmed) {
      // User confirmed deletion, proceed with AJAX request
      $.ajax({
        url: 'crud_senior_high.php',
        method: 'POST',
        dataType: 'json',
        data: { student_id: studentId },
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
          Swal.fire("Error", "Failed to delete student", "error");
        }
      });
    } else {
        // User canceled deletion
        Swal.fire({
            title: "Cancelled",
            text: "Student deletion cancelled.",
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
      text: 'Please select at least one student to delete.',
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
        url: 'crud_senior_high.php', // Adjust the URL to your PHP script
        type: 'POST',
        data: {
          'bulkDelete': true,
          'student_ids': selectedIds
        },
        success: function(response) {
          // Parse JSON response
          var data = JSON.parse(response);
          if (data.status === 'success') {
            // Optionally, refresh your DataTable here or show a success message
            Swal.fire(
              'Deleted!',
              'Selected students have been deleted.',
              'success'
            ).then((result) => {
              // Reload DataTable
              $('#seniorhighStudentsTable').DataTable().ajax.reload();
            });
          } else {
            // Handle error
            Swal.fire(
              'Failed!',
              'Failed to delete students: ' + data.error,
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
$('#seniorhighStudentsTable').on('click', '.view-qr-btn', function() {
  // Retrieve the student's Identification Number from the button's data attribute
  var identificationNumber = $(this).data('id');

  // Fetch the student's information from the DataTable row
  var rowData = table.row($(this).closest('tr')).data();
  var firstName = rowData['FirstName'].trim();
  var lastName = rowData['LastName'].trim();

  // Construct the QR code path using the student's Identification Number
  var qrCodePath = 'qr_codes/' + identificationNumber + '.png';

  // Set the src attribute of the QR code image in the modal
  $('#qrCodeImage').attr('src', qrCodePath);

  // Set the filename for downloading to the student's first name and last name
  var filename = firstName + '_' + lastName + '_qr_code.png'; // Using student's first name and last name for filename
  $('#downloadQR').attr('download', filename);

  // Display the student's name inside the card
  $('#studentName').text(firstName + ' ' + lastName);

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



<!-- Add SeniorHigh Modal -->
<div class="modal fade" id="addSeniorHighModal" tabindex="-1" role="dialog" aria-labelledby="addSeniorHighLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
  <div class="modal-header bg-info">
    <h5 class="modal-title" id="addSeniorHighLabel">Add New SeniorHigh Student</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form id="addSeniorHighForm">
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
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="strand">Strand</label>
            <select class="form-control" id="strand" name="strand" required>
              <option value="">Select Strand</option>
              <?php
              include 'database/db.php';
              $query = "SELECT strand_name FROM strands";
              $result = mysqli_query($conn, $query);
              if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . $row['strand_name'] . '">' . $row['strand_name'] . '</option>';
                }
              } else {
                echo '<option value="">Error fetching data</option>';
              }
              mysqli_close($conn);
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="grade">Grade</label>
            <select class="form-control" id="grade" name="grade" required>
              <option value="">Select Grade</option>
              <?php
              include 'database/db.php';
              $query = "SELECT grade_name FROM grades";
              $result = mysqli_query($conn, $query);
              if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . $row['grade_name'] . '">' . $row['grade_name'] . '</option>';
                }
              } else {
                echo '<option value="">Error fetching data</option>';
              }
              mysqli_close($conn);
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="section">Section</label>
            <select class="form-control" id="section" name="section" required>
              <option value="">Select Section</option>
              <?php
              include 'database/db.php';
              $query = "SELECT section_name FROM sections";
              $result = mysqli_query($conn, $query);
              if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . $row['section_name'] . '">' . $row['section_name'] . '</option>';
                }
              } else {
                echo '<option value="">Error fetching data</option>';
              }
              mysqli_close($conn);
              ?>
            </select>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary btn-sm" form="addSeniorHighForm"><i class="fas fa-paper-plane"></i> Submit</button>
  </div>
</div>
</div>
</div>


<!-- Edit SeniorHigh Modal -->
<div class="modal fade" id="editSeniorHighModal" tabindex="-1" role="dialog" aria-labelledby="editSeniorHighModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
  <div class="modal-header bg-primary">
    <h5 class="modal-title" id="editSeniorHighLabel">Edit SeniorHigh Student</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form id="editSeniorHighForm">
      <div class="row">
        <div class="col-md-6">
          <input type="hidden" id="editSeniorHighId" name="editSeniorHighId">
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
          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="editEmail" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="editStrand">Strand</label>
            <select class="form-control" id="editStrand" name="editStrand" required>
              <option value="">Select Strand</option>
              <?php
              include 'database/db.php';
              $strandQuery = "SELECT id, strand_name FROM strands";
              $strandResult = mysqli_query($conn, $strandQuery);
              if ($strandResult && mysqli_num_rows($strandResult) > 0) {
                while ($row = mysqli_fetch_assoc($strandResult)) {
                  echo '<option value="' . $row['strand_name'] . '">' . $row['strand_name'] . '</option>';
                }
              } else {
                echo '<option value="">No strands available</option>';
              }
              mysqli_close($conn);
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="editGrade">Grade</label>
            <select class="form-control" id="editGrade" name="editGrade" required>
              <option value="">Select Grade</option>
              <?php
              include 'database/db.php';
              $gradeQuery = "SELECT id, grade_name FROM grades";
              $gradeResult = mysqli_query($conn, $gradeQuery);
              if ($gradeResult && mysqli_num_rows($gradeResult) > 0) {
                while ($row = mysqli_fetch_assoc($gradeResult)) {
                  echo '<option value="' . $row['grade_name'] . '">' . $row['grade_name'] . '</option>';
                }
              } else {
                echo '<option value="">No grades available</option>';
              }
              mysqli_close($conn);
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="editSection">Section</label>
            <select class="form-control" id="editSection" name="editSection" required>
              <option value="">Select Section</option>
              <?php
              include 'database/db.php';
              $sectionQuery = "SELECT id, section_name FROM sections";
              $sectionResult = mysqli_query($conn, $sectionQuery);
              if ($sectionResult && mysqli_num_rows($sectionResult) > 0) {
                while ($row = mysqli_fetch_assoc($sectionResult)) {
                  echo '<option value="' . $row['section_name'] . '">' . $row['section_name'] . '</option>';
                }
              } else {
                echo '<option value="">No sections available</option>';
              }
              mysqli_close($conn);
              ?>
            </select>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary btn-sm" form="editSeniorHighForm"><i class="fas fa-save"></i> Save Changes</button>
  </div>
</div>
</div>
</div>


<!-- Import CSV Modal -->
<div class="modal fade" id="importSeniorHighCsvModal" tabindex="-1" role="dialog" aria-labelledby="importSeniorHighCsvModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
  <div class="modal-header bg-success">
    <h5 class="modal-title" id="importSeniorHighCsvModalLabel">Import CSV File</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form id="importSeniorHighCsvForm" enctype="multipart/form-data">
      <div class="form-group">
        <label for="csvFile">Choose CSV File</label>
        <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv" required>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary btn-sm" form="importSeniorHighCsvForm">Import</button>
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
            <!-- Student Name -->
            <div id="studentName" class="font-weight-bold" style="font-size: 14px; margin-top: 20px; color: black;">Student Name</div>
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
