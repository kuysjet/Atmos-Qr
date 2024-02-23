
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Code Reader</title>

  <!-- Fonts and Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500&family=Oswald:wght@200;300;400&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">

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

  </style>
</head>
<body>
<div class="vh-100 d-flex justify-content-center align-items-center">
  <div class="container bg-white">
    <div class="row">
      <div class="col-md-12 p-3 shadow-lg rounded">
        <div class="border p-3 shadow-sm rounded">
          <marquee class="pb-2" width="100%" direction="left">
            <b>A t t e n d a n c e  M o n i t o r i n g  -  Q R  C o d e</b>
          </marquee>
          <h5 class="text-white py-2 text-center"><span class="blink"><small>SHOW QR CODE</small></span></h5>
          <div class="row align-items-center mb-2">
            <div class="col-md-6">
              <div class="input-group">
                <div class="input-group-prepend">
                  <label for="timeOption" class="input-group-text bg-success text-white">
                    <small><i class="fa-regular fa-clock mr-1"></i>Scan Option</small>
                  </label>
                </div>
                <select class="form-select form-control" id="timeOption" aria-label="Select Scan Option">
                  <option value="timeIn">Time In</option>
                  <option value="timeOut">Time Out</option>
                </select>
              </div>
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
                <input type="text" class="form-control border border-success" placeholder="Identification Number">
                <span class="input-group-append">
                  <button type="button" class="btn btn-success btn-flat"><i class="fa-solid fa-check"></i></button>
                </span>
              </div>
            </div>

            <audio id="successSound" src="dist/audio/scanner-beep.mp3" preload="auto"></audio>
            <audio id="errorSound" src="dist/audio/error_sound.mp3" preload="auto"></audio>
            <div class="col-md-6 col-sm-12">
              <div class="table-responsive">
                <table id="resultTable" class="display table table-bordered"  style="font-size:small;">
                <thead>
                  <tr>
                    <!-- <th>#</th> -->
                    <th>Name</th>
                    <th>Time-In</th>
                    <th>Time-Out</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <!-- <th>#</th> -->
                    <th>Name</th>
                    <th>Time-In</th>
                    <th>Time-Out</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- QR Code Scanner -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>



  <script>
var resultTable = $('#resultTable').DataTable({
  responsive: true,
  lengthChange: false,
  autoWidth: false,
  orderable: true,
  dom: 'Blfrtip', 
  buttons: [
    {
      extend: 'collection',
      text: 'Export',
      className: 'btn-sm',
      buttons: [
        'excel',
        'pdf',
        'print'
      ],
    },
    {
      extend: 'colvis',
      text: 'Toggle Columns',
      className: 'btn-sm',
      columns: ':not(:first-child)'
    },
    {
      text: '<i class="fas fa-trash"></i>',
      className: 'btn-sm btn-danger',
      action: function ( e, dt, node, config ) {
        var selectedRows = dt.rows('.selected').indexes();
        if (selectedRows.length >  0) {
          dt.rows(selectedRows).remove().draw();
          Swal.fire({
            title: 'Deleted!',
            text: 'Selected rows have been deleted.',
            icon: 'success',
            timer:  2500,
            showConfirmButton: false
          });
        } else {
          Swal.fire({
            icon: 'info',
            title: 'No Selection',
            text: 'Please select at least one row to delete.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      }
    }
  ],
  // ... other options
});

// Initialize row selection
$(document).ready(function() {
  $('#resultTable tbody').on( 'click', 'tr', function () {
    $(this).toggleClass('selected');
  });
});



    var lastScanTime = 0; // Timestamp of the last successful scan


  function onScanSuccess(qrCodeMessage) {
    
    var currentTime = Date.now();
    // Check if 2 seconds have passed since the last scan
    if (currentTime - lastScanTime < 2000) return;
    // Update last scan time
    lastScanTime = currentTime;

  var currentTime = new Date().toLocaleTimeString();
  var timeOption = $('#timeOption').val();

  var qrCodeExists = resultTable.data().toArray().some(row => row[0] === qrCodeMessage);
  var rowIndex = resultTable.data().toArray().findIndex(row => row[0] === qrCodeMessage);

  if(timeOption === "timeIn") {
    if (!qrCodeExists) {
      // Add new record with Time In
      resultTable.row.add([
        qrCodeMessage,
        currentTime, // Time In
        '', // Time Out initially empty
      ]).order([1, 'desc']).draw(false); // 'draw(false)' keeps the current paging
      // Move to the first page where the newest row is
    resultTable.page('first').draw('page');
      playSuccessSound();
    } else {
      // Show alert for already scanned Time In
      Swal.fire({
        icon: 'warning',
        title: 'Already Time In',
        text: 'This QR code has already been scanned for Time In.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      errorSound.play();
    }
  } else if (timeOption === "timeOut") {
    if (qrCodeExists && resultTable.cell(rowIndex, 2).data() === '') {
      // Update Time Out for existing record
      resultTable.cell(rowIndex, 2).data(currentTime).draw();
      playSuccessSound();
    } else if (!qrCodeExists) {
      // Show alert for missing Time In record
      Swal.fire({
        icon: 'error',
        title: 'No Time In Record',
        text: 'Please Time In first before scanning for Time Out.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      errorSound.play();
    } else {
      // Show alert for already scanned Time Out
      Swal.fire({
        icon: 'warning',
        title: 'Already Time Out',
        text: 'This QR code has already been scanned for Time Out.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      errorSound.play();
    }
  }
}

function playSuccessSound() {
    // Play success sound
    var successSound = document.getElementById('successSound');
    if (successSound) {
        successSound.play();
    }

    // Show SweetAlert success message and close it after 5 seconds
    Swal.fire({
        icon: 'success',
        title: 'Scanned Successfully!',
        text: 'QR Code has been scanned successfully.',
        showConfirmButton: false,
        timer: 2500
    });
}



    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
            customClass: {
            popup: 'small-swal' // Apply custom class for styling
        },
        });

        // Play error sound
        var errorSound = document.getElementById('errorSound');
        if (errorSound) {
            errorSound.play();
        }
    }


    function onScanError(errorMessage) {
        // error logic
    }

    var html5QrCodeScanner = new Html5QrcodeScanner("reader", {
      fps: 10,  
      qrbox: 250
    });

    html5QrCodeScanner.render(onScanSuccess, onScanError);



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


</body>
</html>

