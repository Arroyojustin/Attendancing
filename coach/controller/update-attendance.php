<?php
// Include the database connection
include('../../Admin/dbconn.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id']; // Student ID
    $attendance_status = $_POST['attendance_status']; // Attendance status

    // Validate input
    if (!in_array($attendance_status, ['present', 'absent'])) {
        die("Invalid attendance status.");
    }

    // Update the attendance_status in the database
    $sql = "UPDATE students SET attendance_status = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $attendance_status, $student_id);

    if ($stmt->execute()) {
        // Redirect back to the student list page
        header("Location: student-count.php");
        exit;
    } else {
        echo "Error updating attendance: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
