<?php
// Include the database connection
include('../Admin/dbconn.php');

// Fetch all basketball students' information along with their progress data
$sql = "SELECT u.firstname, u.lastname, u.sports_type, s.position, u.id, s.acads_progress, s.training_progress
        FROM users u
        LEFT JOIN students s ON u.id = s.user_id
        WHERE u.user_type = 'student' AND u.sports_type = 'basketball'";

// Prepare the query and execute
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($firstname, $lastname, $sports_type, $position, $user_id, $acads_progress, $training_progress);

// Store all students' data in an array
$students = [];
while ($stmt->fetch()) {
    $students[] = [
        'user_id' => $user_id,
        'fullname' => $firstname . ' ' . $lastname,
        'position' => $position,
        'sports_type' => $sports_type,
        'acads_progress' => $acads_progress,
        'training_progress' => $training_progress
    ];
}

$stmt->close();

// Close the database connection
$conn->close();
?>

<!-- List of students and their profiles -->
<div class="container-fluid p-0 m-0 profile-page" id="s-profile" style="display: block;">
    <?php foreach ($students as $student): ?>
        <!-- Profile card for each student -->
        <div class="card shadow mb-3">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Profile Details: <?php echo htmlspecialchars($student['fullname']); ?></h3>
            </div>
            <div class="card-body">
                <!-- Profile Info -->
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="text-secondary">Name:</h5>
                        <p class="fw-bold"><?php echo htmlspecialchars($student['fullname']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-secondary">Position:</h5>
                        <p class="fw-bold"><?php echo htmlspecialchars($student['position']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-secondary">Sports Type:</h5>
                        <p class="fw-bold"><?php echo htmlspecialchars($student['sports_type']); ?></p>
                    </div>
                </div>

                <!-- Progress Bar Section -->
                <div class="mt-4">
                    <!-- Acads Progress -->
                    <h5 class="text-secondary">Acads Progress:</h5>
                    <div class="d-flex align-items-center">
                        <input type="range" class="form-range me-3" min="0" max="100" step="1" value="<?php echo $student['acads_progress']; ?>" 
                               id="acads-slider-<?php echo $student['user_id']; ?>"
                               oninput="updateProgress(this, 'acads-progress-<?php echo $student['user_id']; ?>', 'acads-value-<?php echo $student['user_id']; ?>')">
                        <span id="acads-value-<?php echo $student['user_id']; ?>"><?php echo $student['acads_progress']; ?>%</span>
                    </div>
                    <div class="progress mt-2">
                        <div id="acads-progress-<?php echo $student['user_id']; ?>" 
                             class="progress-bar bg-info" 
                             role="progressbar" 
                             style="width: <?php echo $student['acads_progress']; ?>%;" 
                             aria-valuenow="<?php echo $student['acads_progress']; ?>" 
                             aria-valuemin="0" 
                             aria-valuemax="100"></div>
                    </div>

                    <!-- Training Progress -->
                    <h5 class="text-secondary mt-4">Training Progress:</h5>
                    <div class="d-flex align-items-center">
                        <input type="range" class="form-range me-3" min="0" max="100" step="1" value="<?php echo $student['training_progress']; ?>" 
                               id="training-slider-<?php echo $student['user_id']; ?>"
                               oninput="updateProgress(this, 'training-progress-<?php echo $student['user_id']; ?>', 'training-value-<?php echo $student['user_id']; ?>')">
                        <span id="training-value-<?php echo $student['user_id']; ?>"><?php echo $student['training_progress']; ?>%</span>
                    </div>
                    <div class="progress mt-2">
                        <div id="training-progress-<?php echo $student['user_id']; ?>" 
                             class="progress-bar bg-success" 
                             role="progressbar" 
                             style="width: <?php echo $student['training_progress']; ?>%;" 
                             aria-valuenow="<?php echo $student['training_progress']; ?>" 
                             aria-valuemin="0" 
                             aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-primary" onclick="saveProgress(<?php echo $student['user_id']; ?>)">Save Progress</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- JavaScript for updating progress dynamically and saving the progress -->
<script>
function updateProgress(slider, progressBarId, valueId) {
    const progressValue = slider.value;
    document.getElementById(progressBarId).style.width = progressValue + '%';
    document.getElementById(valueId).innerText = progressValue + '%';
}

function saveProgress(userId) {
    // Get the progress values from the sliders
    const acadsProgress = document.getElementById(`acads-slider-${userId}`).value;
    const trainingProgress = document.getElementById(`training-slider-${userId}`).value;

    // Send AJAX request to update the progress in the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'controller/update-progress.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(`user_id=${userId}&acads_progress=${acadsProgress}&training_progress=${trainingProgress}`);

    xhr.onload = function () {
        if (xhr.status == 200) {
            alert('Progress updated successfully!');
        } else {
            alert('Error updating progress: ' + xhr.responseText);  // Display the error message from the server
        }
    };

    // For debugging: log the response from the server
    xhr.onerror = function() {
        console.log("Request failed with status: " + xhr.status);
    };
}
</script>
