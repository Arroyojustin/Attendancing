$(document).ready(function() {
    $("#updateStudentForm").on("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Serialize form data, including file if any

        console.log('Form data:', formData); // Log the form data to the console for debugging

        $.ajax({
            url: 'controller/update-student.php', // Path to the PHP script
            method: 'POST',
            data: formData,
            contentType: false, // Don't set content type, necessary for FormData
            processData: false, // Do not process data (important for file uploads)
            success: function(response) {
                console.log('Response from server:', response); // Log the response from the server
                if (response === 'success') {
                    alert('Profile updated successfully!');
                } else {
                    alert('Error updating profile. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
                console.log(xhr.responseText); // Log the error response for better debugging
            }
        });
    });
});
