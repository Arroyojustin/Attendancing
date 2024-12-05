<?php
include('../dbconn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['error' => 'File upload error']);
        exit;
    }

    $fileTmpPath = $file['tmp_name'];
    $fileType = mime_content_type($fileTmpPath);

    if ($fileType !== 'text/plain' && $fileType !== 'text/csv') {
        echo json_encode(['error' => 'Invalid file type. Only CSV files are allowed.']);
        exit;
    }

    $csvData = array_map('str_getcsv', file($fileTmpPath));

    // Ensure required headers are present
    $headers = array_map('strtolower', array_map('trim', $csvData[0]));
    $requiredHeaders = ['lastname', 'firstname', 'middle_initial', 'student_no', 'phone_no', 'gender', 'email', 'password', 'sports_type'];

    if (count(array_diff($requiredHeaders, $headers)) > 0) {
        echo json_encode(['error' => 'Invalid CSV header format']);
        exit;
    }

    $students = array_slice($csvData, 1);
    $parsedData = [];
    foreach ($students as $row) {
        $data = array_combine($headers, $row);
        $data['plain_password'] = $data['password']; // Save the plain password for the form
        $parsedData[] = $data;

        // Insert the student data into the users table
        $firstname = mysqli_real_escape_string($conn, $data['firstname']);
        $lastname = mysqli_real_escape_string($conn, $data['lastname']);
        $middle_initial = mysqli_real_escape_string($conn, $data['middle_initial']);
        $student_no = mysqli_real_escape_string($conn, $data['student_no']);
        $phone_no = mysqli_real_escape_string($conn, $data['phone_no']);
        $gender = mysqli_real_escape_string($conn, $data['gender']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash password
        $sports_type = mysqli_real_escape_string($conn, $data['sports_type']);
        $user_type = 'student'; // Since all are students

        // Insert into the users table
        $insertQuery = "INSERT INTO users (firstname, lastname, middle_initial, student_no, phone_no, gender, email, password, user_type, sports_type) 
                        VALUES ('$firstname', '$lastname', '$middle_initial', '$student_no', '$phone_no', '$gender', '$email', '$password', '$user_type', '$sports_type')";
        if (!mysqli_query($conn, $insertQuery)) {
            echo json_encode(['error' => 'Failed to insert student into database']);
            exit;
        }
    }

    echo json_encode(['message' => 'Data uploaded successfully', 'data' => $parsedData]);
    exit;
}
?>
