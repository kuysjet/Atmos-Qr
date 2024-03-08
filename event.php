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
          <h3>Event</h3>
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
                <button type="button" class="btn btn-info float-end btn-sm" data-toggle="modal" data-target="#addEventModal">
                  <i class="fas fa-th-list"></i> Add New
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="eventsTable" class="display table table-bordered" style="display: none;">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Event Name</th>
                    <th>Event Venue</th>
                    <th>Event Date</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
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
  <script src="dist/js/pro-pass-toggle.js"></script>


<script>
  $(document).ready(function() {
    // Show the table after the page reloads and the DataTable is initialized
    $('#eventsTable').show();
    // Destroy existing DataTable instance
    if ($.fn.DataTable.isDataTable('#eventsTable')) {
      $('#eventsTable').DataTable().destroy();
    }

    // Initialize DataTable with new settings
    var table = $('#eventsTable').DataTable({
      "ajax": "crud_event.php",
      "columns": [
        { "data": null, "render": function(data, type, row, meta) {
            return meta.row + 1; // Add auto-increment number starting from 1
          }
        },
        { "data": "event_name" },
        { "data": "event_venue" },
        { "data": "event_date" },
        { "data": "log_in" },
        { "data": "log_out" },
        {
          "data": null,
          "render": function(data, type, row) {
            return '<div class="btn-group">' +
                    '<button type="button" class="btn btn-success btn-sm edit-btn mr-1"><i class="fas fa-edit"></i></button>' +
                    '<button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash-alt"></i></button>' +
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
          text: '<i class="fas fa-eye"></i>',
          className: 'btn-sm btn-light border',
        }
      ]
  })




    // Submit form for adding new events
    $('#addEventForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        // Serialize form data
        var formData = $(this).serialize();
        
        // Send AJAX request to add event
        $.ajax({
            url: 'crud_event.php', // PHP script to handle insertion
            method: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    // Reload DataTable upon successful addition
                    $('#eventsTable').DataTable().ajax.reload();
                    // Reset form fields
                    $('#addEventForm')[0].reset();
                    // Close modal
                    $('#addEventModal').modal('hide');
                    // Show success message
                    Swal.fire("Success", "New event added successfully!", "success");
                } else {
                    // Show error message if addition failed
                    Swal.fire("Error", "Failed to add event", "error");
                }
            },
            error: function(xhr, status, error) {
                // Show error message if AJAX request fails
                console.error(xhr.responseText);
                Swal.fire("Error", "Failed to add event", "error");
            }
        });
    });


// Edit button click event handler
$('#eventsTable').on('click', '.edit-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    $('#editEventId').val(rowData['id']);
    $('#editAcademicYear').val(rowData['academic_year_id']);
    $('#editEventName').val(rowData['event_name']);
    $('#editEventVenue').val(rowData['event_venue']);
    $('#editDescription').val(rowData['description']);
    $('#editEventDate').val(rowData['event_date']);
    $('#editLoginTime').val(rowData['log_in']);
    $('#editLogoutTime').val(rowData['log_out']);
    $('#editRegistrar').val(rowData['registrar_id']);
    $('#editEventModal').modal('show');
});

// Submit form for editing event
$('#editEventForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize form data
    // Send AJAX request to update event
    $.ajax({
        url: 'crud_event.php', // PHP script to handle update
        method: 'POST',
        dataType: 'json',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                table.ajax.reload(); // Reload DataTable upon successful update
                $('#editEventModal').modal('hide'); // Close modal
                Swal.fire("Success", "Event information updated successfully!", "success"); // Show success message
            } else {
                Swal.fire("Error", "Failed to update event information", "error"); // Show error message if update failed
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire("Error", "Failed to update event information", "error"); // Show error message if AJAX request fails
        }
    });
});


