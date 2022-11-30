<?php
date_default_timezone_set('Asia/Singapore');
//db start
$localhost = "localhost";
$db_user = "ct-admin";
$db_password = "Money2022!";
$database = "ct-24";
$link = mysqli_connect($localhost,$db_user,$db_password);
mysqli_select_db($link,$database);
//db end
$home_page = "https://currencytransfer24.com";
?>