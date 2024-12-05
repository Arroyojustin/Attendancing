<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== 'student') {
    header('Location: ../index.php'); // Redirect unauthorized access
    exit();
}


// Include database connection
include '../Admin/dbconn.php';

// Determine which page to load
$page = isset($_GET['page']) ? $_GET['page'] : 'schedule'; // Default to home if no page is specified
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student Management</title>
    
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/schedule.css?v=1.0">
    <link rel="stylesheet" href="../assets/css/program.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/circle.css">
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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('./components/s-sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Header Content -->
            <?php include('./components/s-header.php'); ?>

            <!-- Main Content -->
            <div id="content">

              <?php $page = isset($_GET['page']) ? $_GET['page'] : './pages/schedule.php'; ?>

                 <!-- Begin Page Content -->
                 <div id="page-content" style="width: 100%;">
                    <?php include "pages/schedule.php"; ?>
                    <?php include "pages/s-profile.php"; ?>
                    <?php include "pages/program.php"; ?>
                    
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
    <script src="https://kit.fontawesome.com/29c04b1733.js" crossorigin="anonymous"></script>
    <script src="../js/sidebar.js"></script>

    <!--START::CRUD AJAX FUNCTIONS-->
    <script src="Ajaxxx/update-student.js"></script>

</body>
</html>