// Delete button click event handler
$('#eventsTable').on('click', '.delete-btn', function() {
    var rowData = table.row($(this).parents('tr')).data();
    var eventId = rowData['id'];

    // Show SweetAlert confirmation dialog
    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this event!",
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
                url: 'crud_event.php',
                method: 'POST',
                dataType: 'json',
                data: { event_id: eventId },
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
                    Swal.fire("Error", "Failed to delete event", "error");
                }
            });
        } else {
            // User canceled deletion
            Swal.fire({
                title: "Cancelled",
                text: "Event deletion cancelled.",
                icon: "info",
                customClass: {
                    popup: 'small-swal' // Apply custom class for styling
                },
            });
        }
    });
});


  // Function to show or hide the events table based on the status of the selected academic year
  function toggleEventsTable(status) {
      if (status === 'active') {
          $('#eventsTable').show(); // Show the events table if the academic year is active
      } else {
          $('#eventsTable').hide(); // Hide the events table if the academic year is inactive
      }
  }

  // Event listener for changes in the selected academic year
  $('#academicYear').on('change', function() {
      var selectedYearId = $(this).val(); // Get the value of the selected academic year
      // Send AJAX request to fetch the status of the selected academic year
      $.ajax({
          url: 'get_academic_year_status.php', // PHP script to retrieve academic year status
          method: 'POST',
          dataType: 'json',
          data: { academic_year_id: selectedYearId },
          success: function(response) {
              if (response.status === 'success') {
                  // Toggle visibility of the events table based on the status
                  toggleEventsTable(response.data.status);
              } else {
                  console.error('Failed to fetch academic year status');
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });


});



</script>



  <!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new event -->
                <form id="addEventForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="academicYear" class="form-label">Academic Year</label>
                            <select class="form-control col-md-12" id="academicYear" name="academicYear" required>
                                <option value="">Select Academic Year</option>
                                <!-- Populate options dynamically with PHP -->
                                <?php
                                // Query to select academic years
                                $query = "SELECT * FROM academic_years";
                                // Execute the query
                                $result = mysqli_query($conn, $query);
                                // Check if records are found
                                if ($result && mysqli_num_rows($result) > 0) {
                                    // Loop through each academic year
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Output an option for each academic year
                                        echo "<option value='" . $row['id'] . "'>" . $row['academic_year'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No academic years found</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="eventName" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="eventName" name="eventName" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="venue" class="form-label">Event Venue</label>
                            <textarea class="form-control" id="venue" name="venue" required autocomplete="off"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required autocomplete="off"></textarea>
                        </div>
                    </div>

                    <!-- Event Date, Login Time, Logout Time -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="eventDate" class="form-label">Event Date</label>
                            <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                        </div>
                        <div class="col-md-4">
                            <label for="loginTime" class="form-label">Login Time</label>
                            <input type="time" class="form-control" id="loginTime" name="loginTime" required>
                        </div>
                        <div class="col-md-4">
                            <label for="logoutTime" class="form-label">Logout Time</label>
                            <input type="time" class="form-control" id="logoutTime" name="logoutTime" required>
                        </div>
                    </div>

                    <!-- Registrar Select Dropdown -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="registrar" class="form-label">Registrar</label>
                            <select class="form-control" id="registrar" name="registrar" required>
                                <option value="">Select Registrar</option>
                                <!-- Populate options dynamically with PHP -->
                                <?php
                                // Check if the connection is successful
                                if ($conn) {
                                    // Query to select registrars from the users table
                                    $query = "SELECT id, CONCAT(firstname, ' ', lastname) AS name FROM users WHERE user_type_id = (SELECT id FROM user_types WHERE name = 'registrar')";
                                    $result = mysqli_query($conn, $query);

                                    // Check if any registrars are found
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        // Loop through each registrar
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No registrars found</option>";
                                    }
                                } else {
                                    echo "<option value=''>Connection failed</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm" form="addEventForm">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

  <!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editEventForm">
          <div class="row">
            <div class="col-md-6">
              <input type="hidden" id="editEventId" name="editEventId">
              <div class="form-group">
                <label for="editAcademicYear">Academic Year</label>
                  <select class="form-control" id="editAcademicYear" name="editAcademicYear">
                      <?php
                      // Query to select academic years
                      $query = "SELECT id, academic_year FROM academic_years";
                      // Execute the query
                      $result = mysqli_query($conn, $query);
                      // Check if records are found
                      if ($result && mysqli_num_rows($result) > 0) {
                          // Loop through each academic year
                          while ($row = mysqli_fetch_assoc($result)) {
                              // Output an option for each academic year
                              echo "<option value='" . $row['id'] . "'>" . $row['academic_year'] . "</option>";
                          }
                      } else {
                          echo "<option value=''>No academic years found</option>";
                      }
                      ?>
                  </select>
              </div>
              <div class="form-group">
                <label for="editEventName">Event Name</label>
                <input type="text" class="form-control" id="editEventName" name="editEventName" required>
              </div>
              <div class="form-group">
                <label for="editEventVenue">Event Venue</label>
                <input type="text" class="form-control" id="editEventVenue" name="editEventVenue" required>
              </div>
              <div class="form-group">
                <label for="editDescription">Description</label>
                <textarea class="form-control" id="editDescription" name="editDescription" required></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="editEventDate">Event Date</label>
                <input type="date" class="form-control" id="editEventDate" name="editEventDate" required>
              </div>
              <div class="form-group">
                <label for="editLoginTime">Login Time</label>
                <input type="time" class="form-control" id="editLoginTime" name="editLoginTime" required>
              </div>
              <div class="form-group">
                <label for="editLogoutTime">Logout Time</label>
                <input type="time" class="form-control" id="editLogoutTime" name="editLogoutTime" required>
              </div>
              <div class="form-group">
                <label for="editRegistrar">Registrar</label>
                <select class="form-control" id="editRegistrar" name="editRegistrar">
                    <?php
                    // Query to select registrars
                    $query = "SELECT id, CONCAT(firstname, ' ', lastname) AS name FROM users WHERE user_type_id = (SELECT id FROM user_types WHERE name = 'registrar')";
                    // Execute the query
                    $result = mysqli_query($conn, $query);
                    // Check if records are found
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Loop through each registrar
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Output an option for each registrar
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No registrars found</option>";
                    }
                    ?>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="editEventForm">Save Changes</button>
      </div>
    </div>
  </div>
</div>




</body>
</html>
