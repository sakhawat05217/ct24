<?php

include("function.php");

$f_name = $_REQUEST['f_name'];
$basedir = $_REQUEST['basedir'];
$my_file = trim($basedir)."/".trim($f_name);

$file_size = filesize($my_file);
$file_size = ConvertSize($file_size);
 

echo "Name: " . $f_name;
echo "<br><br>";
echo "Path: " . $basedir;
echo "<br><br>";
echo "Size: " . $file_size;
echo "<br><br>";
echo "Last modified on: " . date("d-m-Y h:i:s A", filemtime($my_file));
echo "<br><br>";
echo "Last accessed on: " . date("d-m-Y h:i:s A", fileatime($my_file));
echo "<br><br>";
echo "Last created on: " . date("d-m-Y h:i:s A", filectime($my_file));
echo "<br><br>";
echo "File permissions: " . sprintf('%o', fileperms($my_file));
echo "<br><br>";
echo "User ID: " . fileowner($my_file);
echo "<br><br>";
echo "Group ID: " . filegroup($my_file);
echo "<br><br>";
echo "<pre>";
print_r(stat($my_file));
?>
