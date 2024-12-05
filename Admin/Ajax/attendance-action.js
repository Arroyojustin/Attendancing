$(document).ready(function() {
    $('.attendance-btn').on('click', function() {
        var status = $(this).data('status'); // Get the status (present/absent/excused)
        var studentId = $(this).data('id'); // Get the student ID

        // Show a SweetAlert confirmation
        Swal.fire({
            title: 'Confirm Attendance',
            text: `Mark this student as ${status}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, confirm!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with the AJAX call to record attendance
                $.ajax({
                    url: 'controller/record_attendance.php', // Make sure this path is correct
                    type: 'POST',
                    data: {
                        status: status,
                        student_id: studentId
                    },
                    success: function(response) {
                        const jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            // Display success alert
                            Swal.fire({
                                title: 'Success!',
                                text: jsonResponse.message,
                                icon: 'success'
                            });
                        } else {
                            // Display error alert
                            Swal.fire({
                                title: 'Error!',
                                text: jsonResponse.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Display error alert for AJAX failure
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while recording attendance: ' + textStatus,
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});