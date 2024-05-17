<!-- Main Footer -->
<footer class="main-footer text-right">
  <!-- Align to the right -->
  <small><strong>&copy; <span id="currentYear"></span>&nbsp;<a href="https://atmoscanpro.com" target="_blank" class="text-black">atmoscanpro.com</a> All rights reserved.</strong></small>
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

  // Function to toggle the icons and update their classes based on dark mode status
  function toggleDarkModeIcons() {
    const moonIcon = document.querySelector('#darkModeToggleBtn .fa-moon');
    const sunIcon = document.querySelector('#darkModeToggleBtn .fa-sun');

    // Check if dark mode is enabled
    const darkModeEnabled = document.body.classList.contains('dark-mode');

    // Toggle icons based on dark mode status
    if (darkModeEnabled) {
      moonIcon.classList.add('d-none');
      sunIcon.classList.remove('d-none');
      sunIcon.classList.add('rotate'); // Add rotation class
    } else {
      moonIcon.classList.remove('d-none');
      sunIcon.classList.add('d-none');
      sunIcon.classList.remove('rotate'); // Remove rotation class
    }
  }

  // Call the initialization function when the page loads
  // window.onload = function() {
    initializeDarkModeToggle();
  // };
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