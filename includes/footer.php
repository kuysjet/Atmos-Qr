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
</script>