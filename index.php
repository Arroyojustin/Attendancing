<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
</head>
<body class="login-body">
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-container p-4 position-relative">
            <!-- Header with logos and text inside login form -->
            <div class="header-container">
                <img src="./Admin/uploads/ASAPP.png" alt="ASSAP Logo" class="logo-left">
                <div class="header-text">
                    <h1 class="asiatech-heading">ASIATECH</h1>
                    <span class="subtext">Student Athlete Progress Portal</span>
                </div>
                <img src="./Admin/uploads/RAWR.png" alt="RAWR Logo" class="logo-right">
            </div>

            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="position-absolute top-50 start-50 translate-middle d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- Login Form -->
            <form id="loginForm" action="login_process.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>


    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                // Show the loading spinner
                $('#loadingSpinner').removeClass('d-none');

                $.ajax({
                    type: 'POST',
                    url: './Admin/login_process.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Parse JSON response
                        let jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;

                        // Hide the loading spinner
                        $('#loadingSpinner').addClass('d-none');

                        if (jsonResponse.status === 'success') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Logged in successfully',
                                timer: 2000,
                                background: '#ab9f6ca',
                                iconColor: '#a2e7d32',
                                color: '#a155724',
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = jsonResponse.redirect;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: jsonResponse.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loadingSpinner').addClass('d-none');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                        });
                    }
                });
            });
        });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
