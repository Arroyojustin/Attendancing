<?php
// Include database connection
include('../../Admin/dbconn.php');

// Ensure user is logged in and is a coach
session_start();
if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== 'coach') {
    echo "You are not authorized to change the password.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Fetch the coach's current data based on email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $coach = $result->fetch_assoc();

    // Check if current password matches
    if (password_verify($current_password, $coach['password'])) {
        // Check if new passwords match
        if ($new_password === $confirm_new_password) {
            // Hash the new password
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_sql = "UPDATE users SET password = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $new_password_hash, $_SESSION['email']);
            $update_stmt->execute();

            echo "Password updated successfully!";
        } else {
            echo "New passwords do not match.";
        }
    } else {
        echo "Current password is incorrect.";
    }

    $stmt->close();
    $conn->close();
}
?>
