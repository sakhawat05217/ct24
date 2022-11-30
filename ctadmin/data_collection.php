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
       	 <div class="text-primary">Data Collection Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$date = date("Y-m-d h:i:s A");
$user = get_user();

if(isset($_POST['add_new']))
{
    
    $sql = "insert into ct_data_collection (user_id,send_country,receive_country,send_amount,watch_till,watch_status,created_at) value( " . 
        $user['id'] . ", '".
        $_POST['send_country'] . "', '".
		$_POST['receive_country'] . "', ".
		$_POST['send_amount'] . ", ".
		$_POST['watch_till'] . ",1, ". 
		"'". $date . "') ";

	$result = mysqli_query($link,$sql);
	
	if(mysqli_error($link))
	{
		echo mysqli_error($link);
	}
	else
	{
		echo "New data collection has been successfully added.";
	}
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
			
$default_low_limit = 30;

$sid = isset($_GET['sid'])? $_GET['sid'] : 'send_country'; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'created_at'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'asc';

if(isset($_GET['sav']))
{
	$send_country = $_GET['sc'];
	$receive_country = $_GET['rc'];
	$send_amount = $_GET['sa'];
	$watch_till = $_GET['wt'];
    $watch_status = $_GET['ws'];    

	$rid = $_GET['sav'];
	
	$sql= "update ct_data_collection set
	send_country = '$send_country',
	receive_country = '$receive_country',
	send_amount = $send_amount,
	watch_till = $watch_till,
    watch_status = $watch_status,
    created_at = '$date',
	updated_at = '$date'
	where id=$rid ";
	
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully saved.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
else if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_data_collection where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
    
    $sql= "delete from ct_view_data_collection where data_id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = $sid;
	$s_string = $s_str;
    
    if(($sid=='send_country')or($sid=='receive_country')) $s_string = get_country_code($s_str);

	$sql= "select * from ct_data_collection where $sr_type like '%$s_string%'  order by $s_type $s_order";
}
else
{
	$sql= "select * from ct_data_collection  order by $s_type $s_order";
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

<form action="" method="post">
<div class="row">
  <div class="col-2">Send Country</div>
  <div class="col-2">
      <select name="send_country" id="send_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="SG"></select>
  </div>
</div> 
<br />
<div class="row">
  <div class="col-2">Receive Country</div>
  <div class="col-2">
      <select name="receive_country" id="receive_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="IN"></select>
  </div>
</div> 
<br />
<div class="row">
  <div class="col-2">Send Amount</div>
  <div class="col-2"><input required="required" value="1000" type="text" class="form-control" name="send_amount" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Watch till next days</div>
  <div class="col-2"><input required="required" value="10" type="text" class="form-control" name="watch_till" /></div>
</div> 
 
<br /> 
<div class="row">
  <div class="col-2"></div>
  <div class="col-2"><input type="submit" name="add_new" class="btn btn-primary" value="Add New Data" /></div>
</div>  
</form>
    
<h1 align="center">Found: <?= $total_rows ?></h1>  
    
<br /><br />    
Search Country By: 
<select name="sid" id="sid">
    <option value="send_country" <?= ($sid=='send_country')? ' selected="selected" ':'' ?>>Send Country</option>
    <option value="receive_country" <?= ($sid=='receive_country')? ' selected="selected" ':'' ?>>Receive Country</option>
    <option value="send_amount" <?= ($sid=='send_amount')? ' selected="selected" ':'' ?>>Send Amount</option>
    <option value="watch_till " <?= ($sid=='watch_till ')? ' selected="selected" ':'' ?>>Watch Till </option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<a href="view_data_collection.php" target="_blank" class="btn btn-info">View Collection</a>    
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='data_collection.php'" />
<br /><br />
Total countries found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display countries per page: 
<select onchange="window.location.href='data_collection.php?p=<?= $current_page ?>&li='+this.value">
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


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-3">'.get_column('send_country',
$sid,$s_str,$row_limit).'</div><div class="col-xl-3">'.get_column('receive_country',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('send_amount',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('watch_till',
$sid,$s_str,$row_limit).'(days)</div><div class="col-xl-1">'.get_column('watch_status',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
    
    $send_country = $new_data[2];
    $receive_country = $new_data[3];


    $send_country_name ='<select id="'.$new_data[0].'_send_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="'.$send_country .'"></select>';

    $receive_country_name ='<select id="'.$new_data[0].'_receive_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="'.$receive_country .'"></select>';
    
	echo '<div class="row">';
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-3">'.$send_country_name.'</div><div class="col-xl-3">'.$receive_country_name.'</div><div class="col-xl-1"><input id="'.$new_data[0].'_send_amount" type="text" class="form-control" value="'.$new_data[4].'" /></div><div class="col-xl-1"><input id="'.$new_data[0].'_watch_till" type="text" class="form-control" value="'.$new_data[5].'" /></div>';
    
    if($new_data[6]==0) $my_select='selected="selected"';
	echo '<div class="col-xl-1"><select id="'.$new_data[0].'_watch_status"><option value="1">Active</option><option value="0" '.$my_select.'>Inactive</option></select></div>';
   
	echo '<div class="col-xl-2"><input class="btn btn-success" type="button" value="Save" onclick="save_data_collection('.$new_data[0].')" /> <input type="button" class="btn btn-danger" value="Delete" onclick="delete_data_collection('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="data_collection.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
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
		window.location.href='data_collection.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function save_data_collection(rid)
{
	var yn = confirm("Are you sure you want to save this data?");
	if(yn)
	{
		
		var send_country = $('#'+rid+'_send_country').val();
		var receive_country = $('#'+rid+'_receive_country').val();
		var send_amount = $('#'+rid+'_send_amount').val();
		var watch_till = $('#'+rid+'_watch_till').val();
        var watch_status = $('#'+rid+'_watch_status').val();
		window.location.href='data_collection.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&sav='+rid+'&sc='+send_country+'&rc='+receive_country+'&sa='+send_amount+'&wt='+watch_till+'&ws='+watch_status;
		
	}
}

function delete_data_collection(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='data_collection.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');
</script>