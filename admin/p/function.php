<?php

function ShowTables()
{
	include("config.php");
	//error_reporting(0);
	$statement = $pdo->prepare('SHOW TABLES');
	$statement->execute();
	$data = $statement->fetchAll(PDO::FETCH_NUM);
	return $data;
}
 
function RunSQL($sql)
{
	include("config.php");
	//error_reporting(0);
	$data = $pdo->query($sql)->fetchAll();
	return $data;
}

?>