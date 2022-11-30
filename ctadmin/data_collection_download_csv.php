<?php
include("../pages/config.php");
include("../pages/functions.php");
$d_id = $_GET['d_id']; 

$sql= "select * from ct_data_collection where id = $d_id";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$data = mysqli_fetch_row($result);

$send_country=$data[2];
$receive_country=$data[3];
$send_amount=$data[4];

$send_country_arr = get_country_tk($send_country);
$send_country_name = $send_country_arr['name']; 
$receive_country_arr = get_country_tk($receive_country);
$receive_country_name = $receive_country_arr['name'];

$file_name = $send_country_name."---To---".$receive_country_name."---Send Amount---".$send_amount.".csv";

header("Content-Type: application/xls"); 
header("Content-Disposition: attachment; filename=\"$file_name\""); 
header("Pragma: no-cache"); 
header("Expires: 0");

echo "Provider Name,\t Provider Link,\t Received Amount,\t Mid Rate,\t Fee,\t Date\n";

$sql= "select * from ct_view_data_collection where data_id = $d_id order by received_amount desc";
    
$result = mysqli_query($link,$sql) or die(mysqli_error($link));

while($data = mysqli_fetch_row($result))
{
    echo $data[2].",\t".$data[3].",\t".$data[4].",\t".$data[5].",\t".$data[6].",\t".$data[7]."\n";
}

?>