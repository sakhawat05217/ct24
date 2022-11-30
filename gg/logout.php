<?php 
session_start(); //starting session
include("includes/functions.php");

unset($_SESSION['gg_myuser']); //clearing cache
setcookie("gg_username",'',0);
echo "<script>window.location='index.php';</script>"; 
?>