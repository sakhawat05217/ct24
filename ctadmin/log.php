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
       	 <div class="text-primary">Log Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$date = date("Y-m-d h:i:s A");
		
$default_low_limit = 1000;

$sid = isset($_GET['sid'])? $_GET['sid'] : 'id'; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'id'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'desc';

if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_log where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
else if(isset($_GET['delete_old']))
{
	$sql= "delete from ct_log limit 10000";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your old data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
} 
else if(isset($_GET['delete_me']))
{
	$sql= "delete from ct_log where info like '%sakhawat%'";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your old data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
else if(isset($_GET['clear_all']))
{
	$sql= "truncate ct_log";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your all data has been successfully cleared.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}            

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = $sid;
	$s_string = $s_str;

	$sql= "select * from ct_log where $sr_type like '%$s_string%'  order by $s_type $s_order";
}
else
{
	$sql= "select * from ct_log  order by $s_type $s_order limit 10000";
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
Search Country By: 
<select name="sid" id="sid">
    <option value="parameter_name" <?= ($sid=='parameter_name')? ' selected="selected" ':'' ?>>Parameter Name</option>
    <option value="parameter_value" <?= ($sid=='parameter_value')? ' selected="selected" ':'' ?>>Parameter Value</option>
    <option value="info" <?= ($sid=='info')? ' selected="selected" ':'' ?>>Information</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='log.php'" />
    
<input type="button" class="btn btn-danger" value="Clear" onclick="clear_all()" />    
<input type="button" class="btn btn-danger" value="Delete Old 10,000" onclick="delete_old()" />    
<input type="button" class="btn btn-danger" value="Del Me" onclick="delete_me()" />
<br /><br />
Total countries found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display logs per page: 
<select onchange="window.location.href='log.php?p=<?= $current_page ?>&li='+this.value">
<option value="1000">1000</option>
<option value="2000" <?= ($row_limit==2000)? ' selected="selected" ':'' ?>>2000</option>
<option value="3000" <?= ($row_limit==3000)? ' selected="selected" ':'' ?>>3000</option>
<option value="4000" <?= ($row_limit==4000)? ' selected="selected" ':'' ?>>4000</option>
<option value="5000" <?= ($row_limit==5000)? ' selected="selected" ':'' ?>>5000</option>
<option value="6000" <?= ($row_limit==6000)? ' selected="selected" ':'' ?>>6000</option>
<option value="7000" <?= ($row_limit==7000)? ' selected="selected" ':'' ?>>7000</option>
<option value="8000" <?= ($row_limit==8000)? ' selected="selected" ':'' ?>>8000</option>
<option value="9000" <?= ($row_limit==9000)? ' selected="selected" ':'' ?>>9000</option>
<option value="10000" <?= ($row_limit==10000)? ' selected="selected" ':'' ?>>10000</option>
</select>
    


<br /><br/>


<?php


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-2">'.get_column('parameter_name',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('parameter_value',
$sid,$s_str,$row_limit).'</div><div class="col-xl-4">'.get_column('info',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('date',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('id',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">Action</div></div><br>';

  
for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
    
    $bg_color = '';
    $text_color = '';
    
    if(str_contains($new_data[1],'Search')) 
    {
        $bg_color = 'bg-primary'; 
    }
    else if(str_contains($new_data[1],'Provider')) 
    {
        $bg_color = 'bg-info'; 
        $text_color = 'text-light';
    }
    else if(str_contains($new_data[1],'Currency Converter')) 
    {
        $bg_color = 'bg-warning'; 
    }
    
        
	echo "<div class='row $text_color $bg_color' style='padding:10px;'>";
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-2">'.$new_data[1].'</div><div class="col-xl-2">'.$new_data[2].'</div><div class="col-xl-4">'. stripcslashes( $new_data[3]).'</div><div class="col-xl-1">'.$new_data[4].'</div><div class="col-xl-1">'.$new_data[0].'</div>';

	echo '<div class="col-xl-1"><input type="button" class="btn btn-danger" value="Delete" onclick="delete_settings('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="log.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
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
		window.location.href='log.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function delete_old()
{
	var yn = confirm("Are you sure you want to delete old data?");
	if(yn)
	{
		
		window.location.href='log.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&delete_old=1';
	}
}
   
function clear_all()
{
	var yn = confirm("Are you sure you want to delete all data?");
	if(yn)
	{
		
		window.location.href='log.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&clear_all=1';
	}
} 
    
function delete_me()
{
	var yn = confirm("Are you sure you want to delete old data?");
	if(yn)
	{
		
		window.location.href='log.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&delete_me=1';
	}
}    
    
function delete_settings(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='log.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');
</script>