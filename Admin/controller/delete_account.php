<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

include '../dbconn.php';

$admin_email = $_SESSION['email'];

// Delete the account from the database
$query = "DELETE FROM admins WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$stmt->close();

// Destroy the session
session_destroy();

// Redirect to the login page (index.php)
header('Location: index.php');
exit();
?>
