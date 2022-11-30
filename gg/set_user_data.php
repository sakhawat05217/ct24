<?php
include("includes/functions.php");
include("includes/config.php");

@$email = $_REQUEST['e'];
@$password = $_REQUEST['p'];
@$name = $_REQUEST['n'];
$date = date("Y-m-d");

$check_user=check_user($email);
                
if($check_user==0)
{
    echo "0";
}
else
{
    $sql = "update gg_users set  
    name = '" . $name . "', 
    password = '". $password . "', 
    updated_at = '". $date . "' where email='".$email."'; ";

    $result = mysqli_query($link,$sql);
    
    echo "1";
}

?>