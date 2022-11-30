<?php

$url = "https://api.sandbox.transferwise.tech/v1/rates?source=USD&target=BDT";

$headers = array(
    'Content-Type:application/json',
    'Authorization: Bearer 4825bc9e-1165-4fc2-9190-7ebc5dab8a7a' 
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$my_data = json_decode($result);
echo "<pre>";
print_r($my_data);
?>