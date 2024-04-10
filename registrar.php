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
          <h3>Registrar</h3>
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
              <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addUserModal">
                <i class="fas fa-user-plus"></i> Add New
              </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="usersTable" class="display table table-bordered nowrap" style="display: none;">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
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
<!-- Bootstrap Toggle JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/datetime.js"></script>
<script src="dist/js/pro-pass-toggle.js"></script>


<script>
$(document).ready(function() {
    // Show the table after the page reloads and the DataTable is initialized
    $('#usersTable').show();
    // Destroy existing DataTable instance
    if ($.fn.DataTable.isDataTable('#usersTable')) {
        $('#usersTable').DataTable().destroy();
    }

    // Initialize DataTable with new settings
    var table = $('#usersTable').DataTable({
        "ajax": "crud_registrar.php",
        "columns": [
            { "data": null, "render": function(data, type, row, meta) {
                return meta.row + 1; // Add auto-increment number starting from 1
            }},
            { "data": "firstname" },
            { "data": "lastname" },
            { "data": "email" },
            { "data": "username" },
            {
              "data": "status",
              "render": function(data, type, row) {
                  if (data === 'active') {
                      return '<button class="status-btn btn btn-success btn-sm" data-id="' + row.id + '">Active</button>';
                  } else {
                      return '<button class="status-btn btn btn-secondary btn-sm" data-id="' + row.id + '">Inactive</button>';
                  }
              }
            },
            {
              "data": null,
              "render": function(data, type, row) {
                return '<div class="btn-group">' +
                        '<button type="button" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>' +
                        '<button type="button" class="btn btn-danger btn-sm delete-btn mx-1"><i class="fas fa-trash-alt"></i></button>' +
                      '</div>';
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
                text: '<i class="fas fa-columns"></i>', 
                titleAttr: 'Column Visibility', // Tooltip for the button
                className: 'btn-sm btn-light border',
            }
        ]
    });


 


  // Handle click on "Select all" control
  $('#select-all').on('click', function(){
    var rows = table.rows({ 'search': 'applied' }).nodes();
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });

  // Handle click on checkbox to set state of "Select all" control
  $('#usersTable tbody').on('change', 'input[type="checkbox"]', function(){
    if(!this.checked){
      var el = $('#select-all').get(0);
      if(el && el.checked && ('indeterminate' in el)){
        el.indeterminate = true;
      }
    }
  });



// Handle click event for status button
$('#usersTable').on('click', '.status-btn', function() {
    var userId = $(this).data('id');
    var status = $(this).text() === 'Active' ? 'inactive' : 'active';

    // Show confirmation dialog using SweetAlert
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to change the status of this user?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, change it!"
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed, send AJAX request to update status
            $.ajax({
                url: 'crud_registrar.php',
                method: 'POST',
                data: { userId: userId, status: status },
                success: function(response) {
                    // Reload DataTable upon successful update
                    table.ajax.reload();
                    // Show success message using SweetAlert
                    Swal.fire("Success", "User status updated successfully", "success");
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Show error message using SweetAlert
                    Swal.fire("Error", "Failed to update user status", "error");
                }
            });
        }
    });
});



    // Handle form submission
    $('#addUserForm').submit(function(e) {
        e.preventDefault(); // Prevent form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Send AJAX request to add user
        $.ajax({
            url: 'crud_registrar.php', // Path to the backend script for adding a user
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // User added successfully
                    $('#addUserModal').modal('hide'); // Hide the modal
                    // Optionally, you can reset the form fields here
                     $('#addUserForm')[0].reset();
                    // Show success message
                    Swal.fire("Success", "User added successfully", "success");
                    
                    // Optional: Update DataTable to reflect the new data
                    $('#usersTable').DataTable().ajax.reload();
                } else {
                    // Failed to add user
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Show error message
                Swal.fire("Error", "Failed to add user", "error");
            }
        });
    });


      // Function to populate the edit modal with user data
  $('#usersTable').on('click', '.edit-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    $('#editUserId').val(rowData.id);
    $('#editFirstname').val(rowData.firstname);
    $('#editLastname').val(rowData.lastname);
    $('#editEmail').val(rowData.email);
    $('#editUsername').val(rowData.username);
    $('#editUserModal').modal('show');
  });

  // Handle form submission for editing user data
  $('#editUserForm').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
      url: 'crud_registrar.php', // PHP script to update user data
      method: 'POST',
      data: formData,
      success: function(response) {
        $('#editUserModal').modal('hide');
        table.ajax.reload(); // Refresh DataTable
        Swal.fire("Success", "User data updated successfully", "success");
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        Swal.fire("Error", "Failed to update user data", "error");
      }
    });
  });

// Delete button click event handler
$('#usersTable').on('click', '.delete-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    var userId = rowData['id'];

    // Show SweetAlert confirmation dialog
    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this user!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d9534f",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        customClass: {
            popup: 'small-swal' // Apply custom class for styling
        },
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed deletion, proceed with AJAX request
            $.ajax({
                url: 'crud_registrar.php',
                method: 'POST',
                dataType: 'json',
                data: { userId: userId },
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
                    Swal.fire("Error", "Failed to delete user", "error");
                }
            });
          } else {
            // User canceled deletion
            Swal.fire({
                title: "Cancelled",
                text: "User deletion cancelled.",
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





<!-- Modal for adding a new user -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Add form fields for collecting user information here -->
        <form id="addUserForm">
          <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required autocomplete="off">
          </div>
          <div class="form-group mb-4 position-relative">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" class="form-control pr-5" id="password" name="password" required autocomplete="off">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                    </span>
                </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary float-right btn-sm"><i class="fas fa-paper-plane"></i> Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>




<!-- Add a modal for editing user data -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for editing user data -->
        <form id="editUserForm">
          <input type="hidden" id="editUserId" name="userId">
          <div class="form-group">
            <label for="editFirstname">First Name</label>
            <input type="text" class="form-control" id="editFirstname" name="firstname" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="editLastname">Last Name</label>
            <input type="text" class="form-control" id="editLastname" name="lastname" required>
          </div>
          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>
          <div class="form-group">
            <label for="editUsername">Username</label>
            <input type="text" class="form-control" id="editUsername" name="username" required>
          </div>
          <button type="submit" class="btn btn-primary float-right btn-sm"><i class="fas fa-save"></i> Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  // Function to toggle password visibility
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var toggleIcon = document.getElementById("togglePassword");

    // Toggle password visibility
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    }
}

// Event listener for toggle eye icon click
document.getElementById("togglePassword").addEventListener("click", function() {
    togglePasswordVisibility();
});
</script>


</body>
</html>
