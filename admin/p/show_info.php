<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Table Information</title>
</head>

<body>

<?php
include("config.php");
include("function.php");

$table_name = $_REQUEST['tb'];

echo "<h1 align='center'>Table Name: $table_name</h1>";

$sql = "DESC $table_name";
$data = RunSQL($sql);

$first=0;
$c=1;
foreach($data as $d)
{
	
	
	if($d)
	{
		if($first==0)
		{
			echo '<table border="2" cellpadding="5"><tr align="center"><td>#</td>';
			
			foreach($d as $k=>$v)
			{
				if(is_string($k))
				echo "<td>".$k . "</td>";
			}
			echo "</tr>";
			
			$first=1;
			
		}
		
		echo '<tr align="center">';
		echo "<td>".$c++."</td>";
		foreach($d as $k=>$v)
		{
			
			if(is_string($k))
				echo "<td>".$v . "</td>";
		}
		
		echo "</tr>";
		//print_r($d) . "<br />";
		
	}
}

echo "</table><br><br>";


$primary_key = 'id';
$mysql = "CREATE TABLE $table_name (";

$data = array_filter($data);
foreach($data as $d)
{
	$default = '';
	if(strtolower($d->Null)=='yes') 
	{
		$null =	' NULL ';
		$default = ' DEFAULT NULL ';
	}
	else
	{
		$null =	' NOT NULL ';
		$default = ($d->Default==null)? '': ' DEFAULT "'.$d->Default.'" ';
	}
	
	if(strtolower($d->Key)=='pri') $primary_key = $d->Field;
	
	$extra = ($d->Extra==null)? '': $d->Extra;
	
	$mysql .= $d->Field . " " . $d->Type . " " . $null . " " . $default . " " . $extra ." , ";
	//`id` int(10) unsigned NOT NULL  DEFAULT '1' AUTO_INCREMENT,
}

$mysql .= " PRIMARY KEY ($primary_key)";
$mysql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

echo '<textarea rows="10" cols="160">'. $mysql .'</textarea>';

echo "<br><br><pre>";
print_r($data);

?>

</body>
</html>