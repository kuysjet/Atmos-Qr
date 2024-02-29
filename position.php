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
          <h3>Position</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-12 text-sm-right">
              <div class="mr-4 small"><b>Philippine Standard Time</b></div>
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
              <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addPositionModal">
                <i class="fas fa-plus"></i> Add New
              </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="positionTable" class="display table table-bordered">
                  <thead>
                  <tr>
                    <th>No.</th>
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
<script src="dist/js/datetime.js"></script>


<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
  // Destroy existing DataTable instance
  if ($.fn.DataTable.isDataTable('#positionTable')) {
    $('#positionTable').DataTable().destroy();
  }

  // Initialize DataTable with new settings
  var table = $('#positionTable').DataTable({
    "ajax": "crud_position.php",
    "columns": [
      { "data": null, "render": function(data, type, row, meta) {
          return meta.row + 1; // Add auto-increment number starting from 1
        }
      },
      { "data": "PositionName" },
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
        className: 'btn-sm btn-light border',
      }
    ]
  });

  $(document).tooltip();

  // Submit form for adding new college student
  $('#addPositionForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    // Serialize form data
    var formData = $(this).serialize();
    // Send AJAX request to add student
    $.ajax({
      url: 'crud_position.php', // PHP script to handle insertion
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          // Reload DataTable upon successful addition
          table.ajax.reload();
          // Reset form fields
          $('#addPositionForm')[0].reset();
          // Close modal
          $('#addPositionModal').modal('hide');
          // Show success message
          Swal.fire("Success", "New position added successfully!", "success");
        } else {
          // Show error message if addition failed
          Swal.fire("Error", "Failed to add position", "error");
        }
      },
      error: function(xhr, status, error) {
        // Show error message if AJAX request fails
        console.error(xhr.responseText);
        Swal.fire("Error", "Failed to add position", "error");
      }
    });
  });

  // Edit button click event handler
  $('#positionTable').on('click', '.edit-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    $('#editPositionId').val(rowData['ID']);
    $('#editPositionName').val(rowData['PositionName']);
    $('#editPositionModal').modal('show');
  });

  // Submit form for editing Position
  $('#editPositionForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize form data
    // Send AJAX request to update student
    $.ajax({
      url: 'crud_position.php', // PHP script to handle update
      method: 'POST',
      dataType: 'json',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          table.ajax.reload(); // Reload DataTable upon successful update
          $('#editPositionModal').modal('hide'); // Close modal
          Swal.fire("Success", "Position information updated successfully!", "success"); // Show success message
        } else {
          Swal.fire("Error", "Failed to update position information", "error"); // Show error message if update failed
        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        Swal.fire("Error", "Failed to update position information", "error"); // Show error message if AJAX request fails
      }
    });
  });

  // Delete button click event handler
  $('#positionTable').on('click', '.delete-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    var positionId = rowData['ID'];

    // Show SweetAlert confirmation dialog
    Swal.fire({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this position!",
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
          url: 'crud_position.php',
          method: 'POST',
          dataType: 'json',
          data: { position_id: positionId },
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
            Swal.fire("Error", "Failed to delete position", "error");
          }
        });
      } else {
          // User canceled deletion
          Swal.fire({
              title: "Cancelled",
              text: "Position deletion cancelled.",
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



<!-- Add Position Modal -->
<div class="modal fade" id="addPositionModal" tabindex="-1" role="dialog" aria-labelledby="addPositionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addSeniorHighLabel">Add New Position</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addPositionForm">
          <div class="form-group">
            <label for="position">Position Name</label>
            <input type="text" class="form-control" id="position" name="position" required autocomplete="off">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="addPositionForm">Submit</button>
      </div>
    </div>
  </div>
</div>


<!-- Add Edit Position Modal -->
<div class="modal fade" id="editPositionModal" tabindex="-1" role="dialog" aria-labelledby="editPositionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="editPositionLabel">Edit Position</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editPositionForm">
          <input type="hidden" id="editPositionId" name="editPositionId">
          <div class="form-group">
            <label for="editPositionName">Position</label>
            <input type="text" class="form-control" id="editPositionName" name="editPositionName" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="editPositionForm">Save Changes</button>
      </div>
    </div>
  </div>
</div>


</body>
</html>
