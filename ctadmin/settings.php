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
       	 <div class="text-primary">Settings Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$date = date("Y-m-d h:i:s A");


if(isset($_POST['add_new']))
{
	$sql = "insert into ct_settings (parameter_type,parameter_name,parameter_value,info,created_at) value( '" . 
		$_POST['parameter_type'] . "', '".
		$_POST['parameter_name'] . "', '".
		$_POST['parameter_value'] . "', '".
		$_POST['info'] . "', ". 
		"'". $date . "') ";

	$result = mysqli_query($link,$sql);
	
	if(mysqli_error($link))
	{
		echo mysqli_error($link);
	}
	else
	{
		echo "New parameter has been successfully added.";
	}
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
			
$default_low_limit = 30;

$sid = isset($_GET['sid'])? $_GET['sid'] : 'parameter_type'; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'parameter_type'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'asc';

if(isset($_GET['sav']))
{
	$parameter_type = $_GET['pt'];
	$parameter_name = $_GET['pn'];
	$parameter_value = $_GET['pv'];
	$info = $_GET['inf'];
	
	$rid = $_GET['sav'];
	
	$sql= "update ct_settings set
	parameter_type = '$parameter_type',
	parameter_name = '$parameter_name',
	parameter_value = '$parameter_value',
	info = '$info',
	updated_at = '$date'
	where id=$rid ";
	
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully saved.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
else if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_settings where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
else if(isset($_GET['delete_old']))
{
	$sql= "delete from ct_settings where parameter_type = 'provider' and parameter_name='new'";
	mysqli_query($link,$sql) or die(mysqli_error($link));
    
    $sql= "update ct_settings set
	parameter_value = '0',
	updated_at = '$date'
	where parameter_type = 'provider' and parameter_name='loop' ";
	
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your old data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}        

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = $sid;
	$s_string = $s_str;

	$sql= "select * from ct_settings where $sr_type like '%$s_string%'  order by $s_type $s_order";
}
else
{
	$sql= "select * from ct_settings  order by $s_type $s_order";
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
  <div class="col-2">Parameter Type</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="parameter_type" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Parameter Name</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="parameter_name" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Parameter Value</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="parameter_value" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Information</div>
  <div class="col-2"><input type="text" class="form-control" name="info" /></div>
</div> 
 
<br /> 
<div class="row">
  <div class="col-2"></div>
  <div class="col-2"><input type="submit" name="add_new" class="btn btn-primary" value="Add New Parameter" /></div>
</div>  
</form>
<h1 align="center">Found: <?= $total_rows ?></h1>  
<br /><br />    
Search Country By: 
<select name="sid" id="sid">
    <option value="parameter_type" <?= ($sid=='parameter_type')? ' selected="selected" ':'' ?>>Parameter Type</option>
    <option value="parameter_name" <?= ($sid=='parameter_name')? ' selected="selected" ':'' ?>>Parameter Name</option>
    <option value="parameter_value" <?= ($sid=='parameter_value')? ' selected="selected" ':'' ?>>Parameter Value</option>
    <option value="info" <?= ($sid=='info')? ' selected="selected" ':'' ?>>Information</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='settings.php'" />
<input type="button" class="btn btn-danger" value="Delete OLD" onclick="delete_old()" />
<br /><br />
Total countries found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display settings per page: 
<select onchange="window.location.href='settings.php?p=<?= $current_page ?>&li='+this.value">
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


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-2">'.get_column('parameter_type',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('parameter_name',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('parameter_value',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('info',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('updated_at',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
	echo '<div class="row">';
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-2"><input id="'.$new_data[0].'_parameter_type" type="text" class="form-control" value="'.$new_data[1].'" /></div><div class="col-xl-2"><input id="'.$new_data[0].'_parameter_name" type="text" class="form-control" value="'.$new_data[2].'" /></div><div class="col-xl-2"><input id="'.$new_data[0].'_parameter_value" type="text" class="form-control" value="'.$new_data[3].'" /></div><div class="col-xl-2"><input id="'.$new_data[0].'_info" type="text" class="form-control" value="'.$new_data[4].'" /></div><div class="col-xl-1">'.$new_data[6].'</div>';

	echo '<div class="col-xl-2"><input class="btn btn-success" type="button" value="Save" onclick="save_settings('.$new_data[0].')" /> <input type="button" class="btn btn-danger" value="Delete" onclick="delete_settings('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="settings.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
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
		window.location.href='settings.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function save_settings(rid)
{
	var yn = confirm("Are you sure you want to save this data?");
	if(yn)
	{
		
		var parameter_type = $('#'+rid+'_parameter_type').val();
		var parameter_name = $('#'+rid+'_parameter_name').val();
		var parameter_value = $('#'+rid+'_parameter_value').val();
		var info = $('#'+rid+'_info').val();
		window.location.href='settings.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&sav='+rid+'&pt='+parameter_type+'&pn='+parameter_name+'&pv='+parameter_value+'&inf='+info;
		
	}
}

function delete_old()
{
	var yn = confirm("Are you sure you want to delete old data?");
	if(yn)
	{
		
		window.location.href='settings.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&delete_old=1';
	}
}
    
function delete_settings(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='settings.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');
</script>