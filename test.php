<?php

echo "<pre>";
print_r($_SERVER);
$root_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/';
echo $root_path;

?>