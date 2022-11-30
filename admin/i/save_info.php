<?php

$connection=$_GET["connection"];
$table_name=$_GET["table_name"];
$id=$_GET["id"];
$title=$_GET["title"];
$info=$_GET["info"];

if($id!=0)
{
	include("../$connection/config.php");
	include("../$connection/function.php");
	$sql = "update $table_name set
	title='$title',
	info='$info'
	where id = $id";   
	$data = RunSQL($sql);
	echo "Saved successfull for title '$title'";
}

?> 