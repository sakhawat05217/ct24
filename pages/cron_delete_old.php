<?php
include("config.php");
include("functions.php");

$sql= 'select * from ct_log';
$result = mysqli_query($link,$sql);

$row_count = mysqli_affected_rows($link);
$log_limit = 10000;
if($row_count>$log_limit)
{
    $del_limit = $row_count - $log_limit;
    $sql= "delete from ct_log limit $del_limit";
    mysqli_query($link,$sql);
}

$sql= 'select * from ct_history';
$result = mysqli_query($link,$sql);

$row_count = mysqli_affected_rows($link);
$history_limit = 15000;
if($row_count>$history_limit)
{
    $del_limit = $row_count - $history_limit;
    $sql= "delete from ct_history limit $del_limit";
    mysqli_query($link,$sql);
}

?>