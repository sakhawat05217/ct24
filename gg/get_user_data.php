<?php
include("includes/functions.php");
include("includes/config.php");

@$email = $_REQUEST['e'];

$check_user=check_user($email);
                
if($check_user==0)
{
    echo "0";
}
else
{
    $sql= 'select * from gg_users WHERE email = "' . $email . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
    
    $user_json = "[{'name':'".$data['name']."','email':'".$data['email']."','password':'".$data['password']."'}]";
    echo $user_json;
}

?>