<?php
// Start session and include required files
session_start();
ob_start();
require_once('config/database.php');
require_once('config/security.php');

// Display flash messages
if (isset($_SESSION['flash_message'])) {
  echo '<script>alert("' . sanitizeInput($_SESSION['flash_message']) . '")</script>';
  unset($_SESSION['flash_message']);
}

// Handle login
if (isset($_POST["submit"])) {
  $email = sanitizeInput($_POST["email"] ?? '');
  $password = $_POST["password"] ?? '';
  
  // Validate input
  if (empty($email) || empty($password)) {
    $_SESSION['flash_message'] = "Email and password are required";
    header('location:login.php');
    exit;
  }
  
  if (!validateEmail($email)) {
    $_SESSION['flash_message'] = "Invalid email format";
    header('location:login.php');
    exit;
  }
  
  // Try Admin login
  $admin_query = "SELECT admin_id, admin_password FROM tbl_admin WHERE admin_email = ?";
  $admin_data = getRow($con, $admin_query, "s", array($email));
  
  if ($admin_data && verifyPassword($password, $admin_data['admin_password'])) {
    $_SESSION['id'] = $admin_data['admin_id'];
    $_SESSION['user_type'] = 'admin';
    header("location:admin/admin_participants.php");
    exit;
  }
  
  // Try User login
  $user_query = "SELECT user_id, user_password FROM tbl_user WHERE user_email = ?";
  $user_data = getRow($con, $user_query, "s", array($email));
  
  // Debug logging
  error_log("Login attempt for email: " . $email);
  error_log("User data found: " . ($user_data ? "YES" : "NO"));
  if ($user_data) {
    error_log("Password verification result: " . (verifyPassword($password, $user_data['user_password']) ? "SUCCESS" : "FAILED"));
  }
  
  if ($user_data && verifyPassword($password, $user_data['user_password'])) {
    $_SESSION['id'] = $user_data['user_id'];
    $_SESSION['user_type'] = 'user';
    header("location:user/user_donate.php");
    exit;
  }
  
  // Try Hospital login
  $hospital_query = "SELECT hospital_id, hospital_password FROM tbl_hospital WHERE hospital_email = ?";
  $hospital_data = getRow($con, $hospital_query, "s", array($email));
  
  if ($hospital_data && verifyPassword($password, $hospital_data['hospital_password'])) {
    $_SESSION['id'] = $hospital_data['hospital_id'];
    $_SESSION['user_type'] = 'hospital';
    header("location:hospital/hospital_donors.php");
    exit;
  }
  
  // Login failed
  $_SESSION['flash_message'] = "Invalid email or password";
  header('location:login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | DROPE OF HOPE</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="asset_dashboard/img/favicon.png" rel="icon">
  <link href="asset_dashboard/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="asset_dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="asset_dashboard/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="asset_dashboard/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="asset_dashboard/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="asset_dashboard/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="asset_dashboard/css/style.css" rel="stylesheet">

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="asset_dashboard/img/logo.png" alt="">
                  <span class="d-none d-lg-block">DROPE OF HOPE</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <input type="text" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="passoword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="register.php">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>



            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="asset_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="asset_dashboard/vendor/simple-datatables/simple-datatables.js"></script>

  <!-- Template Main JS File -->
  <script src="asset_dashboard/js/main.js"></script>

</body>

</html>