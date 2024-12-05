<?php
session_start();
require '../dbconn.php'; // Database connection

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['id'];
$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];

// Fetch current password from the database
$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($dbPassword);
$stmt->fetch();
$stmt->close();

// Verify current password
if (!password_verify($currentPassword, $dbPassword)) {
    echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
    exit;
}

// Hash the new password
$newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

// Update the password in the database
$updateSql = "UPDATE users SET password = ? WHERE id = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("si", $newPasswordHash, $userId);

if ($updateStmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating password']);
}

$updateStmt->close();
$conn->close();
?>
