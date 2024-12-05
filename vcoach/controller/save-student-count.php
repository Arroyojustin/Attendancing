<?php
// Include the database connection
include('../../Admin/dbconn.php');

// Function to update attendance based on submitted data for volleyball students
function saveAttendance($conn) {
    // Get all student IDs and attendance status from the form
    if (isset($_POST['attendance_status']) && isset($_POST['student_id'])) {
        foreach ($_POST['attendance_status'] as $index => $status) {
            $student_id = $_POST['student_id'][$index];

            // Check if the student is a volleyball player
            $sql_check = "SELECT * FROM users WHERE id = ? AND sports_type = 'volleyball'";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param('i', $student_id);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result->num_rows > 0) {
                // Insert or update the attendance record for today
                $date = date('Y-m-d');
                $sql = "INSERT INTO attendance (student_id, attendance_date, status) 
                        VALUES (?, ?, ?) 
                        ON DUPLICATE KEY UPDATE status = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssss', $student_id, $date, $status, $status);
                $stmt->execute();
            }
        }
    }

    return true;
}

// Call the function to save attendance
if (saveAttendance($conn)) {
    echo "Attendance recorded successfully for volleyball players!";
} else {
    echo "There was an issue recording attendance for volleyball players.";
}

// Close the database connection
$conn->close();
?>
