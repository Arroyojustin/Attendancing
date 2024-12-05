<?php
session_start();

// Check if the user is logged in and is a coordinator
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'coordinator') {
    // Redirect to login page if not logged in or not a coordinator
    header('Location: ../index.php'); 
    exit(); 
}

// Include database connection
include './dbconn.php';

// Get coordinator details from the database
$coordinator_email = $_SESSION['email']; // Using session email to fetch user details
$query = "SELECT id, firstname, lastname, email, phone_no, profile_photo FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $coordinator_email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the coordinator exists
if ($result->num_rows > 0) {
    $coordinator = $result->fetch_assoc();
    // Assign the coordinator details to variables
    $first_name = $coordinator['firstname'];
    $last_name = $coordinator['lastname'];
    $admin_email = $coordinator['email'];
    $phone_number = $coordinator['phone_no'];
    $profile_photo = $coordinator['profile_photo'];

    // Store the user ID in the session
    $_SESSION['id'] = $coordinator['id'];  // <-- This is the line you're looking for
} else {
    // If coordinator doesn't exist, redirect to the login page
    header('Location: ../index.php');
    exit();
}

// Determine which page to load
$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default to home if no page is specified
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>coordinator</title>
    
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/attendance.css">
    <link rel="stylesheet" href="../assets/css/v2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        #wrapper {
            display: flex;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        #content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #f8f8f8;
        }

        #content {
            padding: 1rem;
            flex-grow: 1;
            background-color: #f8f8f8;
        }

        #page-content {
            flex-grow: 1;
            padding: 10px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Loading Screen -->
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar-->
        <?php include('components/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Header Content -->
            <?php include('./components/header.php'); ?>

            <!-- Main Content -->
            <div id="content">
                 <!-- Begin Page Content -->
                 <div id="page-content" style="width: 100%;">
                    <?php include "pages/home.php"; ?>
                    <?php include "pages/reports.php"; ?>
                    <?php include "pages/attendance.php"; ?>
                    <?php include "pages/tasks.php"; ?>
                    <?php include "pages/students.php"; ?>
                    <?php include "pages/profile.php"; ?>
                    <?php include "pages/add_student.php"; ?>
                </div>

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/29c04b1733.js" crossorigin="anonymous"></script>
    <script src="../js/sidebar.js"></script>
    <script src="../js/calendar.js"></script>

    <!--START::CRUD AJAX FUNCTIONS-->
    <script src="./Ajax/drag-drop.js"></script>
    <script src="./Ajax/button-funtion.js"></script>
    <script src="./Ajax/create-upload.js"></script>
    <script src="./Ajax/attend-control.js"></script>
    <script src="./Ajax/search-control.js"></script>
    <script src="Ajax/update-profile.js"></script>
    <script src="Ajax/update-password.js"></script>
    <script src="./Ajax/control-stud.js"></script>
    <script src="./Ajax/add-manual.js"></script>
    

    

</body>
</html>
