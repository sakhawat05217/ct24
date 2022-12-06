<?php

date_default_timezone_set('Asia/Singapore');

//db start

$localhost = "localhost";

$db_user = "";

$db_password = "";

$database = "";

$link = mysqli_connect($localhost,$db_user,$db_password);

mysqli_select_db($link,$database);

//db end

$home_page = "https://ct-24.com";

?>