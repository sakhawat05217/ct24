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
       	 <div class="text-primary">Provider View Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$date = date("Y-m-d");
$source_array = array();
$sql= 'select * from ct_country order by country_name asc';
$result = mysqli_query($link,$sql);
while($data = mysqli_fetch_array($result))
{
	$source_array[]=$data['currency_code'];
}

$source_country = isset($_POST['source_country'])? $_POST['source_country']: 'USD';
	
			
$default_low_limit = 30;

$sid = isset($_GET['sid'])? $_GET['sid'] : ''; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'id'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'desc';

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = 'name';
	$s_string = $s_str;
    switch($sid)
	{
		case 'nid': $sr_type = 'name'; break;
		case 'aid': $sr_type = 'alias'; break;
		case 'lid': $sr_type = 'link'; break;
        case 'loid': $sr_type = 'logo'; break; 
        case 'spid': $sr_type = 'speed'; break;    
	}
	
	
	
	$sql= "select * from ct_provider where $sr_type like '%$s_string%' order by $s_type $s_order";
}
else
{
	$sql= "select * from ct_provider order by $s_type $s_order";
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
Search Provider By: 
<select name="sid" id="sid">
    <option value="nid" <?= ($sid=='nid')? ' selected="selected" ':'' ?>>Name</option>
    <option value="aid" <?= ($sid=='aid')? ' selected="selected" ':'' ?>>Alias</option>
    <option value="lid" <?= ($sid=='lid')? ' selected="selected" ':'' ?>>Link</option>
    <option value="loid" <?= ($sid=='loid')? ' selected="selected" ':'' ?>>Logo</option>
    <option value="spid" <?= ($sid=='spid')? ' selected="selected" ':'' ?>>Speed of Remittance</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='provider_view.php'" />
<br /><br />
Total providers found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display providers per page: 
<select onchange="window.location.href='provider_view.php?p=<?= $current_page ?>&li='+this.value">
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
    

<br><br>
    
<?php


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-2">'.get_column('logo',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('name',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('alias',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('link',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('id',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('speed',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('status',
$sid,$s_str,$row_limit).'</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
	echo '<div class="row">';
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-2"><img  width="150px" src="'.$new_data[4].'" alt="logo" title="'.$new_data[4].'" /></div><div class="col-xl-2">'.$new_data[1].'</div><div class="col-xl-1">'.$new_data[2].'</div><div class="col-xl-2"><a href="'.$new_data[3].'" target="_blank">'.$new_data[1].' </a></div><div class="col-xl-1">'.$new_data[0].'</div><div class="col-xl-1">'.$new_data[5].'</div><div class="col-xl-1">'.$new_data[9].'</div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="provider_view.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
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
		window.location.href='provider_view.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');
</script>