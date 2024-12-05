<?php
// Include the database connection file
include('./dbconn.php');

// Check if a surname search is made, else set it to an empty string
$surnameSearch = isset($_GET['surname']) ? $_GET['surname'] : '';

// Query to fetch students with their sports_type, status, and student_no
$sql = "
    SELECT 
        u.student_no, 
        CONCAT(u.firstname, ' ', u.lastname) AS full_name, 
        COALESCE(a.status, 'Absent') AS status, 
        u.sports_type
    FROM 
        users u
    LEFT JOIN 
        students s ON u.id = s.user_id
    LEFT JOIN 
        attendance a ON a.student_no = u.student_no AND a.attendance_date = CURDATE()
    WHERE 
        u.user_type = 'student' 
        AND CONCAT(u.firstname, ' ', u.lastname) LIKE ?
";

// Prepare and execute the query with surname search
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $surnameSearch . '%';
$stmt->bind_param('s', $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-fluid p-0 m-0" id="attendance" style="display: none;">
    <div class="row">
        <!-- Left side content (Attendance Form and Table) -->
        <div class="col-md-8">
            <div class="row">
                <!-- Attendance Form -->
                <div class="col-12">
                    <div class="card p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Attendance</h5>
                            <button id="sortButton" class="btn btn-outline-secondary" onclick="toggleSort()">
                                <i class="fas fa-sort"></i> 
                            </button>
                        </div>
                        <form class="row mt-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control mb-2" id="surname" placeholder="Surname" oninput="searchAttendance()">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control mb-2" id="studentNo" placeholder="Student No.">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="col-12">
                    <div class="card p-3 shadow-sm mt-3">
                        <table id="attendanceTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student No.</th>
                                    <th>Full Name</th>
                                    <th>Sports Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr class="attendance-row" data-sports-type="<?php echo $row['sports_type']; ?>" data-full-name="<?php echo strtolower($row['full_name']); ?>" data-student-no="<?php echo $row['student_no']; ?>">
                                        <td><?php echo $row['student_no']; ?></td>
                                        <td><?php echo $row['full_name']; ?></td>
                                        <td><?php echo $row['sports_type']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="col-12 text-end mt-3">
                            <button class="btn btn-outline-success" id="recordBtn" onclick="recordAttendance()">Record Attendance</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side content (Calendar and Summary) -->
        <div class="col-md-4">
            <div class="calendar">
                <div class="calendar-header">
                    <button id="prev-month">&lt;</button>
                    <h3 id="current-month">November 2024</h3>
                    <button id="next-month">&gt;</button>
                </div>
                <div class="calendar-grid">
                    <!-- Days will be dynamically injected here -->
                </div>
            </div>

            <!-- Present Students Card -->
            <div class="card p-2 mb-2 shadow-sm present-card" style="background-color: #4FD39A;">
                <div class="d-flex align-items-center">
                    <div class="status-box text-dark me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ffffff; border-radius: 5px;">
                        <i class="bx bx-user-check" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="text-dark mb-0" id="presentCount">0 Present Today</h6>
                </div>
            </div>

            <!-- Absent Students Card -->
            <div class="card p-2 mb-2 shadow-sm absent-card" style="background-color: #DE3434;">
                <div class="d-flex align-items-center">
                    <div class="status-box text-dark me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ffffff; border-radius: 5px;">
                        <i class="bx bx-user-x" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="text-dark mb-0" id="absentCount">0 Absent Today</h6>
                </div>
            </div>

            <!-- Total Students Card -->
            <div class="card p-2 shadow-sm total-students-card" style="background-color: #FAFF65;">
                <div class="d-flex align-items-center">
                    <div class="status-box text-dark me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ffffff; border-radius: 5px;">
                        <i class="bx bx-user" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="text-dark mb-0" id="totalStudents">0 Total Students</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let showBasketball = true;  // Basketball students are displayed by default

    document.addEventListener('DOMContentLoaded', () => {
        // Filter rows to show only basketball students initially
        filterRows('basketball');
        updateCounts();
    });

    // Function to toggle between basketball and volleyball students
    function toggleSort() {
        showBasketball = !showBasketball;
        const rows = document.querySelectorAll('#attendanceTable .attendance-row');
        rows.forEach(row => {
            const sportsType = row.getAttribute('data-sports-type');
            if ((showBasketball && sportsType === 'basketball') || (!showBasketball && sportsType === 'volleyball')) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateCounts(); // Update counts after toggling sports type
    }

    // Function to filter rows based on sports type
    function filterRows(sportsType) {
        const rows = document.querySelectorAll('.attendance-row');
        rows.forEach(row => {
            row.style.display = row.getAttribute('data-sports-type') === sportsType ? '' : 'none';
        });
    }

    // Update the present, absent, and total student count based on current visibility
    function updateCounts() {
        const rows = document.querySelectorAll('.attendance-row');
        let presentCount = 0;
        let absentCount = 0;
        let totalCount = 0;

        rows.forEach(row => {
            const status = row.querySelector('td:nth-child(4)').textContent.trim().toLowerCase();
            const isVisible = row.style.display !== 'none';

            if (isVisible) {
                totalCount++;
                if (status === 'present') presentCount++;
                if (status === 'absent') absentCount++;
            }
        });

        document.getElementById('totalStudents').textContent = `${totalCount} Total Students`;
        document.getElementById('presentCount').textContent = `${presentCount} Present Today`;
        document.getElementById('absentCount').textContent = `${absentCount} Absent Today`;
    }

    // Search function for attendance table
    function searchAttendance() {
        const input = document.getElementById('surname').value.toLowerCase();
        const rows = document.querySelectorAll('.attendance-row');
        
        rows.forEach(row => {
            const fullName = row.getAttribute('data-full-name');
            if (fullName.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Update counts after search
        updateCounts();
    }

    // Function to handle "Record Attendance" button click
    function recordAttendance() {
        // Get the student number from the selected row
        const selectedRow = document.querySelector('.attendance-row.selected');
        if (selectedRow) {
            const studentNo = selectedRow.getAttribute('data-student-no');

            // Store the student number in session storage (or redirect as needed)
            sessionStorage.setItem('studentNo', studentNo);

            // Optionally redirect to reports.php
            window.location.href = 'pages/reports.php';
        } else {
            alert('Please select a student first.');
        }
    }

    // Add event listener to highlight row on click
    document.querySelectorAll('.attendance-row').forEach(row => {
        row.addEventListener('click', function() {
            document.querySelectorAll('.attendance-row').forEach(r => r.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
</script>