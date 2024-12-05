<?php
include '../Admin/dbconn.php';

if (isset($_POST['id']) && isset($_POST['names']) && isset($_POST['position']) && isset($_POST['status'])) {
    $studentId = $_POST['id'];
    $names = $_POST['names'];
    $position = $_POST['position'];
    $status = $_POST['status'];

    // Prepare the update query
    $stmt = $conn->prepare("UPDATE students SET names = ?, position = ?, status = ? WHERE id = ?");
    
    if (!$stmt) {
        echo json_encode(['error' => 'Failed to prepare the statement. SQL Error: ' . $conn->error]);
        exit();
    }

    // Bind the parameters
    $stmt->bind_param("sssi", $names, $position, $status, $studentId);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to update student. SQL Error: ' . $stmt->error]);
    }    
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid data. Missing parameters.']);
}
?>
