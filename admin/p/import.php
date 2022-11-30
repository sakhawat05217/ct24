<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import</title>
</head>

<body>
<?php
if(!isset($_SESSION['muser'])) echo "<script>window.location='../l/login.php?ref=p/import.php';</script>";

include("config.php");
include("function.php");

?>

<div align="right"><a href="../l/logout.php">Logout</a></div>
<br />


<br />
<?php
if(isset($_POST['import_db']))
{
 $my_sql_file = $_FILES['import_db_name']['name']; 
 $ext_arr =  explode('.',$my_sql_file);
 $ext = $ext_arr[count($ext_arr)-1];
 if($ext=='sql')
  {
	move_uploaded_file($_FILES['import_db_name']['tmp_name'],$my_sql_file);  
	$my_sql_file = $my_sql_file; 
	 
  }
 if($ext=='zip')
  {
	  
	include "../z/pclzip.lib.php";
	
	move_uploaded_file($_FILES['import_db_name']['tmp_name'],$my_sql_file);  
	$zip = new PclZip($my_sql_file);  
	
	$zip->extract('');
	
	$my_sql_file = $ext_arr[0].'.sql'; 
	 
  }
 //echo $my_sql_file;
 //echo "<pre>";print_r($_FILES['import_db_name']);
 //exit();
 
 
 //echo $my_sql_file; exit();	
 if($_SERVER['HTTP_HOST']=='localhost:8000')
 {
	 $dbbin = "e:\\xampp\\mysql\\bin\\";
	 system($dbbin."mysql -u $DB_USERNAME $DB_DATABASE < $my_sql_file");
	 echo "DB Import completed. ";
	 //system('mysql --user=USER --password=PASSWORD DATABASE< FOLDER/.sql');
 }
 else
 {
	$command = system("mysql -u $DB_USERNAME -p$DB_PASSWORD -h $DB_HOST -P $DB_PORT $DB_DATABASE < $my_sql_file",$return_value);
	
	echo "<h3>Return Code: $return_value </h3>";
	if($return_value==0) echo "DB Import completed. ";
	else echo "Error Importing the DB!";
 }

}

?>

<form action="" method="post" enctype="multipart/form-data">
<input type="submit" name="import_db" value="Import" />
<input type="file" name="import_db_name" required="required"  />

</form>

</body>

</html>