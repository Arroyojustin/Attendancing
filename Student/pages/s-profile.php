<?php
// Include database connection
include('./../Admin/dbconn.php');

// Ensure user is logged in and is a student
if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== 'student') {
    echo "You are not authorized to view this page.";
    exit();
}

// Fetch the student data from the database based on the logged-in user's session
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If no user is found, handle the error
if (!$user) {
    echo "No user found!";
    exit();
}

$stmt->close();
$conn->close();
?>

<div class="container-fluid p-0 m-0" id="profile" style="display: none;">
    <div class="row">
        <!-- Profile Picture Section -->
        <div class="col-md-3 text-center">
            <div class="circle-wrapper mb-3 position-relative">
                <input type="file" id="profileImage" class="d-none" accept="image/*" onchange="previewImage(event)">
                <div class="circle position-relative">
                    <img id="profilePreview" src="<?php echo $user['profile_photo'] ?: 'default-profile.jpg'; ?>" 
                         alt="" class="rounded-circle" width="180" height="180">
                    <span class="position-absolute bottom-0 end-0 p-1 bg-dark rounded-circle text-white" 
                          style="font-size: 16px;">
                        <i class="bi bi-pencil"></i>
                    </span>
                </div>
                <i class="bx bxs-plus-circle position-absolute plus-icon"
                   style="font-size: 34px; color: #28a745; top: 85%; right: 21%; cursor: pointer;">
                </i>
            </div>
            <h5 class="mb-1"><?php echo isset($coach['email']) ? $coach['email'] : ''; ?></h5>
        </div>

        <div class="col-md-6 col-lg-6">
            <!-- Removed border and shadow styles from this div -->
            <div class="px-4 py-4">
                <h5 class="text-gray-800 fw-bold border-bottom border-dark pb-2 mb-3">Update Student</h5>
                <form id="updateStudentForm" method="POST" enctype="multipart/form-data">
                    <!-- Hidden ID field -->
                    <input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ''; ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="lastName" name="lastName" value="<?php echo isset($user['lastname']) ? $user['lastname'] : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="firstName" name="firstName" value="<?php echo isset($user['firstname']) ? $user['firstname'] : ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="middleInitial" class="form-label">Middle Initial</label>
                            <input type="text" class="form-control form-control-sm" id="middleInitial" name="middleInitial" value="<?php echo isset($user['middle_initial']) ? $user['middle_initial'] : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="studentNumber" class="form-label">Student No.</label>
                            <input type="text" class="form-control form-control-sm" id="studentNumber" name="studentNumber" value="<?php echo isset($user['student_no']) ? $user['student_no'] : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control form-control-sm" id="weight" name="weight" value="<?php echo isset($user['weight']) ? $user['weight'] : ''; ?>" step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label for="height" class="form-label">Height (cm)</label>
                            <input type="number" class="form-control form-control-sm" id="height" name="height" value="<?php echo isset($user['height']) ? $user['height'] : ''; ?>" step="0.01">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="bmi" class="form-label">BMI</label>
                            <input type="text" class="form-control form-control-sm" id="bmi" name="bmi" value="<?php echo isset($user['bmi']) ? $user['bmi'] : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="bloodType" class="form-label">Blood Type</label>
                            <input type="text" class="form-control form-control-sm" id="bloodType" name="bloodType" value="<?php echo isset($user['bloodtype']) ? $user['bloodtype'] : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select form-select-sm" id="gender" name="gender">
                                <option value="male" <?php echo (isset($user['gender']) && $user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo (isset($user['gender']) && $user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="emergencyContact" class="form-label">Contact No.</label>
                            <input type="text" class="form-control form-control-sm" id="emergencyContact" name="emergencyContact" value="<?php echo isset($user['phone_no']) ? $user['phone_no'] : ''; ?>">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary me-2" onclick="showSection(event, 'schedule')">Back</button>
                        <button type="submit" class="btn btn-outline-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
