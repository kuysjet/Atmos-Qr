<!-- Main Footer -->
<footer class="main-footer text-right">
  <!-- Align to the right -->
  <small><strong>&copy; <span id="currentYear"></span> Atmos. All rights reserved.</strong></small>
</footer>

<script>
  // Get the current year
  var currentYear = new Date().getFullYear();
  // Update the year in the footer
  document.getElementById('currentYear').innerText = currentYear;



  // function to handle the logout confirmation
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to logout.php or perform logout operation here
            window.location.href = 'logout.php';
        }
    });
}
</script>