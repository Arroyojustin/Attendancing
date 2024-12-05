<?php
// Include the database connection
include('./../Admin/dbconn.php');

// Function to fetch students data (only basketball players)
function fetchBasketballStudentsData($conn) {
    $students = [];
    
    // Prepared query to fetch full name (firstname, lastname), student number, position, and status for basketball students
    $sql = "SELECT u.id, u.firstname, u.lastname, u.student_no, s.position, 
            COALESCE(s.status, 'inactive') AS status, u.sports_type
            FROM users u 
            LEFT JOIN students s ON u.id = s.user_id 
            WHERE u.user_type = 'student' AND u.sports_type = 'basketball'";
    
    $result = $conn->query($sql);
    
    // Check if there are any results
    if ($result->num_rows > 0) {
        // Fetch each row and store the data in the $students array
        while($row = $result->fetch_assoc()) {
            // Concatenate first name and last name to form full name
            $fullName = htmlspecialchars($row['firstname']) . ' ' . htmlspecialchars($row['lastname']);
            $students[] = [
                'id' => $row['id'],
                'full_name' => $fullName,
                'student_no' => $row['student_no'],
                'position' => htmlspecialchars($row['position']),
                'status' => htmlspecialchars($row['status']), // Use 'inactive' if NULL
                'sports_type' => htmlspecialchars($row['sports_type'])
            ];
        }
    } else {
        echo "No basketball students found.";
    }
    
    return $students;
}
?>

<div class="container-fluid p-0 m-0 profile-page" id="list" style="display: none;">
    <h2 class="mb-4">Basketball Students</h2>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Student No.</th>
                <th scope="col">Position</th>
                <th scope="col">Status</th>
                <th scope="col">Sports Type</th> <!-- Added Sports Type column -->
                <th scope="col">Profile</th> <!-- Added profile column -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch basketball student data
            $students = fetchBasketballStudentsData($conn);
            
            // Display each student data as a row in the table
            foreach ($students as $student) {
                echo '<tr>';
                echo '<td>' . $student['full_name'] . '</td>';
                echo '<td>' . htmlspecialchars($student['student_no']) . '</td>';
                echo '<td>' . $student['position'] . '</td>'; // Display position
                echo '<td>' . $student['status'] . '</td>';   // Display status (active or inactive)
                echo '<td>' . $student['sports_type'] . '</td>'; // Display sports type
                // Add a profile button for each student
                echo '<td><button class="btn btn-outline-secondary" onclick="showSection(event, \'s-profile\')">Profile</button></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Close the database connection
$conn->close();
?>
