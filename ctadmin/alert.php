<?php
include("header.php");
include("../pages/functions.php");
//error_reporting(E_ALL);
?>

<div class="ajax_load" id="ajax_load">
    	<img src="../img/my_ajax3.gif" alt="Loading..." />
</div>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Alert Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$date = date("Y-m-d");

			
$default_low_limit = 30;

$sid = isset($_GET['sid'])? $_GET['sid'] : 'user_name'; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';


if($sid=='send_status')
{
    $s_str = strtolower($s_str);
    if($s_str=='new') $s_str=0;
    else if($s_str=='send') $s_str=1;
}
else if(($sid=='send_country')or($sid=='receive_country'))
{
    $s_str = strtolower($s_str);
    $s_str = get_country_code($s_str);

}         

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'created_at'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'desc';

if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_alert where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = $sid;
	$s_string = $s_str;

	$sql= "select * from ct_alert where $sr_type like '%$s_string%'  order by $s_type $s_order limit 1000";
}
else
{
	$sql= "select * from ct_alert  order by $s_type $s_order limit 1000";
}

$result = mysqli_query($link,$sql) or die(mysqli_error($link));

$data = mysqli_fetch_all($result);

$total_rows = count($data);

$row_limit = isset($_GET['li'])? $_GET['li'] : $default_low_limit;
$current_page = isset($_GET['p'])? $_GET['p'] : 1;
$total_pages = ceil($total_rows/$row_limit);

$low_limit = ($current_page*$row_limit)-$row_limit;
$high_limit = $low_limit+$row_limit-1;

if($high_limit>($total_rows-1))
 $high_limit=($total_rows-1);


?>
	</div>
<h1 align="center">Found: <?= $total_rows ?></h1>  
<br /><br />    
Search alert By: 
<select name="sid" id="sid">
    <option value="email" <?= ($sid=='email')? ' selected="selected" ':'' ?>>User Name</option>
    <option value="send_country" <?= ($sid=='send_country')? ' selected="selected" ':'' ?>>Send Country</option>
    <option value="receive_country" <?= ($sid=='receive_country')? ' selected="selected" ':'' ?>>Receive Country</option>
    <option value="max_rate" <?= ($sid=='max_rate')? ' selected="selected" ':'' ?>>Max rate</option>
    <option value="watch_till" <?= ($sid=='watch_till')? ' selected="selected" ':'' ?>>Watch Till</option>
    <option value="send_status" <?= ($sid=='send_status')? ' selected="selected" ':'' ?>>Send Status</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='alert.php'" />
<br /><br />
Total alert found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display alert per page: 
<select onchange="window.location.href='alert.php?p=<?= $current_page ?>&li='+this.value">
<option value="10" <?= ($row_limit==10)? ' selected="selected" ':'' ?>>10</option>
<option value="20" <?= ($row_limit==20)? ' selected="selected" ':'' ?>>20</option>
<option value="30" <?= ($row_limit==30)? ' selected="selected" ':'' ?>>30</option>
<option value="40" <?= ($row_limit==40)? ' selected="selected" ':'' ?>>40</option>
<option value="50" <?= ($row_limit==50)? ' selected="selected" ':'' ?>>50</option>
<option value="60" <?= ($row_limit==60)? ' selected="selected" ':'' ?>>60</option>
<option value="70" <?= ($row_limit==70)? ' selected="selected" ':'' ?>>70</option>
<option value="80" <?= ($row_limit==80)? ' selected="selected" ':'' ?>>80</option>
<option value="90" <?= ($row_limit==90)? ' selected="selected" ':'' ?>>90</option>
<option value="100" <?= ($row_limit==100)? ' selected="selected" ':'' ?>>100</option>
</select>
    


<br /><br/>


<?php


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-2">'.get_column('user_name',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('send_country',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('receive_country',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('max_rate',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('watch_till',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('send_status',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('date',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
	$user_name = $new_data[2];
    
    $send_country = $new_data[3];
    $receive_country = $new_data[4];

    $send_country_arr = get_country_tk($send_country);
    $send_country_name = $send_country_arr['name']; 
    $receive_country_arr = get_country_tk($receive_country);
    $receive_country_name = $receive_country_arr['name'];
    
    $send_status = ($new_data[7]==0)? 'New':'Send';
	
	$user_name = get_user_link($user_name);
	
	echo '<div class="row">';
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-2">'.$user_name.'</div><div class="col-xl-2">'.$send_country_name.'</div><div class="col-xl-2">'.$receive_country_name.'</div><div class="col-xl-1">'.$new_data[5].'</div><div class="col-xl-1">'.$new_data[6].' day(s)</div><div class="col-xl-1">'.$send_status.'</div><div class="col-xl-1">'.$new_data[8].'</div>';

	echo '<div class="col-xl-1"><input type="button" class="btn btn-danger" value="Delete" onclick="delete_alert('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="alert.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
<?php
}
echo '</div>';
?>

</div>
<?php
include("footer.php");
?>

<script>
function search_sid()
{
	var sid = $('#sid').val();
	var s_str = $('#s_str').val();
	if(s_str=='')
	 alert("Search text can't be empty!");
	else
	{
		window.location.href='alert.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function delete_alert(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='alert.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');

</script>