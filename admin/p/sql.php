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

</body>

</html>