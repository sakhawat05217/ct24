<?php
include("functions.php");
include("config.php");

$current_user=$_GET["current_user"];
$provider_id=$_GET["provider_id"];

$date = date("Y-m-d h:i:s A");

 $ip = get_client_ip();
 $server = $_SERVER['HTTP_HOST'];
 $ip_data = get_ip_data();

 $sql = "insert into ct_visited_provider (user_name,provider_id,ip,server,created_at) value( '" . 
    $current_user . "', ".
    $provider_id . ", '".
    $ip . "', '".
    $server . "', ". 
    "'". $date . "') ";
$result = mysqli_query($link,$sql);

$sql= "select * from ct_provider WHERE id = $provider_id";
$result = mysqli_query($link,$sql);
$provider_data = mysqli_fetch_array($result);
$alias='';

if(strpos($current_user,'@')>0)
{
    $sql= "select * from ct_users WHERE email = '$current_user'";
	$result = mysqli_query($link,$sql);
	$user_data = mysqli_fetch_array($result);
    
    if($user_data['balance']<1000)
    {
        
        if(($provider_data['alias']=='aspire-bank')or($provider_data['alias']=='instarem'))
        {
            $alias=$provider_data['alias'];
        }

        if($alias!='')
        {
           $to = $current_user;
           $subject = 'Reward Coins';
           $from = 'support@ct-24.com';

           $msg_body ="<h3>If you open an account with this partner ".$provider_data['link'].", you will get 1000 G24 coins.</h3>"."\r\n";

           $msg_body .="<p>After you open an account in here ".$provider_data['link']." with your this email $to please email us to $from and after we verify your account we will credit the amount to your account.</p>"."\r\n"; 

           $msg_body .="<p>Thanks</p>"."\r\n";

           $headers  = 'MIME-Version: 1.0' . "\r\n";
           $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
           $headers .= 'From: '.$from."\r\n".
                'X-Mailer: PHP/' . phpversion();

           mail($to, $subject, $msg_body, $headers);

           //echo $msg_body;
        }
    }
}


$user_name = get_user_link($current_user);
$new_ip = get_ip_link($ip);
$provider_name = $provider_data['name'];
$alias = $provider_data['alias'];
$provider_link = '<a href="provider_view.php?p=1&li=30&s_type=alias&s_order=asc&sid=aid&s_str='.$alias.'" target="_blank">'.$provider_name.'</a>';

if($user_name=='Guest')
{
    $info = "Guest has been visited this provider $provider_link. $ip_data, $new_ip";
}
else
{
    $info = "$user_name has been visited this provider $provider_link. $ip_data, $new_ip";
}


save_log('Provider, '.$server,$provider_name, $info);

?>