<?php
$con = mysqli_connect("localhost", "root", "", "db_hemoconnect");


if (isset($_SESSION['flash_message'])) {
  echo '<script>alert("' . $_SESSION['flash_message'] . '")</script>';
  unset($_SESSION['flash_message']);
}

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $contact = $_POST['number'];
  $dob = $_POST['dob'];
  $bgroup = $_POST['bgroup'];
  $address = $_POST['address'];
  $password = $_POST['password'];
  $photo = $_FILES['photo']['name'];
  $temp = $_FILES['photo']['tmp_name'];

  if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['flash_message'] = 'File upload failed with error code: ' . $_FILES['photo']['error'];
  } else {
    if (move_uploaded_file($temp, "asset_dashboard/file_uploads/" . $photo)) {
      $insq = "INSERT INTO tbl_user(user_name, user_email, user_phone, user_bgroup, user_address, user_password, user_photo, user_dob) VALUES ('$name','$email','$contact','$bgroup','$address','$password','$photo','$dob')";
      $upload = mysqli_query($con, $insq);

      if ($upload == true) {
        $_SESSION['flash_message'] = "Registration Successful. Now You Can Login";
        header("location:login.php");
      } else {
        $_SESSION['flash_message'] = "Error uploading file. Please try again.";
      }
    } else {
      $_SESSION['flash_message'] = "Error moving the uploaded file.";
    }
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
  <link href="asset_dashboard/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="asset_dashboard/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="asset_dashboard/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="asset_dashboard/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="asset_dashboard/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
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
                        <option value="B+">B-</option>
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

                    <script>
                      function validateDate() {
                        var inputDate = new Date(document.getElementById("dob").value);
                        var currentDate = new Date();
                        var eighteenYearsAgo = new Date();
                        eighteenYearsAgo.setFullYear(currentDate.getFullYear() - 18);

                        if (inputDate > eighteenYearsAgo) {
                          alert("You must be at least 18 years old.");
                          document.getElementById("dob").value = ""; // Clear the input
                        }
                      }
                    </script>



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
        document.getElementById("dob").value = ""; // Clear the input
      }
    }
  </script>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="asset_dashboard/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="asset_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="asset_dashboard/vendor/chart.js/chart.umd.js"></script>
  <script src="asset_dashboard/vendor/echarts/echarts.min.js"></script>
  <script src="asset_dashboard/vendor/quill/quill.min.js"></script>
  <script src="asset_dashboard/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="asset_dashboard/vendor/tinymce/tinymce.min.js"></script>
  <script src="asset_dashboard/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="asset_dashboard/js/main.js"></script>

</body>

</html>