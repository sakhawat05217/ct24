<?php 
session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export</title>
</head>

<body>
<?php
if(!isset($_SESSION['muser'])) echo "<script>window.location='../l/login.php?ref=m/export.php';</script>";


include("config.php");
include("function.php");
?>

<div align="right"><a href="../l/logout.php">Logout</a></div>
<br />

<br />
<?php
if(isset($_POST['export_db']))
{
 $my_sql_file = $DB_DATABASE.".sql";
	
 if($_SERVER['HTTP_HOST']=='localhost:8000')
 {
	 $dbbin = "e:\\xampp\\mysql\\bin\\";
	 system($dbbin."mysqldump $DB_DATABASE -u $DB_USERNAME > $my_sql_file");
 }
 else
 {
	 
	 
	 $command = system("mysqldump $DB_DATABASE -u $DB_USERNAME -p$DB_PASSWORD -h $DB_HOST > $my_sql_file",$return_value);
	echo "<h3>Return Code: $return_value </h3>";
	if($return_value==0) echo "DB Export completed. ";
	else echo "Error Exporting the DB!";

 }
	 
    include "../z/zip.class.php";
    $myfile = $my_sql_file;
	$mydir = '.';
	$myzip = new ZipArchive;

	if ($myzip->open("$mydir/$myfile.zip", ZipArchive::CREATE) === TRUE)
	{
		// Add files to the zip file
		$myzip->addFile("$mydir/$myfile");
		
		$myzip->close();
	}
	else
	{
		system("zip $my_sql_file.zip $my_sql_file ");
	}
 
	 echo "<a href='".$my_sql_file.".zip'>Download The DB</a>";
}

?>
<br />

<form action="" method="post">
<input type="submit" name="export_db" value="Export" />
</form>

</form>

</body>

</html>