<?php
session_start();

// Check if the user is logged in and is a coach
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'coach') {
    header('Location: ../index.php'); // Redirect to homepage if not logged in as a coach
    exit();
}

// Check if the sports_type is volleyball
if (isset($_SESSION['sports_type']) && $_SESSION['sports_type'] !== 'basketball') {
    header('Location: ../index.php'); // Redirect to homepage if sports_type is not volleyball
    exit();
}

// Include database connection
include '../Admin/dbconn.php';

// Fetch the coach's sports_type from the database (if needed)
$stmt = $conn->prepare("SELECT sports_type FROM users WHERE email = ?");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$stmt->bind_result($sportsType);
$stmt->fetch();
$stmt->close();

// Redirect if the coach is not assigned to volleyball
if ($sportsType !== 'basketball') {
    header('Location: ../index.php'); // Redirect to homepage if not assigned to volleyball
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>coach</title>
    
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
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

        /* Loading screen style */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>

<body id="page-top">


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar-->
        <?php include('./components/co-sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Header Content -->
            <?php include('./components/co-header.php'); ?>

            <!-- Main Content -->
            <div id="content">
                 <!-- Begin Page Content -->
                 <div id="page-content" style="width: 100%;">
                    <?php include "pages/practice.php"; ?>
                    <?php include "pages/student-list.php"; ?>
                    <?php include "pages/student-count.php"; ?>
                    <?php include "pages/coach-profile.php"; ?>
                    <?php include "pages/profile-info.php"; ?>
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

    <!--START::CRUD AJAX FUNCTIONS-->
    <script src="ajax/update-coach.js"></script>
    <script src="ajax/password-update.js"></script>


</body>
</html>
