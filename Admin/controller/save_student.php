<?php
// Database connection
include('../dbconn.php');

// Ensure that data is posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get student info from the form
    $firstname = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastName']);
    $mi = mysqli_real_escape_string($conn, $_POST['middleInitial']);
    $student_no = mysqli_real_escape_string($conn, $_POST['studentNumber']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $bmi = mysqli_real_escape_string($conn, $_POST['bmi']);
    $bloodtype = mysqli_real_escape_string($conn, $_POST['bloodType']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['emergencyContact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sportsType = mysqli_real_escape_string($conn, $_POST['sportsType']); // 'basketball' or 'volleyball'

    // Insert student into users table with user_type as 'student'
    $sql = "INSERT INTO users (firstname, lastname, middle_initial, student_no, weight, height, bmi, bloodtype, gender, phone_no, email, password, user_type, sports_type) 
            VALUES ('$firstname', '$lastname', '$mi', '$student_no', '$weight', '$height', '$bmi', '$bloodtype', '$gender', '$phone_no', '$email', '$hashedPassword', 'student', '$sportsType')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error saving student: ' . mysqli_error($conn)]);
    }
}
?>
