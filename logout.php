<?php 
session_start(); //starting session
include("pages/functions.php");

?>
<script src="js/jquery.min.js"></script>
<script src="js/script.js"></script>

<script>
setCookie('gmail_username', '', 1);
setCookie('ct_username', '', 1);    
</script>

<?php
$ip = get_ip_link(get_client_ip());
$server = $_SERVER['HTTP_HOST'];
$ip_data = get_ip_data();
@$user_name = get_user_link($_SESSION['ct_myuser']);

$info = "$user_name has been logged out. $ip_data, $ip";

save_log('Logout',$server, $info);

unset($_SESSION['ct_myuser']); //clearing cache
unset($_COOKIE['ct_username']); //clearing cache
setcookie("ct_username",'', 0);
//echo "User: ".$_COOKIE['ct_username']; exit;
echo "<script>window.location='index.php';</script>"; 

?>