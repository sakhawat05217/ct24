<?php
date_default_timezone_set('Asia/Singapore');
//db start
$localhost = "localhost";
$db_user = "root";
$db_password = "";
//$database = "a_a2";
$database = "Annop_ct24";
$link = mysqli_connect($localhost,$db_user,$db_password);
mysqli_select_db($link,$database);
//db end
$home_page = "http://localhost/projects/Annop/www.ct24.co";
?>