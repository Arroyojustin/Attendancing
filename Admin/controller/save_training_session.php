<?php
include '../dbconn.php';

// Get the POST data
$trainingDate = $_POST['trainingDate'];
$trainingTime = $_POST['trainingTime'];
$sportType = $_POST['sportType'];
$location = $_POST['location'];

// Prepare the SQL query
$sql = "INSERT INTO training_sessions (training_date, training_time, sport_type, location) VALUES (?, ?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $trainingDate, $trainingTime, $sportType, $location);

// Execute the query
if ($stmt->execute()) {
    // Success: Return a JSON response with the saved data
    echo json_encode([
        'success' => true,
        'trainingDate' => $trainingDate,
        'trainingTime' => $trainingTime,
        'sportType' => $sportType,
        'location' => $location
    ]);
} else {
    // Error: Return a JSON response indicating failure
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
