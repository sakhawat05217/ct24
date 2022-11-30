<?php

function check_user($email)
{
	include("config.php");
	
	$sql= 'select * from gg_users WHERE email = "' . $email . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	$user=0;
    if($data!==null) $user=1;
	return $user;
}

function check_user_password($email,$password)
{
	include("config.php");
	
	$sql= 'select * from gg_users WHERE email = "' . $email . '" and password = "' . $password . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	$user=0;
    if($data!==null) $user=1;
	return $user;
}

function get_client_ip() 
{
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'unknown';
		
	return $ipaddress;
}

function get_column($column_name,$sid,$s_str,$row_limit)
{
	$column_title=$column_name;
	if($column_name=='date') $column_name = 'created_at';
	
	if(strpos($column_title,"_")>0)
	{
		$column_title = str_replace("_"," ",$column_title);
	}
	
	if($column_title=='ip') $column_title = 'IP';
    
    if($row_limit=='') $row_limit = 30;
	
	return "<a href='?li=$row_limit&s_type=$column_name&s_order=asc&sid=$sid&s_str=$s_str'><span id='$column_name"."_"."asc' class='arr'>&darr; </span></a>" . ucwords($column_title) . "<a href='?li=$row_limit&s_type=$column_name&s_order=desc&sid=$sid&s_str=$s_str'><span id='$column_name"."_"."desc' class='arr'> &uarr;</span></a>";
}

function get_user()
{
	include("config.php");
	$email = $_SESSION['gg_myuser'];
	
	$sql= 'select * from gg_users WHERE email = "' . $email . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	
	return $data;
}

function is_admin()
{
	include("config.php");
	$email = $_SESSION['gg_myuser'];
	$sql= 'select * from gg_users WHERE email = "' . $email . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	$user=0;
    if($data['role']==0) $user=1;
	return $user;
}

?>