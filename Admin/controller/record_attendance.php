<?php
include './dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $status = $_POST['status'];

    // Insert the attendance record into the attendance table
    $insert_query = "INSERT INTO attendance (student_id, status, estimation_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("is", $student_id, $status); // Adjust the bind_param as needed
    $success = $stmt->execute();
    
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Attendance recorded successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to record attendance.']);
    }

    $stmt->close();
}
$conn->close();
?>
