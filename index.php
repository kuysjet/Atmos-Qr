<?php

include 'includes/header.php';
?>

<!-- Include Bootstrap CSS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->

  <style>

  .gradient {
    /* Fallback for old browsers */
    background: #0a2e46; /* A single color fallback (navy blue) */

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, #0a2e46, #003366, #004b8d, #0063b2);

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, #0a2e46, #003366, #004b8d, #0063b2);
}


  @media (min-width: 768px) {
  .gradient-form {
    height: 100vh !important;
  }
}
  @media (min-width: 769px) {
  .gradient {
    border-top-right-radius: .3rem;
    border-bottom-right-radius: .3rem;
  }
}

  .password-toggle-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
  }

  .password-toggle-icon {
    cursor: pointer;
    color: grey; 
  }
  
  </style>
  
</head>
<body>

<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black h-100">
          <div class="row g-0 h-100">
            <div class="col-lg-6 h-100">
              <div class="card-body p-md-5 mx-md-4 h-100">

              <div class="text-center">
                <img src="dist/img/aclc_complete_logo.png" alt="logo" class="img-fluid w-75">
              </div>

                <form action="code.php" method="POST">
                  <h5 class="text-center text-md-center my-3">Login to get started</h5>

                  <div class="form-outline mb-4">
                        <label class="form-label hidden-label small" >Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" autocomplete="off" required />
                  </div>
                  <div class="form-outline mb-4 position-relative">
                        <label class="form-label hidden-label small" >Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required />
                        <i class="fas fa-eye-slash password-toggle-icon mt-3" onclick="togglePassword('password')"></i>
                  </div>


                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient mb-3" type="submit">Login</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <!-- <h4 class="">Attendance Monitoring with QR Code</h4> -->
                <img src="dist/img/visitor-management-img2.png" alt="Attendance Monitoring with QR Code Image" class="img-fluid">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Include Bootstrap Bundle JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>




<script>
  // Function to toggle password visibility
  function togglePassword(inputId) {
    var input = document.getElementById(inputId);
    var icon = document.querySelector('.password-toggle-icon');
    
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    }
  }

  // Function to show alert messages
  document.addEventListener('DOMContentLoaded', function () {
    // Check if there is a parameter in the URL indicating an error
    const urlParams = new URLSearchParams(window.location.search);
    const errorParam = urlParams.get('error');

    if (errorParam === 'invalid_password') {
      Swal.fire({
        icon: 'error',
        title: 'Invalid password',
        text: 'Please enter the correct password.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    } else if (errorParam === 'user_not_found') {
      Swal.fire({
        icon: 'error',
        title: 'User not found',
        text: 'Please check your username and try again.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    } else if (errorParam === 'user_inactive') {
      Swal.fire({
        icon: 'warning',
        title: 'Inactive user',
        text: 'Your account is currently inactive. Please contact the administrator.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }
  });
</script>




  
</body>
</html>
