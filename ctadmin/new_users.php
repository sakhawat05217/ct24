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
       	 <div class="text-primary">New Users Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$day = isset($_GET['day'])? $_GET['day'] : 0;
$now =  date("Y-m-d");        
$today = date("Y-m-d");

$from_day = date('Y-m-d', strtotime($today. " - $day days"));  
        
if($day==0) $date_sql= " created_at >= '$now' ";
else if($day==1) $date_sql= " created_at > '$from_day' and created_at < '$today' ";        
else $date_sql= " created_at >= '$from_day' and created_at <= '$today' ";

			
$default_low_limit = 200;

$sid = isset($_GET['sid'])? $_GET['sid'] : 'user_name'; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'id'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'desc';

if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_new_users where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = $sid;
	$s_string = $s_str;

	$sql= "select * from ct_new_users where $date_sql and $sr_type like '%$s_string%'  order by $s_type $s_order limit 10000";
}
else
{
	$sql= "select * from ct_new_users where $date_sql order by $s_type $s_order limit 10000";
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

<br /><br />    
<div align="center">
Show data for the days: 
<select id="history_day" onChange="show_history()">
    <option value="0">Today</option>
    <option value="1" <?= ($day==1)? ' selected="selected" ':'' ?>>Yesterday</option>
    <option value="7" <?= ($day==7)? ' selected="selected" ':'' ?>>Last 7 Days</option>
    <option value="30" <?= ($day==30)? ' selected="selected" ':'' ?>>Last 30 Days</option>
    <option value="90" <?= ($day==90)? ' selected="selected" ':'' ?>>Last 3 Months</option>
    <option value="180" <?= ($day==180)? ' selected="selected" ':'' ?>>Last 6 Months</option>
    <option value="365" <?= ($day==365)? ' selected="selected" ':'' ?>>Last 1 Year</option>
</select> 
 
<h1>Found: <?= $total_rows ?></h1>    

</div>
    
<br /><br />    
Search history By: 
<select name="sid" id="sid">
    <option value="user_name" <?= ($sid=='user_name')? ' selected="selected" ':'' ?>>User Name</option>
    <option value="ip" <?= ($sid=='ip')? ' selected="selected" ':'' ?>>IP</option>
    <option value="country" <?= ($sid=='country')? ' selected="selected" ':'' ?>>Country</option>
    <option value="server" <?= ($sid=='server')? ' selected="selected" ':'' ?>>Server</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<a href="chart_new_users.php" target="_blank" class="btn btn-warning">Chart</a>    
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='new_users.php'" />
<br /><br />
Total history found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display history per page: 
<select onchange="window.location.href='new_users.php?p=<?= $current_page ?>&day=<?= $day ?>&li='+this.value">
<option value="200">200</option>
<option value="300" <?= ($row_limit==300)? ' selected="selected" ':'' ?>>300</option>
<option value="400" <?= ($row_limit==400)? ' selected="selected" ':'' ?>>400</option>
<option value="500" <?= ($row_limit==500)? ' selected="selected" ':'' ?>>500</option>
<option value="600" <?= ($row_limit==600)? ' selected="selected" ':'' ?>>600</option>
</select>
    


<br /><br/>


<?php


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-2">'.get_column('user_name',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('ip',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('country',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('server',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('date',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('id',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
	$user_name = $new_data[1];

    $ip = get_ip_link($new_data[2]);
	
	$user_name = get_user_link($user_name);
	
	echo '<div class="row">';
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-2">'.$user_name.'</div><div class="col-xl-2">'.$ip.'</div><div class="col-xl-2">'.$new_data[3].'</div><div class="col-xl-1">'.$new_data[4].'</div><div class="col-xl-1">'.$new_data[5].'</div><div class="col-xl-1">'.$new_data[0].'</div>';

	echo '<div class="col-xl-1"><input type="button" class="btn btn-danger" value="Delete" onclick="delete_history('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="new_users.php?p=<?= $i ?>&day=<?= $day ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
<?php
}
echo '</div>';
?>

</div>
<?php
include("footer.php");
?>

<script>
function show_history()
{
    var day = $('#history_day').val();
    
	window.location.href='new_users.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&day='+day;
	
}    
function search_sid()
{
	var sid = $('#sid').val();
	var s_str = $('#s_str').val();
	if(s_str=='')
	 alert("Search text can't be empty!");
	else
	{
		window.location.href='new_users.php?p=1&day=<?= $day ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function delete_history(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='new_users.php?p=<?= $current_page ?>&day=<?= $day ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');

</script>