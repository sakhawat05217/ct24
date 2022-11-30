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

$file_name = $send_country_name."---To---".$receive_country_name."---Send Amount---".$send_amount.".xls";

header("Content-Type: application/xls"); 
header("Content-Disposition: attachment; filename=\"$file_name\""); 
header("Pragma: no-cache"); 
header("Expires: 0");

echo '<table>';
echo "<tr><th>Provider Name"."</th><th>"."Provider Link"."</th><th>"."Received Amount"."</th><th>"."Mid Rate"."</th><th>"."Fee"."</th><th>"."Date"."</th></tr>";

$sql= "select * from ct_view_data_collection where data_id = $d_id order by received_amount desc";
    
$result = mysqli_query($link,$sql) or die(mysqli_error($link));

while($data = mysqli_fetch_row($result))
{
    echo '<tr><td>'.$data[2]."</td><td>".$data[3]."</td><td>".$data[4]."</td><td>".$data[5]."</td><td>".$data[6]."</td><td>".$data[7]."</td></tr>";
}
echo"</table>";
?>