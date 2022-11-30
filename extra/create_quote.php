<?php

$url = "https://api.sandbox.transferwise.tech/v2/quotes";

$headers = array(
    'Content-Type:application/json',
    'Authorization: Bearer 4825bc9e-1165-4fc2-9190-7ebc5dab8a7a' 
);

$data = array(
"sourceCurrency" => "GBP",
"targetCurrency" => "USD",
"sourceAmount"=>10,
"targetAmount" => null,
"profile" => 16352687);

$data_string = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$my_data = json_decode($result);
echo "<pre>";
print_r($my_data);
?>