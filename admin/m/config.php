<?php
error_reporting(E_ALL);

$DB_HOST='';
$DB_DATABASE='';
$DB_USERNAME='';
$DB_PASSWORD='';
$DB_PORT='';


$index_file = "../m/ini.txt";

foreach(file($index_file) as $line) 
{
	if((strpos($line, 'DB_HOST') !== false)) $DB_HOST = trim(str_replace("DB_HOST=","",$line));
	else if((strpos($line, 'DB_DATABASE') !== false)) $DB_DATABASE =  trim(str_replace("DB_DATABASE=","",$line));
	else if((strpos($line, 'DB_USERNAME') !== false)) $DB_USERNAME =  trim(str_replace("DB_USERNAME=","",$line));
	else if((strpos($line, 'DB_PASSWORD') !== false)) $DB_PASSWORD =  trim(str_replace("DB_PASSWORD=","",$line));
	else if((strpos($line, 'DB_PORT') !== false)) $DB_PORT =  trim(str_replace("DB_PORT=","",$line));
}

$link = mysqli_connect($DB_HOST,$DB_USERNAME,$DB_PASSWORD);
$connect = mysqli_select_db($link,$DB_DATABASE);
if($connect)
 {
	 //echo "DB Connected.<br />";
 }
else
 echo "DB Connection Error!";

?>