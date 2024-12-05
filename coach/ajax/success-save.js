document.getElementById('attendanceForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this); // Create a FormData object with the form data

    // Make an AJAX request to save the attendance
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'controller/save-student-count.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText); // Parse the JSON response

            // Check the response status and show an appropriate alert
            if (response.status === 'success') {
                alert(response.message); // Show success message
                document.getElementById('saved').style.display = 'block'; // Display saved message container
            } else {
                alert(response.message); // Show error message
            }
        }
    };
    xhr.send(formData); // Send the form data via AJAX
});
