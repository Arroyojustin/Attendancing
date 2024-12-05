<?php
// Include your database connection file
include('../../Admin/dbconn.php');

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted with POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Get the ID from the form
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $middle_initial = $_POST['middleInitial'];
    $student_number = $_POST['studentNumber'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $bmi = $_POST['bmi'];
    $blood_type = $_POST['bloodType'];
    $gender = $_POST['gender'];
    $emergency_contact = $_POST['emergencyContact'];

    // Validate the input data
    if (!empty($first_name) && !empty($last_name) && !empty($student_number) && !empty($weight) && !empty($height) && !empty($emergency_contact)) {
        
        // SQL query to update student profile
        $sql = "UPDATE users SET firstname=?, lastname=?, middle_initial=?, student_no=?, weight=?, height=?, bmi=?, bloodtype=?, gender=?, phone_no=? WHERE id=? AND user_type='student'";

        // Check if the SQL query is prepared successfully
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssssddssssi", $first_name, $last_name, $middle_initial, $student_number, $weight, $height, $bmi, $blood_type, $gender, $emergency_contact, $id);

            // Execute the query
            if ($stmt->execute()) {
                echo "success"; // Return success if the update is successful
            } else {
                // Log specific error if the query execution fails
                echo "Error executing query: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            // Log error if the statement preparation fails
            echo "Error preparing the SQL query: " . $conn->error;
        }
    } else {
        // Handle validation failure
        echo "error: Validation failed - Some fields are missing.";
    }
} else {
    // Handle invalid request method
    echo "error: Invalid request method. POST expected.";
}

// Close the database connection
$conn->close();
?>
