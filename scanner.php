<?php
session_start();

include 'database/db.php';

// Check if the user is not logged in or is not a registrar
if (!isset($_SESSION['username']) || $_SESSION['user_type_id'] != 2) {
    // Redirect to the login page
    header('Location: index.php');
    exit(); // Stop further execution
}

// Check if eventId is set in the URL parameters
if (isset($_GET['eventId'])) {
    // Retrieve event details from URL parameters
    $eventId = $_GET['eventId'];
    $eventName = urldecode($_GET['eventName']);

    // Use the event details as needed
    // echo "Scanning QR Code for Event: $eventName (ID: $eventId)";
} else {
    echo "Event ID is not set!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="dist/img/icon.png">
  <title>ATMOS | Scanner</title>

  <!-- Fonts and Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500&family=Oswald:wght@200;300;400&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Add the DataTables CDN -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.4/css/select.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

  <style>
    body {
      font-family: 'oswald', Arial;
      background-color: #ecf0f5;
    }

    h5{
      background-color: #123368;
      border-top-left-radius: 4px;
      border-top-right-radius: 4px;
    }
    .blink {
      animation: blinker 1s step-end infinite;
    }

    @keyframes blinker {
      50% {
        opacity: 0;
      } 
    }
    
    /* Custom CSS to adjust the size of SweetAlert dialog */
    .swal2-popup {
      font-size: 0.8rem; /* Adjust font size */
      width: 20rem; /* Adjust width */
    }

      /* Styling for scroll buttons */
      .scroll-to-top {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
    }

    .scroll-to-bottom {
      position: fixed;
      bottom: 70px;
      right: 20px;
      z-index: 1000;
    }

    /* Apply the blink animation to the scanner status */
    .costum-blink {
        animation: blinker 2s ease-in-out infinite; /* Adjust animation duration and timing function */
    }

    /* icon palpitate when hover */
    i:hover {
    animation: palpitate 0.5s infinite alternate;
    }

    @keyframes palpitate {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.1);
        }
    }
  </style>
</head>
<body>
  <!-- Scroll to top button -->
  <button class="btn btn-primary scroll-to-top d-sm-none" onclick="scrollToTop()" style="opacity: 0.3; border-radius: 50%;">
    <i class="fas fa-arrow-up"></i>
  </button>
  <!-- Scroll to bottom button -->
  <button class="btn btn-primary scroll-to-bottom d-sm-none" onclick="scrollToBottom()" style="opacity: 0.3; border-radius: 50%;">
    <i class="fas fa-arrow-down"></i>
  </button>

<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 px-0">
  <div class="container bg-white">
    <div class="row">
      <div class="col-md-12 p-3 shadow-lg rounded">
        <div class="border p-3 shadow-sm rounded">
          <marquee class="pb-2" width="100%" direction="left">
            <b class="marquee-text" style="letter-spacing: 5px;">Attendance Monitoring - QR Code</b>
          </marquee>
          <h5 class="text-white py-2 text-center"><span class="blink"><small>SHOW QR CODE</small></span></h5>
          <div class="row align-items-center mb-2">
            <div class="col-md-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <label for="timeOption" class="input-group-text bg-success text-white">
                    <small><i class="fa-regular fa-clock mr-1"></i>Scan Option</small>
                  </label>
                </div>
                <select class="form-select form-control border border-success" id="timeOption" aria-label="Select Scan Option">
                  <option value="timeIn">Time In</option>
                  <option value="timeOut">Time Out</option>
                </select>
              </div>
            </div>
            <!-- Add a online/offline status indicator -->
            <div class="col-md-1 text-center mt-1">
              <div id="scannerStatus" class="text-center mb-2">
                <span id="scannerStatusIcon"></span>
              </div>
            </div>
            <div class="col-md-1 text-center">
              <!-- Add a microphone icon for toggling speech -->
              <label for="speechToggle"><i id="speechIcon" class="fas fa-microphone" title="Toggle Speech"></i></label>
                <input type="checkbox" id="speechToggle" class="d-none">
            </div>
            <div class="col-md-6 text-center mt-1">
              <div class="current-date-time">
                <p class="m-0 font-weight-bold" id="currentDateTime"></p>
              </div>
            </div>
          </div>

          <!-- QR SCANNER CODE BELOW -->
          <div class="row">
            <div class="col-md-6 col-sm-12">
                <div id="reader"></div>
                <div class="input-group input-group-sm my-2">
                  <input type="text" id="manualInput" class="form-control border border-success" placeholder="Identification Number">
                    <span class="input-group-append">
                        <button type="button" id="manualInputButton" class="btn btn-success btn-flat" style="min-width: 65px;"><i class="fas fa-check"></i></button>
                    </span>
              </div>
            </div>
            
            <!-- Table for displaying attendance -->
            <div class="col-md-6">
              <div class="d-flex justify-content-center mb-2">
                <button type="button" class="btn btn-block btn-light py-0" data-toggle="modal" data-target="#eventModal">
                    <h6 class="m-0 py-1"><b><?php echo $eventName ?></b></h6>
                </button>
              </div>
              <!-- <div class="table-responsive"> -->
                <table id="attendanceTable" class="table compact table-bordered table-striped responsive table-hover nowrap" style="width:100%;">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Time In</th>
                      <th>Time Out</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Attendance data will be inserted here dynamically -->
                  </tbody>
                </table>
              <!-- </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- QR Code Scanner -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.jqueryui.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
