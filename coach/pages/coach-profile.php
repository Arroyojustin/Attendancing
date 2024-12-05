<?php
// Include database connection
include('../Admin/dbconn.php');

// Ensure user is logged in and is a coach
if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== 'coach') {
    echo "You are not authorized to view this page.";
    exit();
}

// Fetch the coach data from the database based on the logged-in user's session
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$coach = $result->fetch_assoc();

// If no user is found, handle the error
if (!$coach) {
    echo "No user found!";
    exit();
}

$stmt->close();
$conn->close();
?>
<div class="container-fluid px-3 py-4" id="coach-profile">
    <div class="row g-3">
        <!-- Left Section (Profile Picture and Initials) -->
        <div class="col-lg-4 col-md-5 bg-light d-flex flex-column align-items-center py-5 text-center border-end">
            <div class="circle-container bg-primary text-white mb-3 d-flex align-items-center justify-content-center"
                 style="width: 120px; height: 120px; border-radius: 50%; font-size: 36px; font-weight: bold;">
                <span class="initials"><?php echo isset($coach['firstname'][0], $coach['lastname'][0]) ? $coach['firstname'][0] . $coach['lastname'][0] : ''; ?></span>
            </div>
            <h5 class="mb-1"><?php echo isset($coach['email']) ? $coach['email'] : ''; ?></h5>
            <ul class="list-unstyled mt-3">
                <li><a href="#" class="btn btn-link text-decoration-none" id="changePasswordBtn">Change Password</a></li>
                <li><a href="#" class="btn btn-link text-danger text-decoration-none" id="deleteAccountBtn">Delete Account</a></li>
            </ul>
        </div>

        <!-- Right Section (Personal Info Form) -->
        <div class="col-lg-8 col-md-7 py-4">
            <h4 class="text-secondary">Personal Information</h4>
            <form id="profileForm" method="POST">
                <input type="hidden" name="id" value="<?php echo isset($coach['id']) ? $coach['id'] : ''; ?>">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="<?php echo isset($coach['firstname']) ? $coach['firstname'] : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="<?php echo isset($coach['lastname']) ? $coach['lastname'] : ''; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo isset($coach['email']) ? $coach['email'] : ''; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                        value="<?php echo isset($coach['phone_no']) ? $coach['phone_no'] : ''; ?>" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 gap-3">
                    <button type="submit" class="btn btn-outline-success" id="saveChangesBtn">Save Changes</button>
                    <a href="./overview.php" class="btn btn-outline-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

 <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
