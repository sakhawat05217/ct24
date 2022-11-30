<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>File Edit</title>
</head>

<body>
<?php
ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
ini_set('max_execution_time', 600);
ini_set('memory_limit','1024M');

$f_name = $_REQUEST['f_name'];
$basedir = $_REQUEST['basedir'];


$my_file = trim($basedir)."/".trim($f_name);
//echo $my_file . "<br />" . $basedir;
$my_str = file_get_contents($my_file);
 if(isset($_POST['save_data']))
{

	$my_str = $_POST['my_str'];
	
	$fp = fopen($my_file,"w");
    fwrite($fp,$my_str);
	echo "File Saved";
}
?>
<form action="" method="post">

<textarea  cols="120" rows="30" name="my_str"><?= $my_str ?></textarea>
<br />
<input type="submit" name="save_data" value="Save" />
</form>
</body>
</html>