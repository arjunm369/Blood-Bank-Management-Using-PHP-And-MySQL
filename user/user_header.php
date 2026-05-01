<?php
require_once('../config/database.php');
require_once('../config/security.php');
ob_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: ../index.php");
  exit();
}

if (isset($_SESSION['flash_message'])) {
  echo '<script>alert("' . sanitizeInput($_SESSION['flash_message']) . '")</script>';
  unset($_SESSION['flash_message']);
}

$sid = $_SESSION['id'];
$data10 = getRow($con, "SELECT * FROM tbl_user WHERE user_id=?", "s", array($sid));

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>DROPE OF HOPE- User</title>
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
  <link href="../asset_dashboard/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../asset_dashboard/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../asset_dashboard/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="../index.php" class="logo d-flex align-items-center">
        <img src="../asset_dashboard/img/logo.png" alt="">
        <span class="d-none d-lg-block">HemoConnect</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../asset_dashboard/file_uploads/<?php echo htmlspecialchars($data10['user_photo'] ?? 'profile-img.jpg');?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">User</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo htmlspecialchars($data10['user_name'] ?? 'User');?></h6>
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
      $req_row = getRows($con, "SELECT * FROM tbl_request a INNER JOIN tbl_donation b ON a.reciever_id=b.donation_id WHERE b.user_id=? AND request_status='Added'", "s", array($sid));
      if (!empty($req_row)) {
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
