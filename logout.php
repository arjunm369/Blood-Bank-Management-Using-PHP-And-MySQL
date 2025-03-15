<?php

session_start();
$end=session_destroy();
if($end==TRUE)
{
    echo '<script>alert("Logged Out Successfully")</script>';
    header("location:login.php");
}


?>