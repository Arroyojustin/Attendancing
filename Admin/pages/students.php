<?php
// Include the database connection
include('./dbconn.php');

// Query to retrieve students from the `students` table, and if not present, from the `users` table
$sql = "
    SELECT s.id, 
           COALESCE(s.name, CONCAT(u.firstname, ' ', u.lastname)) AS full_name, 
           COALESCE(s.position, 'N/A') AS position, 
           COALESCE(s.status, 'inactive') AS status, 
           u.sports_type
    FROM users u
    LEFT JOIN students s ON u.id = s.user_id
    WHERE u.user_type = 'student'";

$result = $conn->query($sql);
?>

<div class="container-fluid p-0 m-0" id="student" style="display: none;">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="searchInput" class="form-control" placeholder="Search students by name..." onkeyup="searchStudents()">
            </div>
        </div>

        <div class="col-md-6 text-end d-flex justify-content-end align-items-center">
            <button class="btn btn-outline-secondary" onclick="showSection(event, 'addstud')">Students Information</button>
        </div>
    </div>

    <!-- Student Table -->
    <table class="table table-bordered" id="studentTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Status</th>
                <th>Sports Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results
            if ($result->num_rows > 0) {
                // Output the data for each student
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='student-row' data-id='" . $row['id'] . "'>
                            <td>" . htmlspecialchars($row['full_name']) . "</td>
                            <td>" . htmlspecialchars($row['position']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>" . htmlspecialchars($row['sports_type']) . "</td>
                            <td>
                                <button class='btn btn-warning btn-sm' 
                                        data-id='" . $row['id'] . "' 
                                        data-position='" . htmlspecialchars($row['position']) . "' 
                                        data-status='" . htmlspecialchars($row['status']) . "' 
                                        data-bs-toggle='modal' 
                                        data-bs-target='#editStudentModal'
                                        onclick='populateEditModal(this)'>Edit</button>
                                <button class='btn btn-danger btn-sm'>Delete</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No students found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Close the database connection
$conn->close();
?>

<!-- Modal for Editing Student Information -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm">
                    <input type="hidden" id="studentId" name="studentId">
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
<script>
    // Function to search students by name
    function searchStudents() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('.student-row');

        rows.forEach(row => {
            const name = row.cells[0].textContent.toLowerCase();
            if (name.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Populate modal with student data when Edit button is clicked
    function populateEditModal(button) {
        const studentId = button.getAttribute('data-id');
        const position = button.getAttribute('data-position');
        const status = button.getAttribute('data-status');

        // Set the values in the modal form
        document.getElementById('studentId').value = studentId;
        document.getElementById('position').value = position;
        document.getElementById('status').value = status;
    }

    // Handle form submission with AJAX
    document.getElementById('editStudentForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const studentId = document.getElementById('studentId').value;
        const position = document.getElementById('position').value;
        const status = document.getElementById('status').value;

        const formData = new FormData();
        formData.append('studentId', studentId);
        formData.append('position', position);
        formData.append('status', status);

        // Send the data to the backend using AJAX
        fetch('controller/update-student.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // If successful, update the table row
                const row = document.querySelector(`.student-row[data-id='${studentId}']`);
                row.cells[1].textContent = position;  // Update the position
                row.cells[2].textContent = status;    // Update the status

                // Optionally, change the background color to show the update
                row.cells[2].classList.add('table-warning'); // Add highlight to status cell

                // Close the modal
                const modal = new bootstrap.Modal(document.getElementById('editStudentModal'));
                modal.hide();
            } else {
                alert('Error updating student information.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

