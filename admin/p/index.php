<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>P</title>
</head>

<body>
<?php
if(!isset($_SESSION['muser'])) echo "<script>window.location='../l/login.php?ref=p';</script>";

include("config.php");
include("function.php");

?>

<div align="right"><a href="../l/logout.php">Logout</a></div>
<br />

<table>
<tr valign="top">
<td>

<form action="" method="post">

<br />
<?php
if(isset($_POST['runsql']))
{
	$sql = $_POST['sql'];
	$data = RunSQL($sql);
	
	if($data)
	{
		echo "<h1>Success</h1>";
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
		
}
else if(isset($_POST['export_db']))
{
 $my_sql_file = $DB_DATABASE.".sql";
	
 if($_SERVER['HTTP_HOST']=='localhost:8000')
 {
	 $dbbin = "e:\\xampp\\mysql\\bin\\";
	 system($dbbin."mysqldump $DB_DATABASE -u $DB_USERNAME > $my_sql_file");
 }
 else
 {
	 $command = system("mysqldump -u $DB_USERNAME -p$DB_PASSWORD -h $DB_HOST -P $DB_PORT --single-transaction --set-gtid-purged=OFF $DB_DATABASE > $my_sql_file",$return_value);
	 
	echo "<h3>Return Code: $return_value </h3>";
	if($return_value==0) echo "DB Export completed. ";
	else echo "Error Exporting the DB!";

 }
	 
    include "../z/zip.class.php";
    $myfile = $my_sql_file;
	$mydir = '.';
	if (class_exists('ZipArchive')) 
	{
		$myzip = new ZipArchive;
	
		if ($myzip->open("$mydir/$myfile.zip", ZipArchive::CREATE) === TRUE)
		{
			// Add files to the zip file
			$myzip->addFile("$mydir/$myfile");
			
			$myzip->close();
		}
	}
	else
	{
		system("zip $my_sql_file.zip $my_sql_file ");
	}
 
	 echo "<a href='".$my_sql_file.".zip'>Download The DB</a>";
}

else if(isset($_POST['export_tables']))
{
 $table_name = '';
 foreach($_POST['table_name'] as $table) 
 {
   $table_name .= $table . " "; 
 }
  //echo $table_name;
 
 $my_sql_file = $DB_DATABASE.".sql";
	
 if($_SERVER['HTTP_HOST']=='localhost:8000')
 {
	 $dbbin = "e:\\xampp\\mysql\\bin\\";
	 system($dbbin."mysqldump $DB_DATABASE $table_name -u $DB_USERNAME > $my_sql_file");
 }
 else
 {
	 $command = system("mysqldump -u $DB_USERNAME -p$DB_PASSWORD -h $DB_HOST -P $DB_PORT --single-transaction --set-gtid-purged=OFF $DB_DATABASE $table_name > $my_sql_file",$return_value);
	 
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

else if(isset($_POST['import_db']))
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
$current_date = date("Y_m_d",time());
$year = date("Y",time());
$month = date("m",time())-1;
if($month<10) $month="0$month";
$one_month_ago = "$year-$month-01";
?>
<br />
<select onchange="document.getElementById('sql_body').value=this.value;">
<option value=""></option>
<option value="TRUNCATE table_name">TRUNCATE</option>
<option value="DROP TABLE table_name">DROP TABLE</option>
<option value="SELECT * FROM table_name WHERE ">SELECT</option>
<option value="SELECT * FROM table_name GROUP BY column_name">GROUP BY</option>
<option value="SELECT COUNT(*) FROM table_name">COUNT</option>
<option value="INSERT INTO table_name (col1, col2) VALUES (val1, val2)">INSERT</option>
<option value="UPDATE table_name SET col1=val1, col2=val2 WHERE ">UPDATE</option>
<option value="DELETE FROM table_name WHERE ">DELETE</option>
<option value="CREATE TABLE dispatch_scorm_scoes_track_<?= $current_date ?> LIKE dispatch_scorm_scoes_track">CREATE TABLE</option>
<option value="INSERT dispatch_scorm_scoes_track_<?= $current_date ?> SELECT * FROM  dispatch_scorm_scoes_track">COPY DATA</option>
<option value="DELETE FROM dispatch_scorm_scoes_track WHERE updated_at < '<?= $one_month_ago ?>'">DELETE MONTH</option>
<option value="RENAME TABLE table_old_name TO table_new_name">RENAME</option>
</select>
<input type="button" value="Refresh" onclick="window.location.href='index.php'" />
<br /><br />
<textarea  id="sql_body"  cols="60" rows="10" name="sql"><?= isset($_POST['sql'])? $_POST['sql']: '' ?></textarea>
<input type="submit" name="runsql" value="Run SQL" />
</form>
<?php
$data = ShowTables();
?>
<form action="" method="post">
<input type="submit" name="export_db" value="Export The DB" />
</form>

<br />
<form action="" method="post" enctype="multipart/form-data">
<input type="submit" name="import_db" value="Import The DB" />
<input type="file" name="import_db_name" required="required"  />

</form>

</td>


<td>
<form action="" method="post"  id="multiple_table">
<?php

$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort']:'null';

$table_name_array = array();
foreach($data as $d)
{
	if($d[0]!=null)
	{
		$sql = "select * from $d[0]";
		$table_data = RunSQL($sql);
		$table_name_array[$d[0]]=count($table_data);
	}

}

switch($sort)
{
	case 'null':
		$sort = 'arsort';
		ksort($table_name_array);
		break;
	
	case 'arsort':
		$sort = 'asort';
		arsort($table_name_array);
		break;	
	
	case 'asort':
		$sort = 'krsort';
		asort($table_name_array);
		break;
	
	case 'krsort':
		$sort = 'ksort';
		krsort($table_name_array);
		break;	
		
	case 'ksort':
		$sort = 'arsort';
		ksort($table_name_array);
		break;
	
}

?>
<h2>Table Lists  (<?= count($data) ?>) <a style="text-decoration:none;" href="?&sort=<?= $sort ?>">Sort</a></h2>
<?php

foreach($table_name_array as $key=>$value)
{
	echo '<a style="text-decoration:none;" href="show_table.php?tb='. $key .'&l=10" target="_blank">'.$key . '</a> ('. $value. ')<input type="checkbox" name="table_name[]" value="'.$key . ' "><br />';
	
}

?>

</td>

<td>
<input type="button" value="All" onclick="check_all()" />
<input type="button" value="None" onclick="check_none()" />
<input type="submit" name="export_tables" value="Export Table(s)" />

</td>
</form>

</tr>
</table>


</body>
<script>
function check_all()
{
	var multiple_table = document.getElementById("multiple_table");
	var chks = multiple_table.getElementsByTagName("INPUT");
 
        //Loop and count the number of checked CheckBoxes.
        for (var i = 0; i < chks.length; i++) 
		{
            chks[i].checked=true;
        }
}
function check_none()
{
	var multiple_table = document.getElementById("multiple_table");
	var chks = multiple_table.getElementsByTagName("INPUT");
 
        //Loop and count the number of checked CheckBoxes.
        for (var i = 0; i < chks.length; i++) 
		{
            chks[i].checked=false;
        }
}
</script>
</html>