<?php
// Include your database connection file
include('../dbconn.php');

// Check if the form is submitted with POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Get the ID from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];

    // Validate the input data
    if (!empty($first_name) && !empty($last_name) && !empty($phone_number)) {
        $sql = "UPDATE users SET firstname=?, lastname=?, phone_no=? WHERE id=?";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters
            $stmt->bind_param("sssi", $first_name, $last_name, $phone_number, $id);

            // Execute the query
            if ($stmt->execute()) {
                echo "success"; // Return success if the update is successful
            } else {
                echo "error: " . $stmt->error; // Log the specific error
            }

            $stmt->close();
        } else {
            echo "error: " . $conn->error; // Log connection or query preparation error
        }
    } else {
        echo "error: Validation failed"; // Return error if the required fields are missing
    }
} else {
    echo "error: Invalid request method"; // Return error if the request method is not POST
}
$conn->close();
?>