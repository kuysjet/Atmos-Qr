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

<!-- function for darkmode -->
<script>
  function initializeDarkModeToggle() {
    // Check if dark mode is enabled in localStorage
    const darkModeEnabled = localStorage.getItem('darkModeEnabled');

    // If dark mode is enabled, add 'dark-mode' class to body
    if (darkModeEnabled === 'true') {
      document.body.classList.add('dark-mode');
      // Display moon icon in dark mode
      document.querySelector('#darkModeToggleBtn .fa-moon').classList.remove('d-none');
      document.querySelector('#darkModeToggleBtn .fa-sun').classList.add('d-none');
    } else {
      // Display sun icon in light mode
      document.querySelector('#darkModeToggleBtn .fa-moon').classList.add('d-none');
      document.querySelector('#darkModeToggleBtn .fa-sun').classList.remove('d-none');
    }

    // Toggle button click event
    document.getElementById('darkModeToggleBtn').addEventListener('click', function() {
      // Toggle dark mode class on body
      document.body.classList.toggle('dark-mode');

      // Toggle icons
      toggleDarkModeIcons();

      // Update localStorage with current dark mode status
      localStorage.setItem('darkModeEnabled', document.body.classList.contains('dark-mode'));
    });

    // Set initial state of icons
    toggleDarkModeIcons();
  }

  // Function to toggle the icons
  function toggleDarkModeIcons() {
    document.querySelector('#darkModeToggleBtn .fa-moon').classList.toggle('d-none');
    document.querySelector('#darkModeToggleBtn .fa-sun').classList.toggle('d-none');
  }

  // Call the initialization function when the page loads
  window.onload = function() {
    initializeDarkModeToggle();
  };
</script>