<!-- Add the DataTables ColVis extension -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable with responsive, select, and Buttons extensions
    table = $('#attendanceTable').DataTable({
        responsive: true,
        "lengthChange": false, 
        "autoWidth": false,
        select: 'multi', // Enable row selection
        dom: 'Blfrtip', // Add buttons to the DataTable (B for buttons, l for length menu)
        buttons: [
            {
                extend: 'pageLength', // Add the "Page Length" button
                text: '<i class="fas fa-list-ol"></i>', // Icon for Page Length button
                titleAttr: 'Page Length', // Tooltip for the button
            },
            {
                extend: 'colvis', // ColVis button
                text: '<i class="fas fa-columns"></i>', // Icon for column visibility
                titleAttr: 'Column Visibility' // Tooltip for the button
            },
            {
                text: '<i class="fas fa-trash-alt"></i>', // Icon for delete
                titleAttr: 'Delete Selected', // Tooltip for the button
                action: function () {
                    var selectedRows = table.rows({ selected: true });
                    if (selectedRows.count() > 0) {
                        // Show confirmation dialog before deleting
                        Swal.fire({
                            icon: 'warning',
                            title: 'Confirm Deletion',
                            text: 'Are you sure you want to delete the selected attendance record(s)?',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Loop through each selected row
                                selectedRows.every(function (index, tableLoop, rowLoop) {
                                    var rowNode = this.node(); // Get the row node
                                    // Call the function to delete attendance record for this row
                                    deleteAttendance(rowNode);
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'No Rows Selected',
                            text: 'Please select at least one row to delete.',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                enabled: false // Initially disable the button
            }
        ], 
        ajax: {
            url: 'attendance_fetch.php', // URL to fetch attendance data
            type: 'POST', // HTTP request method
            data: { eventId: <?php echo $eventId; ?> }, // Additional data to send to the server
            dataSrc: '' // Property from which to fetch the data (empty for direct array)
        },
        columns: [
          { 
                data: null,
                render: function (data, type, row, meta) {
                    // Render an auto-increment number starting from 1
                    return meta.row + 1;
                }
            },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'time_in' },
            { data: 'time_out' }
        ]
    });

    // Event listener for row selection/deselection
    table.on('select deselect', function () {
        // Enable or disable the delete button based on whether any rows are selected
        var selectedRows = table.rows({ selected: true }).count();
        table.button(2).enable(selectedRows > 0);
    });

    // Set interval to reload the table every 2 seconds (adjust the interval as needed)
    setInterval(function() {
        // Check if there are any rows selected
        var selectedRows = table.rows({ selected: true }).count();

        // Check if any cell in the table is being edited
        var editing = $('.dataTables_processing').length > 0;

        // If no rows are selected and no cell is being edited, reload the table
        if (selectedRows === 0 && !editing) {
            table.ajax.reload(null, false); // Reload the DataTable without resetting current page
        }
    }, 2000); // 2000 milliseconds = 2 seconds

});

// Function to delete attendance record
function deleteAttendance(rowNode) {
    // Get the attendance ID from the DataTable row
    var data = table.row(rowNode).data();
    var attendance_id = data['attendance_id'];
    
    // Log the attendance_id to verify it's being passed correctly
    console.log("Attendance ID:", attendance_id);
    
    // Check if attendance_id is defined
    if (attendance_id === undefined) {
        console.error("Attendance ID is undefined");
        return;
    }
    
    // Send AJAX request to delete attendance record
    $.ajax({
        url: 'attendance_delete.php',
        method: 'POST',
        data: { attendance_id: attendance_id },
        success: function(response) {
            // Display success message using SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Attendance record deleted successfully!',
                timer: 1000, // Close the alert after 2 seconds
                timerProgressBar: true
            }).then((result) => {
                // Remove the row from the DataTable after successful deletion
                table.row(rowNode).remove().draw();
            });
        },
        error: function(xhr, status, error) {
            // Display error message using SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to delete attendance record. Please try again.'
            });
        }
    });
}








