<?php
include("functions.php");

$send_amount=$_GET["send_amount"];
$send_country=$_GET["send_country"];
$receive_country=$_GET["receive_country"];

$send_country_arr = get_country_tk($send_country);
$send_country_tk = $send_country_arr['tk']; 
$receive_country_arr = get_country_tk($receive_country);
$receive_country_tk = $receive_country_arr['tk']; 

$my_rate = get_current_rate($send_amount,$send_country,$receive_country);
$amount = floatval($my_rate) * floatval($send_amount);

$single_rate = "1 ".$send_country_tk." = ".$my_rate." ".$receive_country_tk;
echo $single_rate."#".$amount;
?>