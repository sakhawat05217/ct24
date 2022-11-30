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
       	 <div class="text-primary">Country Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$date = date("Y-m-d");


if(isset($_POST['add_new']))
{
	$sql = "insert into ct_country (country_code,country_name,currency_code,currency_name,created_at) value( '" . 
		$_POST['country_code'] . "', '".
		$_POST['country_name'] . "', '".
		$_POST['currency_code'] . "', '".
		$_POST['currency_name'] . "', ". 
		"'". $date . "') ";

	$result = mysqli_query($link,$sql);
	
	if(mysqli_error($link))
	{
		echo mysqli_error($link);
	}
	else
	{
		echo "New country has been successfully added.";
	}
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
			
$default_low_limit = 30;

$sid = isset($_GET['sid'])? $_GET['sid'] : 'country_code'; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'country_code'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'asc';

if(isset($_GET['sav']))
{
	$country_code = $_GET['coc'];
	$country_name = $_GET['con'];
	$currency_code = $_GET['cuc'];
	$currency_name = $_GET['cun'];
	
	$rid = $_GET['sav'];
	
	$sql= "update ct_country set
	country_code = '$country_code',
	country_name = '$country_name',
	currency_code = '$currency_code',
	currency_name = '$currency_name',
	updated_at = '$date'
	where id=$rid ";
	
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully saved.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
else if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_country where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = $sid;
	$s_string = $s_str;

	$sql= "select * from ct_country where $sr_type like '%$s_string%'  order by $s_type $s_order";
}
else
{
	$sql= "select * from ct_country  order by $s_type $s_order";
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
  <div class="col-2">Country Code</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="country_code" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Country Name</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="country_name" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Currency Code</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="currency_code" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Currency Name</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="currency_name" /></div>
</div> 
 
<br /> 
<div class="row">
  <div class="col-2"></div>
  <div class="col-2"><input type="submit" name="add_new" class="btn btn-primary" value="Add New Country" /></div>
</div>  
</form>
<h1 align="center">Found: <?= $total_rows ?></h1>  
<br /><br />    
Search Country By: 
<select name="sid" id="sid">
    <option value="country_code" <?= ($sid=='country_code')? ' selected="selected" ':'' ?>>Country Code</option>
    <option value="country_name" <?= ($sid=='country_name')? ' selected="selected" ':'' ?>>Country Name</option>
    <option value="currency_code" <?= ($sid=='currency_code')? ' selected="selected" ':'' ?>>Currency Code</option>
    <option value="currency_name" <?= ($sid=='currency_name')? ' selected="selected" ':'' ?>>Currency Name</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='country.php'" />
<br /><br />
Total countries found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display countries per page: 
<select onchange="window.location.href='country.php?p=<?= $current_page ?>&li='+this.value">
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


echo '<div class="container"><div class="row"><div class="col-sm-1">#</div><div class="col-sm-2">'.get_column('country_code',
$sid,$s_str,$row_limit).'</div><div class="col-sm-2">'.get_column('country_name',
$sid,$s_str,$row_limit).'</div><div class="col-sm-2">'.get_column('currency_code',
$sid,$s_str,$row_limit).'</div><div class="col-sm-2">'.get_column('currency_name',
$sid,$s_str,$row_limit).'</div><div class="col-sm-2">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
	echo '<div class="row">';
	echo '<div class="col-sm-1">'.($j+1).'</div><div class="col-sm-2"><input id="'.$new_data[0].'_country_code" type="text" class="form-control" value="'.$new_data[1].'" /></div><div class="col-sm-2"><input id="'.$new_data[0].'_country_name" type="text" class="form-control" value="'.$new_data[2].'" /></div><div class="col-sm-2"><input id="'.$new_data[0].'_currency_code" type="text" class="form-control" value="'.$new_data[3].'" /></div><div class="col-sm-2"><input id="'.$new_data[0].'_currency_name" type="text" class="form-control" value="'.$new_data[4].'" /></div>';

	echo '<div class="col-sm-2"><input class="btn btn-success" type="button" value="Save" onclick="save_country('.$new_data[0].')" /> <input type="button" class="btn btn-danger" value="Delete" onclick="delete_country('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="country.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
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
		window.location.href='country.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function save_country(rid)
{
	var yn = confirm("Are you sure you want to save this data?");
	if(yn)
	{
		
		var country_code = $('#'+rid+'_country_code').val();
		var country_name = $('#'+rid+'_country_name').val();
		var currency_code = $('#'+rid+'_currency_code').val();
		var currency_name = $('#'+rid+'_currency_name').val();
		window.location.href='country.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&sav='+rid+'&coc='+country_code+'&con='+country_name+'&cuc='+currency_code+'&cun='+currency_name;
		
	}
}

function delete_country(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='country.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');
</script>