// Define audio elements
var successSound = new Audio('dist/audio/scanner-beep.mp3');
var errorSound = new Audio('dist/audio/error_sound.mp3');

// Variable to track whether scanning is currently allowed
var scanningAllowed = true;

function onScanSuccess(decodedText, decodedResult) {
    // Check if scanning is allowed
    if (!scanningAllowed) {
        return; // If not allowed, exit the function
    }

    // Disable scanning for 2 seconds
    scanningAllowed = false;
    setTimeout(function() {
        scanningAllowed = true;
    }, 2500); // 2000 milliseconds = 2 seconds

    // Extract the IdentificationNumber from the decoded text
    var identificationNumber = decodedText;

    // Get the selected scan option (timeIn or timeOut)
    var scanOption = $('#timeOption').val();

    // Call the function to handle attendance
    handleAttendance(identificationNumber, scanOption);
}

// Function to speak the alert message using Web Speech API
function speakAlertMessage(message) {
    // Check if speech functionality is enabled
    if ($('#speechToggle').is(':checked')) {
        // Delay the speech by 1 second
        setTimeout(function() {
            // Create a new SpeechSynthesisUtterance object with the message
            var utterance = new SpeechSynthesisUtterance(message);
            // Speak the message
            speechSynthesis.speak(utterance);
        }, 1000); // Delay for 1 second (1000 milliseconds)
    }
}

// Function to handle attendance based on identificationNumber and scanOption
function handleAttendance(identificationNumber, scanOption) {
          // Check if the system is offline
          if (!navigator.onLine) {
            // Handle offline code detection here
            Swal.fire({
                icon: 'warning',
                title: 'Offline',
                text: 'The system is offline. Please try again when online.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            errorSound.play(); // Play error sound
            // Speak the alert message
            speakAlertMessage('The system is offline. Please try again when online.');
            return;
        }
    // Send AJAX request to add attendance
    $.ajax({
        url: 'attendance_add.php',
        method: 'POST',
        data: {
            identificationNumber: identificationNumber,
            eventId: <?php echo $eventId; ?>,
            eventTime: new Date().toLocaleTimeString(),
            scanOption: scanOption
        },
        success: function(response) {
            if (response.trim() === "Invalid identification number!") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Identification number not found or not registered.'
                });
                errorSound.play(); // Play error sound
                // Speak the alert message
                speakAlertMessage('Identification number not found or not registered.');
            } else {
                if (scanOption === "timeIn") {
                    if (response.trim() === "Attendance added successfully!") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response,
                            timer: 1500, // Close the alert after 1 second
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                        successSound.play(); // Play success sound
                        // Speak the alert message
                        speakAlertMessage('Attendance added successfully!');
                        // Clear manual input field
                        $('#manualInput').val('');
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Already Time In',
                            text: 'This QR code has already been scanned for Time In.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        errorSound.play(); // Play error sound
                        // Speak the alert message
                        speakAlertMessage('This QR code has already been scanned for Time In.');
                    }
                } else if (scanOption === "timeOut") {
                    if (response.trim() === "Attendance added successfully!") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response,
                            timer: 1500, // Close the alert after 1 second
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                        successSound.play(); // Play success sound
                        // Speak the alert message
                        speakAlertMessage('Attendance added successfully!');
                        // Clear manual input field
                        $('#manualInput').val('');
                    } else if (response.includes('Time in is required')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'No Time In Record',
                            text: 'Please Time In first before scanning for Time Out.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        errorSound.play(); // Play error sound
                        // Speak the alert message
                        speakAlertMessage('Please Time In first before scanning for Time Out.');
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Already Time Out',
                            text: 'This QR code has already been scanned for Time Out.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        errorSound.play(); // Play error sound
                        // Speak the alert message
                        speakAlertMessage('This QR code has already been scanned for Time Out.');
                    }
                }
                
                // If attendance was added successfully, update the table
                if (response.trim() === "Attendance added successfully!") {
                    // Reload the DataTable to fetch updated data
                    table.ajax.reload();
                }
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to add attendance. Please try again.'
            });
            errorSound.play(); // Play error sound
            // Speak the alert message
            speakAlertMessage('Failed to add attendance. Please try again.');
        }
    });
}


