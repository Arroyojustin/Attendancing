<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ./index.php');
    exit();
}

// Include database connection
include 'dbconn.php';

$id = $_GET['id'];
if (!isset($id)) {
    header('Location: students.php');
    exit();
}

// Fetch student details
$student_query = "SELECT id, names, position FROM students WHERE id = ?";
$stmt = $conn->prepare($student_query);
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) {
    header('Location: students.php');
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
      margin: 0;
    }

    .navbar {
      z-index: 1000;
    }

    .main-container {
      display: flex;
      flex: 1;
    }

    .sidebar-container {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 200px;
      background-color: rgba(84, 186, 169, 1); /* Sidebar color */
    }

    .sidebar-container .sidebar-heading {
      padding: 1rem;
      font-size: 1.2rem;
      color: #fff;
      background-color: #138496;
      text-align: center;
    }

    .sidebar-container .list-group-item {
      padding: 1rem;
      font-size: 1rem;
      color: #fff;
      background-color: rgba(84, 186, 169, 1); /* Updated color */
      border: none;
    }

    .sidebar-container .list-group-item:hover {
      background-color: #138496;
    }

    .content-wrapper {
      margin-left: 200px;
      padding: 60px 20px;
      flex-grow: 1;
    }

    .form-container {
      max-width: 600px;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <!-- Top Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-teal fixed-top">
    <div class="container-fluid">
      <div class="d-flex align-items-center ms-auto">
        <i class="fas fa-bell text-white me-1"></i>
        <div class="dropdown">
          <a class="btn btn-sm text-white dropdown-toggle me-2" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle"></i> coordinator
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main container -->
  <div class="main-container">
    <!-- Sidebar Container -->
    <div class="sidebar-container">
      <div class="sidebar-heading">
        Dashboard
      </div>
      <div class="list-group list-group-flush">
        <a href="home.php" class="list-group-item list-group-item-action">
          <i class="fas fa-home me-2"></i>Home
        </a>
        <a href="reports.php" class="list-group-item list-group-item-action">
          <i class="fas fa-chart-bar me-2"></i>Reports
        </a>
        <a href="students.php" class="list-group-item list-group-item-action">
          <i class="fas fa-user-graduate me-2"></i>Students
        </a>
        <a href="coaches.php" class="list-group-item list-group-item-action">
          <i class="fas fa-user-friends me-2"></i>Coaches
        </a>
        <a href="tasks.php" class="list-group-item list-group-item-action">
          <i class="fas fa-tasks me-2"></i>Tasks
        </a>
      </div>
    </div>

    <!-- Page Content -->
    <div class="content-wrapper">
      <h2>Edit Student</h2>
      <div class="form-container">
        <form method="POST" action="save_changes.php">
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($student['names']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($student['position']); ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Save Changes
          </button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
