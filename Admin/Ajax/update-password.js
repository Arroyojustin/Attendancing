document.getElementById('changePasswordBtn').addEventListener('click', function() {
    var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    changePasswordModal.show();  // Bootstrap's way to show modal
});

document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const currentPassword = document.getElementById('current_password').value;
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_new_password').value;

    if (newPassword !== confirmPassword) {
        alert('Passwords do not match');
        return;
    }

    const formData = new FormData();
    formData.append('current_password', currentPassword);
    formData.append('new_password', newPassword);

    fetch('controller/change_password.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Password updated successfully');
            
            // Hide the modal after successful password update
            var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            changePasswordModal.hide();  // Bootstrap's way to hide modal after success
        } else {
            alert(data.message || 'Error updating password');
        }
    })
    .catch(error => console.error('Error:', error));
});
