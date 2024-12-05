<?php
include('../../Admin/dbconn.php');

// Check if required data is received
if (isset($_POST['user_id']) && isset($_POST['acads_progress']) && isset($_POST['training_progress'])) {
    $user_id = $_POST['user_id'];
    $acads_progress = $_POST['acads_progress'];
    $training_progress = $_POST['training_progress'];

    // Debugging output to ensure the parameters are being passed correctly
    echo "User ID: $user_id, Acads Progress: $acads_progress, Training Progress: $training_progress";

    // Prepare the SQL UPDATE query to update the student's progress data
    $sql = "UPDATE students s 
            JOIN users u ON u.id = s.user_id
            SET s.acads_progress = ?, s.training_progress = ?
            WHERE s.user_id = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);

    // Binding parameters: "ddii" for two decimal values and one integer
    $stmt->bind_param("ddi", $acads_progress, $training_progress, $user_id);

    if ($stmt->execute()) {
        echo "Progress updated successfully.";
    } else {
        echo "Error updating progress: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
