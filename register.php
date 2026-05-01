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
  $dob = sanitizeInput($_POST['dob'] ?? '');
  $bgroup = $_POST['bgroup'] ?? '';
  $address = sanitizeInput($_POST['address'] ?? '');
  $password = $_POST['password'] ?? '';
  
  // Validate inputs
  $errors = array();
  
  if (empty($name) || strlen($name) < 3) {
    $errors[] = "Name must be at least 3 characters";
  }
  
  if (empty($email) || !validateEmail($email)) {
    $errors[] = "Valid email is required";
  }
  
  if (empty($contact) || !validatePhone($contact)) {
    $errors[] = "Valid contact number required (10-12 digits)";
  }
  
  if (empty($dob)) {
    $errors[] = "Date of birth is required";
  }
  
  if (empty($bgroup) || !isValidBloodGroup($bgroup)) {
    $errors[] = "Valid blood group is required";
  }
  
  if (empty($address) || strlen($address) < 5) {
    $errors[] = "Address is required";
  }
  
  if (empty($password) || !validatePasswordStrength($password)) {
    $errors[] = "Password must be at least 6 characters";
  }
  
  // Handle file upload
  $photo_name = null;
  if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    $errors[] = "Photo is required";
  } else {
    // Validate file type
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    $file_type = $_FILES['photo']['type'];
    
    if (!in_array($file_type, $allowed_types)) {
      $errors[] = "Only JPEG, PNG, and GIF images are allowed";
    } else {
      // Generate unique filename
      $photo_name = time() . '_' . basename($_FILES['photo']['name']);
      $upload_dir = "asset_dashboard/file_uploads/";
      
      if (!move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo_name)) {
        $errors[] = "Error uploading photo. Please try again.";
        $photo_name = null;
      }
    }
  }
  
  // If there are errors, show them
  if (!empty($errors)) {
    $_SESSION['flash_message'] = implode("\n", $errors);
    header('location:register.php');
    exit;
  }
  
  // Check if email already exists
  $check_email = "SELECT user_id FROM tbl_user WHERE user_email = ?";
  $existing = getRow($con, $check_email, "s", array($email));
  if ($existing) {
    $_SESSION['flash_message'] = "Email already registered";
    header('location:register.php');
    exit;
  }
  
  // Hash password
  $hashed_password = hashPassword($password);
  
  // Insert user with prepared statement
  $insert_user = "INSERT INTO tbl_user(user_name, user_email, user_phone, user_bgroup, user_address, user_password, user_photo, user_dob) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  
  if (insertRecord($con, "tbl_user", 
      array("user_name", "user_email", "user_phone", "user_bgroup", "user_address", "user_password", "user_photo", "user_dob"),
      "ssssssss",
      array($name, $email, $contact, $bgroup, $address, $hashed_password, $photo_name, $dob))) {
    $_SESSION['flash_message'] = "Registration Successful! Now you can login.";
    header("location:login.php");
    exit;
  } else {
    // Delete uploaded photo if DB insert fails
    if ($photo_name) {
      unlink("asset_dashboard/file_uploads/" . $photo_name);
    }
    $_SESSION['flash_message'] = "Registration failed. Please try again.";
    header('location:register.php');
    exit;
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>User Registration | Drop of Hope</title>
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
                      <label for="yourUsername" class="form-label">DoB</label>
                      <div class="input-group has-validation">
                        <input type="date" name="dob" class="form-control" id="dob" onchange="validateDate()" required>
                      </div>
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
                      <label for="yourPassword" class="form-label">Blood Group</label>
                      <select name="bgroup" class="form-control" id="password" required>
                        <option>--choose option---</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                      </select>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Enter your Address</label>
                      <textarea type="text" name="address" class="form-control" id="address" required></textarea>
                      <div class="invalid-feedback">Please enter your address!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Photo</label>
                      <input type="file" name="photo" class="form-control" id="photo" required>
                      <div class="invalid-feedback">Please upload your photo!</div>
                    </div>

                    <div class="col-12">
                      <label for="Are you a donor or receiver?" class="form-label">Are you a donor or receiver</label></br>

                      <input type="radio" id="css" name="form-label" value="Donor">
                      <label for="css">Donor</label><br>
                      <input type="radio" id="javascript" name="form-label" value="Receiver">
                      <label for="javascript">Receiver</label>

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

  <script>
    function validateDate() {
      var inputDate = new Date(document.getElementById("dob").value);
      var currentDate = new Date();
      var eighteenYearsAgo = new Date();
      eighteenYearsAgo.setFullYear(currentDate.getFullYear() - 18);

      if (inputDate > eighteenYearsAgo) {
        alert("You must be at least 18 years old.");
        document.getElementById("dob").value = "";
      }
    }
  </script>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="asset_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="asset_dashboard/vendor/simple-datatables/simple-datatables.js"></script>

  <!-- Template Main JS File -->
  <script src="asset_dashboard/js/main.js"></script>

</body>

</html>