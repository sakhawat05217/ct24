<?php
 
function RunSQL($sql)
{
	include("config.php");
	//error_reporting(0);
	$result = mysqli_query($link,$sql);
	$i=0;
	$my_data = array();
	$data = mysqli_fetch_array($result);
	$my_data[$i++] = $data;	
	while($data)
	{
		$data = mysqli_fetch_array($result);
		$my_data[$i++] = $data;	
	}
	return $my_data;
}

?>