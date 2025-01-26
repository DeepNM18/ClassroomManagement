<?php
  session_start();
  $_SESSION['uid'][$_GET['sk']] = null;
  header("Location:login.php");
?>