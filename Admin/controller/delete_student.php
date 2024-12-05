<?php
// Include the database connection file
include 'dbconn.php';

// Check if 'id' is set in POST request
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $student_id = $_POST['id'];

    // Prepare and execute the delete query
    $delete_query = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Student deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete student.']);
    }

    $stmt->close();
} else {
    // Send an error response if 'id' is not provided
    echo json_encode(['status' => 'error', 'message' => 'Invalid request or missing data.']);
}

// Close the database connection
$conn->close();
?>
