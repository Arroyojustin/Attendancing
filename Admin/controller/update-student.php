<?php
// Include the database connection
include('../dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $studentId = $_POST['studentId'];
    $position = $_POST['position'];
    $status = $_POST['status'];

    // Prepare the SQL query to update the student data
    $sql = "UPDATE students SET position = ?, status = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("ssi", $position, $status, $studentId);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update student']);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Query preparation failed']);
    }

    // Close the database connection
    $conn->close();
}
?>
