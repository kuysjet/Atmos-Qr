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
            <h1 class="m-0">Registrars</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
              <li class="breadcrumb-item active">Registrar Page</li>
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
              <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addRegistrarModal">
                <i class="fas fa-user-plus"></i> Add New
              </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="registrarsTable" class="display table table-bordered">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
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

<!-- Add Registrar Modal -->
<div class="modal fade" id="addRegistrarModal" tabindex="-1" role="dialog" aria-labelledby="addRegistrarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addRegistrarModalLabel">Add Registrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addRegistrarForm" action="handle_registrar.php" method="post">
          <div class="form-group">
            <label for="regFName">First Name</label>
            <input type="text" class="form-control" id="regFName" name="reg_fname" required>
          </div>
          <div class="form-group">
            <label for="regLName">Last Name</label>
            <input type="text" class="form-control" id="regLName" name="reg_lname" required>
          </div>
          <div class="form-group">
            <label for="regEmail">Email Address</label>
            <input type="email" class="form-control" id="regEmail" name="reg_email" required>
          </div>
          <div class="form-group">
            <label for="regUsername">UserName</label>
            <input type="text" class="form-control" id="regUsername" name="reg_username" required>
          </div>
          <div class="form-group">
            <label for="regPassword">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="regPassword" name="reg_password" required>
              <div class="input-group-append">
                <button class="btn btn-outline-secondary toggle-password" type="button">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
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

<script>
$(function () {
  $("#registrarsTable").DataTable({
    "responsive": true,
    "lengthChange": false, 
    "autoWidth": false,
    "orderable": true,
    "dom": 'Bfrtip', 
    "buttons": [
      {
        extend: 'colvis',
        text: '<i class="fas fa-eye"></i>', // Eye icon for column visibility
        className: 'btn-sm',
      }
    ],
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
</script>
<script>
$(document).ready(function () {
  $(".toggle-password").click(function () {
    var passwordField = $("#regPassword");
    var fieldType = passwordField.attr("type");
    // Toggle password visibility
    if (fieldType === "password") {
      passwordField.attr("type", "text");
    } else {
      passwordField.attr("type", "password");
    }
    // Toggle eye icon
    $(this).find("i").toggleClass("fa-eye fa-eye-slash");
  });
});
</script>



</body>
</html>
