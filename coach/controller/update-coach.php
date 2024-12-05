<?php
// Include your database connection file
include('../../Admin/dbconn.php');

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); // If not, stop the script and show an error
}

// Check if the form is submitted with POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Get the ID from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];

    // Validate the input data
    if (!empty($first_name) && !empty($last_name) && !empty($phone_number)) {
        
        // SQL query to update coach profile
        $sql = "UPDATE users SET firstname=?, lastname=?, phone_no=? WHERE id=? AND user_type='coach'";

        // Check if the SQL query is prepared successfully
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssi", $first_name, $last_name, $phone_number, $id);

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
