<?php include 'includes/header.php'; ?>

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
            <h1 class="m-0">Departments</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Department Page</li>
            </ol>
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
              <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addDepartmentModal">
                <i class="fas fa-plus"></i> Add New
              </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="departmentTable" class="display table table-bordered">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Department</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No.</th>
                    <th>Department</th>
                    <th>Action</th>
                  </tr>
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
<!-- DataTables  & Plugins -->
<!-- Include SweetAlert JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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


<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
  // Destroy existing DataTable instance
  if ($.fn.DataTable.isDataTable('#departmentTable')) {
    $('#departmentTable').DataTable().destroy();
  }

  // Initialize DataTable with new settings
  var table = $('#departmentTable').DataTable({
    "ajax": "crud_department.php",
    "columns": [
      { "data": "ID" },
      { "data": "DepartmentName" },
      {
        "data": null,
        "render": function(data, type, row) {
          return '<i class="fas fa-edit edit-btn text-success mr-2" title="Edit"></i>' +
                '<i class="fas fa-trash-alt delete-btn text-danger" title="Delete"></i>';
        }
      }
    ],
    "responsive": true,
    "lengthChange": false, 
    "autoWidth": false,
    "dom": 'Bfrtip', 
    "buttons": [
      {
        extend: 'colvis',
        text: '<i class="fas fa-eye"></i>',
        className: 'btn-sm',
      }
    ]
  });

  $(document).tooltip();

  // Submit form for adding new college student
  $('#addDepartmentForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    // Serialize form data
    var formData = $(this).serialize();
    // Send AJAX request to add student
    $.ajax({
      url: 'crud_department.php', // PHP script to handle insertion
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          // Reload DataTable upon successful addition
          table.ajax.reload();
          // Reset form fields
          $('#addDepartmentForm')[0].reset();
          // Close modal
          $('#addDepartmentModal').modal('hide');
          // Show success message
          Swal.fire("Success", "New department added successfully!", "success");
        } else {
          // Show error message if addition failed
          Swal.fire("Error", "Failed to add department", "error");
        }
      },
      error: function(xhr, status, error) {
        // Show error message if AJAX request fails
        console.error(xhr.responseText);
        Swal.fire("Error", "Failed to add department", "error");
      }
    });
  });

  // Edit button click event handler
  $('#departmentTable').on('click', '.edit-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    $('#editDepartmentId').val(rowData['ID']);
    $('#editDepartmentName').val(rowData['DepartmentName']);
    $('#editDepartmentModal').modal('show');
  });

  // Submit form for editing Department
  $('#editDepartmentForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize form data
    // Send AJAX request to update student
    $.ajax({
      url: 'crud_department.php', // PHP script to handle update
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          table.ajax.reload(); // Reload DataTable upon successful update
          $('#editDepartmentModal').modal('hide'); // Close modal
          Swal.fire("Success", "Department information updated successfully!", "success"); // Show success message
        } else {
          Swal.fire("Error", "Failed to update department information", "error"); // Show error message if update failed
        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        Swal.fire("Error", "Failed to update department information", "error"); // Show error message if AJAX request fails
      }
    });
  });

  // Delete button click event handler
  $('#departmentTable').on('click', '.delete-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    var departmentId = rowData['ID'];

    // Show SweetAlert confirmation dialog
    Swal.fire({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this department!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d9534f",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        // User confirmed deletion, proceed with AJAX request
        $.ajax({
          url: 'crud_department.php',
          method: 'POST',
          dataType: 'json',
          data: { department_id: departmentId },
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
            Swal.fire("Error", "Failed to delete department", "error");
          }
        });
      } else {
        // User canceled deletion
        Swal.fire("Department deletion canceled!");
      }
    });
  });
});
</script>



<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addSeniorHighLabel">Add New Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addDepartmentForm">
          <div class="form-group">
            <label for="department">Department Name</label>
            <input type="text" class="form-control" id="department" name="department" required autocomplete="off">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Add Edit Department Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editDepartmentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="editDepartmentLabel">Edit Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editDepartmentForm">
          <input type="hidden" id="editDepartmentId" name="editDepartmentId">
          <div class="form-group">
            <label for="editDepartmentName">Department</label>
            <input type="text" class="form-control" id="editDepartmentName" name="editDepartmentName" required>
          </div>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


</body>
</html>
