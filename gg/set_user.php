<?php
include("includes/functions.php");
include("includes/config.php");

@$email = $_REQUEST['e'];
@$password = $_REQUEST['p'];
@$name = $_REQUEST['n'];
$date = date("Y-m-d");

$check_user=check_user($email);
                
if($check_user==1)
{
    echo "1";
}
else
{
    $sql = "insert into gg_users (name,email,password,created_at) value( '" . 
    $name . "', '".
    $email . "', '".
    $password . "', '".
    $date . "') ";

    $result = mysqli_query($link,$sql);
    
    echo "2";
}

?>