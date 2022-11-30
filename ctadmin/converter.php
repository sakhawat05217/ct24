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
       	 <div class="text-primary">Currency Converter</div>
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
    $sql= "select * from ct_currency_converter where target_country='".$_POST['target_country']."'";

    $result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
    
    $new_country = get_country_tk($_POST['target_country']);
    
    if($data!==null) 
    {
        echo $new_country['name']." is already exist!!!";
    }
	else
	{
        $sql = "insert into ct_currency_converter (target_country,created_at) value( " . "'".$_POST['target_country'] . "', ". "'". $date . "') ";

	    mysqli_query($link,$sql);
        
		echo $new_country['name']." has been successfully added.";
	}
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
			
$default_low_limit = 200;

$sid = isset($_GET['sid'])? $_GET['sid'] : 'send_country'; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'target_country'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'asc';

if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_currency_converter where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
    
    $sql= "delete from ct_view_currency_converter where converter_id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = $sid;
	$s_string = $s_str;
    
    if($sid=='target_country') $s_string = get_country_code($s_str);

	$sql= "select * from ct_currency_converter where $sr_type like '%$s_string%'  order by $s_type $s_order";
}
else
{
	$sql= "select * from ct_currency_converter order by $s_type $s_order";
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

$source_country_code = get_settings('currency_converter','source_country');        
$source_country = get_country_tk($source_country_code);
        
?>
	</div>

    
<form action="" method="post">
 
<div class="row">
  <div class="col-2">Source Country</div>
  <div class="col-2">
      <?= $source_country['name'] ?>
  </div>
</div> 
<br />
<div class="row">
  <div class="col-2">Target Country</div>
  <div class="col-2">
      <select name="target_country" id="target_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="BD"></select>
  </div>
</div> 
<br />
 
<br /> 
<div class="row">
  <div class="col-2"></div>
  <div class="col-2"><input type="submit" name="add_new" class="btn btn-primary" value="Add" /></div>
</div>  
</form>
    
<h1 align="center">Found: <?= $total_rows ?></h1>  
    
<br /><br />    
Search Country By: 
<select name="sid" id="sid">
    <option value="target_country">Target Country</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<a href="view_converter.php" target="_blank" class="btn btn-info">View</a> 
<a href="view_bd_converter.php" target="_blank" class="btn btn-info">View BD</a>    
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='converter.php'" />
<br /><br />
Total countries found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display countries per page: 
<select onchange="window.location.href='converter.php?p=<?= $current_page ?>&li='+this.value">
<option value="200">200</option>
<option value="300" <?= ($row_limit==300)? ' selected="selected" ':'' ?>>300</option>
<option value="400" <?= ($row_limit==400)? ' selected="selected" ':'' ?>>400</option>
<option value="500" <?= ($row_limit==500)? ' selected="selected" ':'' ?>>500</option>
<option value="600" <?= ($row_limit==600)? ' selected="selected" ':'' ?>>600</option>
</select>
    


<br /><br/>


<?php


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-3">'.get_column('target_country',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];

    $target_country_code = $new_data[1];      
    $target_country = get_country_tk($target_country_code);

    
	echo '<div class="row">';
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-3">'.$target_country['name'].'</div>';
    
    echo '<div class="col-xl-2"><input type="button" class="btn btn-danger" value="Delete" onclick="delete_data_collection('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="converter.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
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
		window.location.href='converter.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function delete_data_collection(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='converter.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');
</script>