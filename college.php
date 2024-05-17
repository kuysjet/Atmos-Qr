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
  <!-- <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> -->
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


<?php 
  include 'includes/scroll-button.php';
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
          <h3>College</h3>
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
      <div class="card">
              <div class="card-header">
                <marquee width="100%" direction="left"> <b>A t t e n d a n c e &nbsp; M o n i t o r i n g &nbsp; - &nbsp; Q R &nbsp; C o d e</b></marquee>
              </div>
              <div class="card-header m-0">
                <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addCollegeModal">
                  <i class="fas fa-user-plus fa-sm"></i> Add New
                </button>
                <button type="button" class="btn btn-success float-end btn-sm" data-toggle="modal" data-target="#importCsvModal">
                  <i class="fas fa-file-import fa-sm"></i> Import CSV
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="collegeStudentsTable" class="display table table-bordered nowrap" style="display: none; width:100%;">
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
                    <th>Course</th>
                    <th>Level</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                    <tfoot>
                      <th></th>
                      <th>No.</th>
                      <th>ID Number</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email Address</th>
                      <th>Course</th>
                      <th>Level</th>
                      <th>Action</th>
                    </tfoot>
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
</div>
<!-- ./wrapper -->

<?php include 'includes/footer.php';?>
  
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
<!-- <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script> -->
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.jqueryui.min.js"></script>
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
  $('#collegeStudentsTable').show();
  // Destroy existing DataTable instance
  if ($.fn.DataTable.isDataTable('#collegeStudentsTable')) {
    $('#collegeStudentsTable').DataTable().destroy();
  }

  // Initialize DataTable with new settings
  var table = $('#collegeStudentsTable').DataTable({
    "ajax": "crud_college.php",
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
      { "data": "course_name" },
      { "data": "level_name" },
      {
        "data": null,
        "render": function(data, type, row) {
          return '<button type="button" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>' +             
                 '<button type="button" class="btn btn-success btn-sm view-qr-btn mx-1" data-id="' + row.IdentificationNumber + '"><i class="fas fa-qrcode"></i></button>' +
                 '<button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash-alt"></i></button>';
        }
      }
    ],
    "responsive": {
        details: {
            renderer: function ( api, rowIdx, columns ) {
                var data = $.map( columns, function ( col, i ) {
                    if(i != 0 && i != 1 && i != 7){ // Exclude columns 0 (checkbox), 1 (auto-increment), and 7 (actions)
                        return col.hidden ?
                            '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                '<td>'+col.title+':'+'</td> '+
                                '<td>'+col.data+'</td>'+
                            '</tr>' :
                            '';
                    } else {
                        return '';
                    }
                } ).join('');

                return data ?
                    $('<table/>').append( data ) :
                    false;
            }
        }
    },
    "lengthChange": false, 
    "autoWidth": false,
    "dom": 'Blfrtip', 
    "buttons": [
    {
        extend: 'collection',
        text: '<i class="fas fa-file-export"></i> ',
        titleAttr: 'Export', // Tooltip for the button
        className: 'btn-sm btn-light border',
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
              ],
          },
          {
              extend: 'colvis',
              text: '<i class="fas fa-columns"></i> ',
              titleAttr: 'Column Visibility', // Tooltip for the button
              className: 'btn-sm btn-light border mx-1',
          },
          {
            extend: 'pageLength', // Add the "Page Length" button
            text: '<i class="fas fa-list-ol"></i> ', // Icon for Page Length button
            titleAttr: 'Page Length', // Tooltip for the button
            className: 'btn-sm btn-light border',
          }
        ], 
  });

    // Setup - add a text input to each footer cell for individual column search
    $('#collegeStudentsTable tfoot th').each(function(index) {
        if (index > 5 && index !== 8) { // Skip the five column and the eighth column
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }
    });

    // DataTable - apply the search
    table.columns().every(function(index) {
        if (index > 5 && index !== 8) { // Skip the five column and the eighth column
            var that = this;
            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        }
    });


  // Handle click on "Select all" control
  $('#select-all').on('click', function(){
    var rows = table.rows({ 'search': 'applied' }).nodes();
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });

  // Handle click on checkbox to set state of "Select all" control
  $('#collegeStudentsTable tbody').on('change', 'input[type="checkbox"]', function(){
    if(!this.checked){
      var el = $('#select-all').get(0);
      if(el && el.checked && ('indeterminate' in el)){
        el.indeterminate = true;
      }
    }
  });

  
  // Submit form for adding new college student
  $('#addCollegeForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = new FormData($(this)[0]); // Serialize form data including file
    // Send AJAX request to add student
    $.ajax({
      url: 'crud_college.php', // PHP script to handle insertion
      method: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,  // Important to prevent jQuery from processing the file
      contentType: false,  // Important to prevent jQuery from setting contentType
      success: function(response) {
        if (response.status === 'success') {
          // Reload DataTable upon successful addition
          table.ajax.reload();
          // Reset form fields
          $('#addCollegeForm')[0].reset();
          // Close modal
          $('#addCollegeModal').modal('hide');
          // Show success message
          Swal.fire("Success", "New student added successfully!", "success");
        } else if (response.status === 'error') {
          // Check for specific error messages
          if (response.error === 'Duplicate identification number') {
            Swal.fire("Error", "Duplicate identification number", "error");
          } else if (response.error === 'Duplicate email') {
            Swal.fire("Error", "Duplicate email", "error");
          } else {
            // Show general error message if addition failed for other reasons
            Swal.fire("Error", "Failed to add student", "error");
          }
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
$('#importCsvForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    // Show loader
    $('#loader').removeClass('d-none');

    var formData = new FormData(this); // Create FormData object
    // Send AJAX request to import CSV
    $.ajax({
        url: 'import_csv_college.php',
        method: 'POST',
        dataType: 'json',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Hide loader
            $('#loader').addClass('d-none');

            if (response.status === 'success') {
                // Refresh DataTable upon successful import
                table.ajax.reload();
                // Close modal
                $('#importCsvModal').modal('hide');
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
            // Hide loader
            $('#loader').addClass('d-none');
            // Show error message if AJAX request fails
            Swal.fire("Error", "Failed to import students", "error");
        }
    });
});



// Edit button click event handler
$('#collegeStudentsTable').on('click', '.edit-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    $('#editStudentId').val(rowData['ID']);
    $('#editIdentificationNumber').val(rowData['IdentificationNumber']);
    $('#editFirstName').val(rowData['FirstName']);
    $('#editLastName').val(rowData['LastName']);
    $('#editEmail').val(rowData['Email']);
    $('#editCourse').val(rowData['course_name']); 
    $('#editLevel').val(rowData['level_name']); 
    $('#editStudentModal').modal('show');
});


  // Submit form for editing college student
  $('#editStudentForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize form data
    // Send AJAX request to update student
    $.ajax({
      url: 'crud_college.php', // PHP script to handle update
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          table.ajax.reload(); // Reload DataTable upon successful update
          $('#editStudentModal').modal('hide'); // Close modal
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
  $('#collegeStudentsTable').on('click', '.delete-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    var studentId = rowData['ID'];

    // Show Swal confirmation dialog
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
          url: 'crud_college.php',
          method: 'POST',
          dataType: 'json',
          data: { student_id: studentId },
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
          url: 'crud_college.php', // Adjust the URL to your PHP script
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
                $('#collegeStudentsTable').DataTable().ajax.reload();
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
$('#collegeStudentsTable').on('click', '.view-qr-btn', function() {
  // Retrieve the student's Identification Number from the button's data attribute
  var identificationNumber = $(this).data('id');

  // Fetch the QR code image data from the server
  $.ajax({
    url: 'fetch_college_qr_code.php', // URL to fetch QR code from server
    type: 'POST',
    dataType: 'json',
    data: { identificationNumber: identificationNumber },
    success: function(response) {
      if (response.status === 'success') {
        // Set the src attribute of the QR code image in the modal
        $('#qrCodeImage').attr('src', 'data:image/png;base64,' + response.qrCodeImage);

        // Set the filename for downloading to the student's first name and last name
        var filename = response.firstName + '_' + response.lastName + '_qr_code.png';
        $('#downloadQR').attr('download', filename);

        // Display the student's name inside the card
        $('#studentName').text(response.firstName + ' ' + response.lastName);
        // Display the student's position inside the card
        $('#studentCL').text(response.course + '-' + response.level);

        // Show the modal
        $('#viewQrCodeModal').modal('show');
      } else {
        // Handle error
        alert('Failed to fetch QR code.');
      }
    },
    error: function() {
      // Handle error
      alert('Failed to fetch QR code. Please try again later.');
    }
  });
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







<!-- Add College Modal -->
<div class="modal fade" id="addCollegeModal" tabindex="-1" role="dialog" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addCollegeModalLabel">Add New College Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addCollegeForm" enctype="multipart/form-data"> <!-- Add enctype attribute for file upload -->
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
                <label for="course">Course</label>
                <select class="form-control" id="course" name="course" required>
                  <option value="">Select Course</option> <!-- Blank option -->
                  <?php
                  // Database connection code
                  include 'database/db.php';

                  // Query to fetch courses from the courses table
                  $queryCourse = "SELECT id, course_name FROM courses";
                  $stmtCourse = $conn->prepare($queryCourse);
                  $stmtCourse->execute();
                  $resultCourse = $stmtCourse->get_result();

                  // Generate options for each course
                  while ($rowCourse = $resultCourse->fetch_assoc()) {
                    echo '<option value="' . $rowCourse['id'] . '">' . $rowCourse['course_name'] . '</option>';
                  }

                  // Close database connection
                  mysqli_close($conn);
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="level">Level</label>
                <select class="form-control" id="level" name="level" required>
                  <option value="">Select Level</option> <!-- Blank option -->
                  <?php
                  // Database connection code (already included above)
                  include 'database/db.php';

                  // Query to fetch levels from the levels table
                  $queryLevel = "SELECT id, level_name FROM levels";
                  $stmtLevel = $conn->prepare($queryLevel);
                  $stmtLevel->execute();
                  $resultLevel = $stmtLevel->get_result();

                  // Generate options for each level
                  while ($rowLevel = $resultLevel->fetch_assoc()) {
                    echo '<option value="' . $rowLevel['id'] . '">' . $rowLevel['level_name'] . '</option>';
                  }

                  // Close database connection (already included above)
                  mysqli_close($conn);
                  ?>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="addCollegeForm"><i class="fas fa-paper-plane fa-sm"></i> Submit</button>
      </div>
    </div>
  </div>
</div>




<!-- Add Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="editStudentModalLabel">Edit College Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editStudentForm">
          <div class="row">
            <div class="col-md-6">
              <input type="hidden" id="editStudentId" name="editStudentId">
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
                <label for="editCourse">Course</label>
                <select class="form-control" id="editCourse" name="editCourse" required>
                    <?php
                    // Database connection code
                    include 'database/db.php';

                    // Query to fetch course names from the Courses table
                    $query = "SELECT course_name FROM courses";
                    $result = mysqli_query($conn, $query);

                    // Check if query was successful
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Fetch course names and generate options
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
                        }
                    } else {
                        // If query fails or no courses found, display an error option
                        echo '<option value="">No courses found</option>';
                    }

                    // Close database connection
                    mysqli_close($conn);
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="editLevel">Level</label>
                  <select class="form-control" id="editLevel" name="editLevel" required>
                  <?php
                  // Database connection code
                  include 'database/db.php';

                  // Query to fetch level name from the Levels table
                  $query = "SELECT level_name FROM levels";
                  $result = mysqli_query($conn, $query);

                  // Check if query was successful
                  if ($result && mysqli_num_rows($result) > 0) {
                      // Fetch level name and generate options
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo '<option value="' . $row['level_name'] . '">' . $row['level_name'] . '</option>';
                      }
                  } else {
                      // If query fails or no levels found, display an error option
                      echo '<option value="">No levels found</option>';
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
        <button type="submit" class="btn btn-primary btn-sm" form="editStudentForm"><i class="fas fa-save fa-sm"></i> Save Changes</button>
      </div>
    </div>
  </div>
</div>








<!-- Import CSV Modal -->
<div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="importCsvModalLabel">Import CSV File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="importCsvForm" enctype="multipart/form-data">
          <div class="form-group">
            <label for="csvFile">Choose CSV File</label>
            <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv" required>
          </div>
          <!-- Loader -->
          <div id="loader" class="text-center d-none">
              <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
              <p class="mt-2">Importing...</p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="importCsvForm"><i class="fas fa-file-import fa-sm"></i> Import</button>
      </div>
    </div>
  </div>
</div>



<!-- View QR Code Modal -->
<div class="modal fade" id="viewQrCodeModal" tabindex="-1" aria-labelledby="viewQrCodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="viewQrCodeModalLabel">Digital QR ID</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center d-flex flex-column align-items-center justify-content-center" id="modalBodyToDownload">
        <!-- Card with Background Image inside Modal Body with Medium Size -->
        <div class="card" id="cardToDownload" style="width: 300px;">
          <img src="dist/img/Card-College.png" class="card-img" alt="Background Image" style="width: 100%; height: auto;">
          <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
            <!-- Logo above the QR Code -->
            <img src="dist/img/aclc_complete_logo.png" alt="Logo" style="width: 100px; height: auto; margin-bottom: 20px; position:absolute; top: 0%; right:0%;">
            <!-- Profile Image -->
            <img src="dist/img/no-avatar.jpg" class="rounded-circle" id="collegeProfile" alt="Profile Image" style="width: 140px; height: 140px; border: 3px solid #233DFF;">
            <!-- Student Name -->
            <div id="studentName" class="font-weight-bold" style="font-size: 14px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin-top: 6px; color: black; display: inline-block; max-width: 70%;">Student Name</div>
            <!-- Student Course & Level -->
            <div id="studentCL" class="font-weight-bold mb-2" style="font-size: 10px; color:#233DFF; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">Course & Level</div>
            <!-- QR Code Image -->
            <img id="qrCodeImage" alt="QR Code" style="width: 180px; height: auto;">
            <!-- Logo below the QR Code -->
            <img src="dist/img/new-icon.png" class="rounded-circle" alt="Logo" style="width: 30px; height: auto; margin-bottom: 8px; position:absolute; bottom: 0%; right: 2%;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="downloadQR"><i class="fas fa-download fa-sm"></i> Download</button>
      </div>
    </div>
  </div>
</div>




</body>
</html>