// Event listener for manual input button click
$('#manualInputButton').click(function() {
    // Get the manual input identification number
    var identificationNumber = $('#manualInput').val().trim();
    // Get the selected scan option (timeIn or timeOut)
    var scanOption = $('#timeOption').val();
    // Call the function to handle attendance
    handleAttendance(identificationNumber, scanOption);
});


  // Function to update the scanner status UI
  function updateScannerStatus() {
      var scannerStatusIcon = document.getElementById("scannerStatusIcon");
      if (navigator.onLine) {
          // If online, display a green checkmark icon with text and blinking effect
          scannerStatusIcon.innerHTML = '<i class="fas fa-circle text-success costum-blink"></i> Online';
      } else {
          // If offline, display a red times icon with text and blinking effect
          scannerStatusIcon.innerHTML = '<i class="fas fa-circle text-danger costum-blink"></i> Offline';
      }
  }

  // Call the updateScannerStatus function initially to display the initial status
  updateScannerStatus();

  // Add event listener to update the scanner status whenever the online/offline status changes
  window.addEventListener('online', function() {
      updateScannerStatus();
  });

  window.addEventListener('offline', function() {
      updateScannerStatus();
  });


// QR Code Reader
var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 200 });
html5QrcodeScanner.render(onScanSuccess);


// DateTime functionality
function updateDateTime() {
    const currentDateTimeElement = document.getElementById("currentDateTime");
    
    const currentDate = new Date();
    const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const dayOfWeek = currentDate.getDay();
    const dayName = daysOfWeek[dayOfWeek];

    const currentDateTime = `${dayName}, ${currentDate.toLocaleString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit", // Add seconds here
    })}`;

    currentDateTimeElement.textContent = currentDateTime;
}

// Update date and time every second (adjust the interval as needed)
setInterval(updateDateTime, 1000);

// Call it initially to display the date and time
updateDateTime();


</script>
<script>
    // Function to scroll to the top of the page
    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Function to scroll to the bottom of the page
    function scrollToBottom() {
      window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }
  </script>
  <script>
    // Function to toggle the speech icon
  function toggleSpeechIcon() {
      var icon = document.getElementById('speechIcon');
      var checkbox = document.getElementById('speechToggle');
      
      // Check if the checkbox is checked
      if (checkbox.checked) {
          // If checked, display the microphone icon with a slash
          icon.className = 'fas fa-microphone';
      } else {
          // If not checked, display the microphone icon without a slash
          icon.className = 'fas fa-microphone-slash';
      }
  }

  // Event listener for checkbox change
  document.getElementById('speechToggle').addEventListener('change', toggleSpeechIcon);

  // Call the function initially to set the initial icon state
  toggleSpeechIcon();
  </script>


<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title text-light" id="eventModalLabel">Event Details</h6>
                <span type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </span>
            </div>
            <div class="modal-body ml-3">
                <?php
                // Fetch event details from the database based on $eventId
                $query = "SELECT * FROM events WHERE id = $eventId";
                $result = mysqli_query($conn, $query);

                // Check if query was successful and if there is at least one row returned
                if ($result && mysqli_num_rows($result) > 0) {
                    // Fetch event details
                    $event = mysqli_fetch_assoc($result);
                    ?>
                      <p><strong class="mr-2">Event Name:</strong> <?php echo $event['event_name']; ?></p>
                      <p><strong class="mr-2">Event Venue:</strong> <?php echo $event['event_venue']; ?></p>
                      <p><strong class="mr-2">Description:</strong> <?php echo $event['description']; ?></p>
                      <p><strong class="mr-2">Event Date: &nbsp;</strong> <?php echo date('l, F j, Y', strtotime($event['event_date'])); ?></p>
                      <p><strong class="mr-2">Log In: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong> <?php echo date('h:i A', strtotime($event['log_in'])); ?></p>
                      <p><strong class="mr-2">Log Out: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong> <?php echo date('h:i A', strtotime($event['log_out'])); ?></p>
                    <?php
                } else {
                    // Display a message if no event details are found
                    echo "Event details not found.";
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <!-- Add more modal buttons if needed -->
            </div>
        </div>
    </div>
</div>


</body>
</html>
    