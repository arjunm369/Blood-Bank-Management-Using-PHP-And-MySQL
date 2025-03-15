<?php
$con = mysqli_connect("localhost", "root", "", "db_hemoconnect");
session_start();
ob_start();

$sid = $_SESSION['id'];

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


if (!isset($_SESSION['id'])) {
  header("Location: ../index.php");
  exit();
}

if (isset($_SESSION['flash_message'])) {
  echo '<script>alert("' . $_SESSION['flash_message'] . '")</script>';
  unset($_SESSION['flash_message']);
}

$selq10 = "select *from tbl_user where user_id='$sid'";
$row10 = mysqli_query($con, $selq10);
$data10 = mysqli_fetch_array($row10);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>DROPE OF HOPE- User |<?php echo $sid; ?>|</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../asset_dashboard/img/favicon.png" rel="icon">
  <link href="../asset_dashboard/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../asset_dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../asset_dashboard/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../asset_dashboard/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../asset_dashboard/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../asset_dashboard/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../asset_dashboard/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../asset_dashboard/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../asset_dashboard/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: EDPP
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="../asset_dashboard/img/logo.png" alt="">
        <span class="d-none d-lg-block">HemoConnect</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../asset_dashboard/file_uploads/<?php echo $data10['user_photo'];?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">User</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>User</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <?php
      $req = "select *from tbl_request a inner join tbl_donation b on a.reciever_id=b.donation_id where b.user_id='$sid' and request_status='Added'";
      $req_row = mysqli_query($con, $req);
      $req_data=mysqli_fetch_array($req_row);
      if ($req_data) {
      ?>

        <li class="nav-item">
          <a class="nav-link collapsed" href="user_requests.php">
            <i class="bi bi-person"></i>
            <span>View Requests</span>
          </a>
        </li>

      <?php
      }
      ?>

      <li class="nav-item">
        <a class="nav-link collapsed" href="user_donors.php">
          <i class="bi bi-person"></i>
          <span>Search Donors</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="user_history.php">
          <i class="bi bi-question-circle"></i>
          <span>History</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="user_ambulance.php">
          <i class="bi bi-envelope"></i>
          <span>Ambulance</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="user_faq.php">
          <i class="bi bi-dash-circle"></i>
          <span>FaQ</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="user_donate.php">
          <i class="bi bi-dash-circle"></i>
          <span>Become a Donor</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="user_feedback.php">
          <i class="bi bi-dash-circle"></i>
          <span>Feedback</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../logout.php">
          <i class="bi bi-dash-circle"></i>
          <span>LogOut</span>
        </a>
      </li><!-- End Error 404 Page Nav -->



    </ul>

  </aside><!-- End Sidebar-->