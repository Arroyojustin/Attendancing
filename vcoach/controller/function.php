<?php
if (!function_exists('getStudentDataBySportsType')) {
    function getStudentDataBySportsType($conn, $sports_type) {
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT u.firstname, u.lastname, u.student_no, s.position 
                FROM users u
                JOIN students s ON u.id = s.user_id
                WHERE u.user_type = 'student' AND u.sports_type = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sports_type);  // Bind the sports_type parameter (e.g., volleyball)
        $stmt->execute();
        $result = $stmt->get_result();

        $students = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;  // Store student data in an array
            }
        }
        $stmt->close();

        return $students;  // Return the array of students
    }
}
?>
