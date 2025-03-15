<?php
$con = mysqli_connect("localhost", "root", "", "db_hemoconnect");

if (isset($_SESSION['flash_message'])) {
  echo '<script>alert("' . $_SESSION['flash_message'] . '")</script>';
  unset($_SESSION['flash_message']);
}

?>



<?php
if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $passwd = $_POST["password"];
  $admin = "select * from tbl_admin where admin_email='$email' and admin_password='$passwd'";
  $user = "select * from tbl_user where user_email='$email' and user_password='$passwd'";
  $hospital = "select * from tbl_hospital where hospital_email='$email' and hospital_password='$passwd'";

  $row1 = mysqli_query($con, $admin);
  $row2 = mysqli_query($con, $user);
  $row3 = mysqli_query($con, $hospital);

  $data1 = mysqli_fetch_array($row1);
  $data2 = mysqli_fetch_array($row2);
  $data3 = mysqli_fetch_array($row3);

  if ($data1) {
    $sid = $data1['admin_id'];
    session_start();
    $_SESSION['id'] = $sid;
    header("location:admin/admin_participants.php");
  } elseif ($data2) {
    $sid = $data2['user_id'];
    session_start();
    $_SESSION['id'] = $sid;
    header("location:user/user_donate.php");
  } elseif ($data3) {
    $sid = $data3['hospital_id'];
    session_start();
    $_SESSION['id'] = $sid;
    header("location:hospital/hospital_donors.php");
  } else {
    $_SESSION['flash_message'] = "invalid login details";
    header('location:login.php');
  }
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
  <link href="asset_dashboard/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="asset_dashboard/vendor/quill/quill.bubble.css" rel="stylesheet">
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
                <a href="index.html" class="logo d-flex align-items-center w-auto">
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

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="">ABV</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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