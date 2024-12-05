<?php
// Include the database connection
require './Admin/dbconn.php';

// Function to retrieve accounts and hash passwords
function retrieveAndHashPasswords($conn) {
    // Retrieve all users
    $query = "SELECT id, password FROM users";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userId = $row['id'];
            $password = $row['password'];

            // Check if the password is already hashed
            if (!password_get_info($password)['algo']) {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("si", $hashedPassword, $userId);

                if ($stmt->execute()) {
                    echo "Password for user ID $userId hashed successfully.<br>";
                } else {
                    echo "Failed to update password for user ID $userId: " . $stmt->error . "<br>";
                }

                $stmt->close();
            } else {
                echo "Password for user ID $userId is already hashed.<br>";
            }
        }
    } else {
        echo "No users found in the database.<br>";
    }
}

// Call the function
retrieveAndHashPasswords($conn);

// Close the database connection
$conn->close();
?>
