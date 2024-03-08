$(document).ready(function() {
  $('#toggleCurrentPassword').click(function(){
      togglePasswordVisibility('#currentPassword');
  });

  $('#toggleNewPassword').click(function(){
      togglePasswordVisibility('#newPassword');
  });

  $('#toggleConfirmPassword').click(function(){
      togglePasswordVisibility('#confirmPassword');
  });

  // Clear input fields when modal is hidden
  $('#changePasswordModal').on('hidden.bs.modal', function () {
      $('#changePasswordForm').trigger('reset');
  });

  // Handle form submission
  $('#savePasswordChangesBtn').click(function() {
      var currentPassword = $('#currentPassword').val();
      var newPassword = $('#newPassword').val();
      var confirmPassword = $('#confirmPassword').val();

      // Validate form fields
      if (currentPassword === '' || newPassword === '' || confirmPassword === '') {
          Swal.fire('Error', 'Please fill in all fields.', 'error');
          return;
      }

      if (newPassword !== confirmPassword) {
          Swal.fire('Error', 'New password and confirm password do not match.', 'error');
          return;
      }

      // Send data to the server for password change
      $.ajax({
          type: 'POST',
          url: 'admin_change_password.php', // Replace with the actual endpoint for changing password
          data: {
              currentPassword: currentPassword,
              newPassword: newPassword
          },
          success: function(response) {
              // Handle success response
              response = JSON.parse(response);
              if (response.success) {
                  Swal.fire('Success', 'Password changed successfully.', 'success').then((result) => {
                      if (result.isConfirmed || result.isDismissed) {
                          $('#changePasswordModal').modal('hide');
                      }
                  });
              } else {
                  // Check if the current password is incorrect
                  if (response.message === 'Current password is incorrect.') {
                      Swal.fire('Error', 'Current password is incorrect.', 'error');
                  } else {
                      Swal.fire('Error', 'An error occurred while changing the password. Please try again later.', 'error');
                  }
              }
          },
          error: function(xhr, status, error) {
              // Handle error response
              Swal.fire('Error', 'An error occurred while changing the password. Please try again later.', 'error');
              console.error(xhr.responseText);
          }
      });
  });

  function togglePasswordVisibility(inputId) {
      var input = $(inputId);
      var icon = input.parent().find('.fa');

      if (input.attr('type') === 'password') {
          input.attr('type', 'text');
          icon.removeClass('fa-eye-slash').addClass('fa-eye');
      } else {
          input.attr('type', 'password');
          icon.removeClass('fa-eye').addClass('fa-eye-slash');
      }
  }
});
