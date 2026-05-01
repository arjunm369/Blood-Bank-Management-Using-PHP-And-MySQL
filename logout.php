<?php
session_start();
session_destroy();
$_SESSION['flash_message'] = "Logged Out Successfully";
header("location:login.php");
exit;
?>
