<?php
include("includes/functions.php");

@$email = $_REQUEST['e'];
@$password = $_REQUEST['p'];

$check_user=check_user_password($email,$password);
                
if($check_user==0)
{
    echo "0";
}
else
{
    echo "1";
}

?>