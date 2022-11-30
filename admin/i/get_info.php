<?php

$connection=$_GET["connection"];
$table_name=$_GET["table_name"];
$id=$_GET["id"];

if($id!=0)
{
	include("../$connection/config.php");
	include("../$connection/function.php");
	$sql = "select * from $table_name where id = $id";   
	$data = RunSQL($sql);
	
	if($connection!='p')
	  {
		  echo stripslashes($data[0]['info']);
	  }
	  else
	  {
		  echo stripslashes($data[0]->info);
	  }
	
}

?> 