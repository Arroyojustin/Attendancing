<?php
// Include the database connection file
include('./dbconn.php');

// Retrieve the student number from session storage (via URL or other methods)
$studentNo = isset($_SESSION['studentNo']) ? $_SESSION['studentNo'] : null;

// Query to fetch attendance records for the selected student number
if ($studentNo) {
    $sql = "SELECT * FROM attendance WHERE student_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $studentNo);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<div class="container-fluid p-0 m-0 profile-page" id="reports" style="display: none;">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Student ID</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['student_no']; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['attendance_date'])); ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No attendance records found for this student.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
