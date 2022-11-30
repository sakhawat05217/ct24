<?php 
session_start(); //starting session
unset($_SESSION['muser']); //clearing cache
setcookie("muser",'',0);
echo "<script>window.location='../index.php';</script>"; //redirecting to index page
?>