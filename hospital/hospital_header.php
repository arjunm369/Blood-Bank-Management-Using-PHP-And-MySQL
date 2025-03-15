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

$selq10 = "select *from tbl_admin where admin_id='$sid'";
$row10 = mysqli_query($con, $selq10);
$data10 = mysqli_fetch_array($row10);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>HemoConnect- Hospital</title>
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

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="../asset_dashboard/img/logo.png" alt="">
        <span class="d-none d-lg-block">Hemo Connect</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../asset_dashboard/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Hemo Connect</h6>
              <span>Admin</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
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

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="hospital_donors.php">
          <i class="bi bi-person"></i>
          <span>Participants</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="hospital_faq.php">
          <i class="bi bi-envelope"></i>
          <span>FAQ</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="hospital_ambulance.php">
          <i class="bi bi-envelope"></i>
          <span>Ambulance</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../logout.php">
          <i class="bi bi-envelope"></i>
          <span>Log Out</span>
        </a>
      </li>

    </ul>

  </aside><!-- End Sidebar-->
