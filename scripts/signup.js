 // Get the password and confirm password input fields
 const password = document.getElementById('password');
 const confirmPassword = document.getElementById('confirm-password');
 const confirmPasswordMessage = document.getElementById('error-message');
 const submitBtn = document.getElementById('submit-btn');

 // Function to check if passwords match
 function checkPasswords() {
     if (password.value === confirmPassword.value) {
         confirmPassword.classList.remove('password-mismatch');
         confirmPassword.classList.add('password-match');
         confirmPasswordMessage.style.display = 'none'; // Hide the message if they match
         submitBtn.disabled = false; // Enable the submit button
     } else {
         confirmPassword.classList.remove('password-match');
         confirmPassword.classList.add('password-mismatch');
         confirmPasswordMessage.style.display = 'block'; // Show message if they don't match
         submitBtn.disabled = true; // Disable the submit button
     }
 }

 // Add an event listener to the confirm password field
 confirmPassword.addEventListener('input', checkPasswords);
 password.addEventListener('input', checkPasswords); // Optional to update on both fields


