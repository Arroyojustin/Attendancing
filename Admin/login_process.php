<?php
session_start();
include './dbconn.php';

// Collect email and password from POST request
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare and execute query to retrieve the user
$stmt = $conn->prepare("SELECT password, user_type, sports_type FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Check if the email exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashedPassword, $userType, $sportsType);
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $hashedPassword)) {
        // Set session variables
        $_SESSION['email'] = $email;
        $_SESSION['user_type'] = $userType;
        $_SESSION['sports_type'] = $sportsType; // Store sports_type in session

        // If the user is a coach, ensure sports_type is set correctly
        if ($userType == 'coach') {
            if ($sportsType === 'volleyball') {
                // Redirect to volleyball coach page
                $redirectUrl = './vcoach/v-view.php';
            } else {
                // Default to basketball coach page (or any other coach type)
                $redirectUrl = './coach/overview.php';
            }
        } elseif ($userType == 'admin') {
            $redirectUrl = './coordinator/admin.php';
        } elseif ($userType == 'coordinator') {
            $redirectUrl = './Admin/coordinator.php';
        } elseif ($userType == 'student') {
            $redirectUrl = './Student/stud.php';
        } else {
            $redirectUrl = '../index.php'; // For undefined user types
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Login Successful',
            'redirect' => $redirectUrl
        ]);
    } else {
        // Invalid password
        echo json_encode(['status' => 'error', 'message' => 'Invalid password.']);
    }
} else {
    // Email not registered
    echo json_encode(['status' => 'error', 'message' => 'Email not registered.']);
}

$stmt->close();
$conn->close();
?>
