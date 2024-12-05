document.getElementById('changePasswordBtn').addEventListener('click', function() {
    $('#changePasswordModal').modal('show'); // Open the modal
});

// Handle the form submission
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Gather form data
    const formData = new FormData(this);

    // Send data to the backend using fetch API
    fetch('controller/password-update.php', {
        method: 'POST',
        body: formData // Pass the form data to the PHP script
    })
    .then(response => response.text()) // Get the response from the server
    .then(data => {
        alert(data); // Show success or error message
        if (data === 'Password updated successfully!') {
            $('#changePasswordModal').modal('hide'); // Close modal if password is updated
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the password.');
    });
});