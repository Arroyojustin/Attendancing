<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ./index.php');
    exit();
}

// Include database connection
include 'dbconn.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];

    // Validate inputs
    if (empty($id) || empty($name) || empty($position)) {
        $error = "All fields are required.";
    } else {
        // Update student record in database
        $stmt = $conn->prepare("UPDATE students SET names = ?, position = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $position, $id);

        if ($stmt->execute()) {
            $success = "Student updated successfully.";
        } else {
            $error = "Failed to update student: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
        
        header('Location: students.php');
        exit();
    }
}
?>
