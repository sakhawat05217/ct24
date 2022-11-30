<?php

include("config.php");

include("functions.php");

$ip = get_client_ip();

$param=$_GET["param"];

add_settings('controls','extra_param',$param,$ip);

?>