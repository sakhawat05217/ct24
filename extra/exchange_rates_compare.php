<?php

$url = "https://api.transferwise.com/v3/comparisons/?sourceCurrency=USD&targetCurrency=XOF&sendAmount=100";

$headers = array(
    'Content-Type:application/json'
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