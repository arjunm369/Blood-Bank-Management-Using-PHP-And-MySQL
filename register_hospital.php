<?php
session_start();
ob_start();
require_once('config/database.php');
require_once('config/security.php');

// Display flash messages
if (isset($_SESSION['flash_message'])) {
  echo '<script>alert("' . sanitizeInput($_SESSION['flash_message']) . '")</script>';
  unset($_SESSION['flash_message']);
}

// Handle registration
if (isset($_POST['submit'])) {
  // Collect and sanitize inputs
  $name = sanitizeInput($_POST['name'] ?? '');
  $email = sanitizeInput($_POST['email'] ?? '');
  $contact = sanitizeInput($_POST['number'] ?? '');
  $address = sanitizeInput($_POST['address'] ?? '');
  $password = $_POST['password'] ?? '';
  
  // Validate inputs
  $errors = array();
  
  if (empty($name) || strlen($name) < 3) {
    $errors[] = "Hospital name must be at least 3 characters";
  }
  
  if (empty($email) || !validateEmail($email)) {
    $errors[] = "Valid email is required";
  }
  
  if (empty($contact) || !validatePhone($contact)) {
    $errors[] = "Valid contact number required (10-12 digits)";
  }
  
  if (empty($address) || strlen($address) < 5) {
    $errors[] = "Address is required";
  }
  
  if (empty($password) || !validatePasswordStrength($password)) {
    $errors[] = "Password must be at least 6 characters";
  }
  
  // If there are errors, show them
  if (!empty($errors)) {
    $_SESSION['flash_message'] = implode("\n", $errors);
    header('location:register_hospital.php');
    exit;
  }
  
  // Check if email already exists
  $check_email = "SELECT hospital_id FROM tbl_hospital WHERE hospital_email = ?";
  $existing = getRow($con, $check_email, "s", array($email));
  if ($existing) {
    $_SESSION['flash_message'] = "Email already registered";
    header('location:register_hospital.php');
    exit;
  }
  
  // Hash password
  $hashed_password = hashPassword($password);
  
  // Insert hospital with prepared statement
  if (insertRecord($con, "tbl_hospital", 
      array("hospital_name", "hospital_email", "hospital_phone", "hospital_address", "hospital_password"),
      "sssss",
      array($name, $email, $contact, $address, $hashed_password))) {
    $_SESSION['flash_message'] = "Registration Successful! Now you can login.";
    header("location:login.php");
    exit;
  } else {
    $_SESSION['flash_message'] = "Registration failed. Please try again.";
    header('location:register_hospital.php');
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hospital Registration | Drop of Hope</title>
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
                  <span class="d-none d-lg-block">HemoConnect</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Full Name</label>
                      <input type="text" name="name" class="form-control" id="name" required>
                      <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Contact Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="number" class="form-control" id="number" required>
                        <div class="invalid-feedback">Please enter your contact number</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="email" required>
                      <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="text" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Enter your Address</label>
                      <textarea type="text" name="address" class="form-control" id="address" required></textarea>
                      <div class="invalid-feedback">Please enter your address!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="login.php">Log in</a></p>
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