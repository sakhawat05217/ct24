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
       	 <div class="text-primary">View Data Collection</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
	<div id="alert" class="alert alert-success" role="alert">
   <script>
       //document.getElementById('alert').style.display='block';
    </script>     
<?php
$data_collection_sql= "select * from ct_data_collection";
$data_collection_result = mysqli_query($link,$data_collection_sql) or die(mysqli_error($link));
$data_collection_data = mysqli_fetch_all($data_collection_result);        

$data_id = 0;
        
if(null!==$data_collection_data)
{
    $data_id = $data_collection_data[0][0];
}
        
$d_id = isset($_GET['d_id'])? $_GET['d_id'] : $data_id;    
        

if($d_id<=0) $data_id_sql= "";
else $data_id_sql = " and data_id = $d_id ";        
        
        
$today = date("Y-m-d h:i:s A");
 			
$default_low_limit = 100;

$sid = isset($_GET['sid'])? $_GET['sid'] : 'user_name'; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'received_amount'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'desc';

if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_view_data_collection where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}

if((isset($_GET['s_str']))and(!empty($_GET['s_str'])))
{
	$sr_type = $sid;
	$s_string = $s_str;
    
    $sql= "select * from ct_view_data_collection where $sr_type like '%$s_string%' $data_id_sql  order by $s_type $s_order,id asc limit 10000";

}
else
{
	$sql= "select * from ct_view_data_collection where id > 0 $data_id_sql order by $s_type $s_order,id asc limit 10000";
    
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
Show data for this collection: 
<select id="show_data_collection" onChange="show_data_collection()">
    <?php
    foreach($data_collection_data as $dc)
    {
        $send_country=$dc[2];
        $receive_country=$dc[3];
        $send_amount=$dc[4];
        
        $send_country_arr = get_country_tk($send_country);
        $send_country_name = $send_country_arr['name']; 
        $receive_country_arr = get_country_tk($receive_country);
        $receive_country_name = $receive_country_arr['name'];
        
        if($d_id==$dc[0]) echo '<option selected="selected" value="'.$dc[0].'">'.$send_country_name.' => '.$receive_country_name.' => '.$send_amount.'</option>';
        else echo '<option value="'.$dc[0].'">'.$send_country_name.' => '.$receive_country_name.' => '.$send_amount.'</option>';
    }
    ?>
   
</select>
  

<h1>Found: <?= $total_rows ?></h1>
</div>
    
<br /><br />    
Search data By: 
<select name="sid" id="sid">
    <option value="provider_name" <?= ($sid=='provider_name')? ' selected="selected" ':'' ?>>Provider Name</option>
    <option value="provider_link" <?= ($sid=='provider_link')? ' selected="selected" ':'' ?>>Provider Link</option>
    <option value="received_amount" <?= ($sid=='received_amount')? ' selected="selected" ':'' ?>>Received Amount</option>
    <option value="mid_rate" <?= ($sid=='mid_rate')? ' selected="selected" ':'' ?>>Mid Rate</option>
    <option value="fee" <?= ($sid=='fee')? ' selected="selected" ':'' ?>>Fee</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='view_data_collection.php'" />

<a href="data_collection_download_csv.php?d_id=<?= $d_id ?>" class="btn btn-info">Download In CSV</a>

<a href="data_collection_download_xls.php?d_id=<?= $d_id ?>" class="btn btn-primary">Download In XLS</a>   
<br /><br />
Total data found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display data per page: 
<select onchange="window.location.href='view_data_collection.php?p=<?= $current_page ?>&d_id=<?= $d_id ?>&li='+this.value">
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


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-2">'.get_column('provider_name',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('provider_link',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('received_amount',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('mid_rate',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('fee',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('date',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$new_data = $data[$j];
	
	echo '<div class="row">';
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-2">'.$new_data[2].'</div><div class="col-xl-2">'.$new_data[3].'</div><div class="col-xl-2">'.$new_data[4].'</div><div class="col-xl-1">'.$new_data[5].'</div><div class="col-xl-1">'.$new_data[6].'</div><div class="col-xl-1">'.$new_data[7].'</div>';

	echo '<div class="col-xl-1"><input type="button" class="btn btn-danger" value="Delete" onclick="delete_view_data_collection('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="view_data_collection.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&d_id=<?= $d_id ?>"><?= $i ?></a>
	
<?php
}
echo '</div>';
?>

</div>
<?php
include("footer.php");
?>

<script>
    
function show_data_collection()
{
	var d_id = $('#show_data_collection').val();
    
	window.location.href='view_data_collection.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&d_id='+d_id;
	
}
    
function search_sid()
{
	var sid = $('#sid').val();
	var s_str = $('#s_str').val();
	if(s_str=='')
	 alert("Search text can't be empty!");
	else
	{
		window.location.href='view_data_collection.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str+'&d_id=<?= $d_id ?>';
	}
}

function delete_view_data_collection(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='view_data_collection.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid+'&d_id=<?= $d_id ?>';
	}
}

document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');

</script>