<?php
// Include database connection and functions file
include('./../Admin/dbconn.php');
include('./controller/function.php'); // Include the function file that contains getStudentData()

// Function to fetch student data for volleyball (similar to basketball data fetching)
function getVolleyballStudentsData($conn) {
    $sql = "SELECT u.firstname, u.lastname, s.position, s.status, s.user_id, s.attendance_status
            FROM users u
            JOIN students s ON u.id = s.user_id
            WHERE u.user_type = 'student' AND u.sports_type = 'volleyball'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        return $students;
    } else {
        return [];
    }
}

// Function to count volleyball students (no longer grouped by grade level)
function countVolleyballStudents($conn) {
    $sql = "SELECT COUNT(*) as count 
            FROM students s
            JOIN users u ON u.id = s.user_id
            WHERE u.sports_type = 'volleyball'";
    $result = $conn->query($sql);

    return $result->num_rows > 0 ? $result->fetch_assoc()['count'] : 0;
}

// Fetch volleyball student data
$students = getVolleyballStudentsData($conn);

// Fetch the total count of volleyball students
$totalStudents = countVolleyballStudents($conn);
?>

<div class="container-fluid p-0 m-0 profile-page" id="count" style="display: none;">
  <!-- Table to display total student count -->
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Total Students</th>
      </tr>
    </thead>
    <tbody id="studentCountTable">
      <tr>
        <td id="totalCount"><?php echo $totalStudents; ?></td>
      </tr>
    </tbody>
  </table>

  <!-- Table to display student details -->
  <form id="attendanceForm" method="post" action="controller/save-student-count.php">
    <table class="table table-bordered">
      <thead>
        <tr>
            <th>Full Name</th>
            <th>Position</th>
            <th>Status</th>
            <th>Attendance</th> <!-- New Attendance column -->
        </tr>
      </thead>
      <tbody id="studentDetailsTable">
        <?php
        // Display volleyball student full names dynamically with position, status, and attendance dropdown
        foreach ($students as $student) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($student['firstname']) . " " . htmlspecialchars($student['lastname']) . "</td>";
            echo "<td>" . htmlspecialchars($student['position']) . "</td>";
            echo "<td>" . htmlspecialchars($student['status']) . "</td>";
            echo "<td>";
            echo "<input type='hidden' name='student_ids[]' value='" . htmlspecialchars($student['user_id']) . "'>";
            echo "<select name='attendance_statuses[]' class='form-select form-select-sm'>";
            echo "<option value='present'" . ($student['attendance_status'] === 'present' ? " selected" : "") . ">Present</option>";
            echo "<option value='absent'" . ($student['attendance_status'] === 'absent' ? " selected" : "") . ">Absent</option>";
            echo "</select>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
      </tbody>
    </table>
    
    <!-- Save button at the bottom -->
    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-sm">Save</button>
    </div>
  </form>
</div>

<?php
// Close the database connection
$conn->close();
?>
