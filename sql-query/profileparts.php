<?php
// Start the session
session_start();

// Check if the user is logged in by verifying the session email
if (!isset($_SESSION['email'])) {
    // Redirect to login page if email is not in session
    header('Location: ../Admin/index.php');
    exit();
}

// Fetch the admin's email from the session
$admin_email = $_SESSION['email'];

// Debugging: Ensure the session email is set
if (empty($admin_email)) {
    echo "Session email not found.";
    exit();
}

// Include your database connection
include '../Admin/dbconn.php'; // Adjust this path to your actual file structure

// Initialize variables to avoid undefined variable warnings
$first_name = '';
$last_name = '';
$phone_number = '';

// Fetch admin details from the database using the session email
$query = "SELECT first_name, last_name, phone_number FROM admins WHERE email = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    // If the query fails, output the error
    echo "Query preparation failed: " . $conn->error;
    exit();
}

$stmt->bind_param("s", $admin_email);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $phone_number);

// Check if any data was fetched
if (!$stmt->fetch()) {
    echo "No data found for the provided email: " . htmlspecialchars($admin_email);
    exit();
}

$stmt->close();
$conn->close();

// Extract initials from email for display
$email_parts = explode('@', $admin_email);
$name_part = $email_parts[0];
$initials = strtoupper($name_part[0] . (isset($name_part[1]) ? $name_part[1] : '')); // Ensure there's at least one character
?>
