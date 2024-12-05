$(document).ready(function() {
    $("#profileForm").on("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize(); // Serialize form data
        
        console.log('Form data:', formData); // Log the form data to the console for debugging

        $.ajax({
            url: 'controller/update-profile.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log('Response from server:', response); // Log the response from server
                if(response === 'success') {
                    alert('Profile updated successfully!');
                    // Reload the page to reflect changes
                } else {
                    alert('Error updating profile. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
                console.log(xhr.responseText); // Log the error response
            }
        });
    });
});