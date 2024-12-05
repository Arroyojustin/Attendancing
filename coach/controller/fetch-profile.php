<?php
// Include database connection
include('../../Admin/dbconn.php');

if (isset($_GET['id'])) {
    $studentId = $_GET['id'];

    // Prepare the query to fetch student data based on ID
    $stmt = $conn->prepare("SELECT u.firstname, u.lastname, s.position, u.sports_type 
                            FROM users u 
                            JOIN students s ON u.id = s.user_id 
                            WHERE u.id = ?");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $stmt->bind_result($firstname, $lastname, $position, $sports_type);
    $stmt->fetch();
    
    // Prepare the response data as an associative array
    $student = [
        'full_name' => $firstname . ' ' . $lastname,
        'position' => $position,
        'sports_type' => $sports_type
    ];
    
    // Return the data as a JSON response
    echo json_encode($student);

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
