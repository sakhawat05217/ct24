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
       	 <div class="text-primary">Provider Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$date = date("Y-m-d h:i:s A");
$source_array = array();
$sql= 'select * from ct_country order by country_name asc';
$result = mysqli_query($link,$sql);
while($data = mysqli_fetch_array($result))
{
	$source_array[]=$data['currency_code'];
}

$source_country = isset($_POST['source_country'])? $_POST['source_country']: 'USD';
	
if(isset($_POST['update_list']))
{
	echo "<script>document.getElementById('alert').style.display='block';</script>";
	
	$provider_count=0;
    $provider_update_count=0;
		
	$target_array = array();
	
	$target_array = $source_array;
	
	$providers = array();

	$rate_arr = array();
	$i=0;
	
	$new_array = array($source_country);
		
	foreach ($new_array as $sa)
	{
		foreach ($target_array as $ta)
		{
			if($sa!==$ta)
			{
			
				$url = "https://api.transferwise.com/v3/comparisons/?sourceCurrency=$sa&targetCurrency=$ta&sendAmount=100";
				
				$headers = array(
					'Content-Type:application/json'
				);
				
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
				
				$my_data = json_decode($result);
		
				foreach ($my_data->providers as $pd)
				   {
					   $rate_arr[$i] = $providers['alias'][$i] = $pd->alias;
					   $providers['name'][$i] = $pd->name;
                       $providers['logo'][$i] = $pd->logos->normal->pngUrl;
					   $i++;
				   }
			}
		}
	}
	
	if(!empty($providers))
	{
		$providers['alias']=array_unique($providers['alias']);
		$providers['name']=array_unique($providers['name']);
        $providers['logo']=array_unique($providers['logo']);
		$rate_arr=array_unique($rate_arr);
		
		asort($rate_arr);
	
		foreach($rate_arr as $k=>$v)
		{
	
			$web_link = "https://wise.com";
	
			$alias=$providers['alias'][$k];
			$sql= "select * from ct_provider where alias='$alias'";
			$result = mysqli_query($link,$sql);
            
            $send_country_arr = get_country_tk(substr($sa,0,2));
            $send_country_name = $send_country_arr['name']; 
            $receive_country_arr = get_country_tk(substr($ta,0,2));
            $receive_country_name = $receive_country_arr['name'];
            
            $info = $send_country_name." => ".$receive_country_name;
	
			if($result->num_rows==0)
			{
				
				$sql2 = "insert into ct_provider (name,alias,link,logo,info,created_at) value( '" . 
					$providers['name'][$k] . "', '".
					$alias . "', '".
					$web_link . "', '". 
                    $providers['logo'][$k] . "', '".
                    $info. "', '".
					$date . "') ";
			
				$result2 = mysqli_query($link,$sql2);
				
				if(mysqli_error($link))
				{
					echo mysqli_error($link);
				}
				else
				{
					$provider_count++;
				}
	
			}
            else
            {
                 $sql3 = "update ct_provider set
                 logo = '". $providers['logo'][$k] ."',
                 updated_at = '". $date ."'
                 where alias='$alias'";
			
                    $result3 = mysqli_query($link,$sql3);

                    if(mysqli_error($link))
                    {
                        echo mysqli_error($link);
                    }
                    else
                    {
                        $provider_update_count++;
                    }
                 
            }
		}
	}

	$msg = "";
	if($provider_count>0)
		$msg = "Total $provider_count provider(s) has been successfully added.";
	else if($provider_update_count>0)
        $msg = "Total $provider_update_count provider(s) has been successfully updated.";
    else
		$msg = "No new record has been found! Please try again later.";
    
	
    echo $msg;
}

if(isset($_POST['name']))
{
	

	$sql = "insert into ct_provider (name,alias,link,logo,speed,created_at) value( '" . 
		$_POST['name'] . "', '".
		$_POST['alias'] . "', '".
		$_POST['link'] . "', '". 
        $_POST['logo'] . "', '".
        $_POST['speed'] . "', '".
		$date . "') ";

	$result = mysqli_query($link,$sql);
	
	if(mysqli_error($link))
	{
		echo mysqli_error($link);
	}
	else
	{
		echo "New provider has been successfully added.";
	}
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
			
$default_low_limit = 30;

$sid = isset($_GET['sid'])? $_GET['sid'] : ''; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'id'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'desc';

if(isset($_GET['sav']))
{
	$name = $_GET['name'];
	$alias = $_GET['alias'];
	$my_link = $_GET['my_link'];
    $my_logo = $_GET['my_logo']; 
    $speed = $_GET['speed']; 
	$rid = $_GET['sav'];
	
	$sql= "update ct_provider set
	name = '$name',
	alias = '$alias',
	link = '$my_link',
    logo = '$my_logo',
    speed = '$speed',
	updated_at = '$date'
	where id=$rid ";
	
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully saved.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
else if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from ct_provider where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}

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

<form action="" method="post">
<div class="row">
  <div class="col-2">Provider Name</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="name" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Provider Alias</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="alias" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Provider Link</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="link" /></div>
</div> 
 
<br />    
<div class="row">
  <div class="col-2">Provider Logo</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="logo" /></div>
</div> 

<br />    
<div class="row">
  <div class="col-2">Provider Speed</div>
  <div class="col-2"><input type="text" class="form-control" name="speed" /></div>
</div> 
    
<br /> 
<div class="row">
  <div class="col-2"></div>
  <div class="col-2"><input type="submit" class="btn btn-primary" value="Add New Provider" /></div>
</div>  
</form>
    
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
<a href="provider_view.php" target="_blank" class="btn btn-secondary">View All</a> 
<a href="visited_provider.php" target="_blank" class="btn btn-info">Visited Provider</a>     
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='provider.php'" />
<br /><br />
Total providers found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display providers per page: 
<select onchange="window.location.href='provider.php?p=<?= $current_page ?>&li='+this.value">
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

<form action="" method="post">
    <div align="center">
    	
        Source Country: 
        <select name="source_country" id="source_country">
        
		<?php
		foreach($source_array as $sa)
		{
			$country_arr = get_country_tk(substr($sa,0,2));
			if($sa == $source_country) echo '<option selected="selected" value="'.$sa.'">'.$country_arr['name'].'</option>';
			else echo '<option value="'.$sa.'">'.$country_arr['name'].'</option>';
		}
		?>
        </select>
        
        <input type="submit" onclick="$('#ajax_load').show();" id="update_list" name="update_list" value="Update Lists" class="btn btn-success" />
        
        <a href="check_alias.php" target="_blank" class="btn btn-primary">Check All</a>
        
        <a href="check_alias_partial.php" target="_blank" class="btn btn-info">Partial</a>
        
        <input type="button" onclick="$('#source_country option:selected').next().attr('selected', 'selected');$('#update_list').click();" value="Next" class="btn btn-warning" />
    </div>
</form>


<br><br>

<?php


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-2">'.get_column('name',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('alias',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">'.get_column('link',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('logo',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('speed',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('updated_at',
$sid,$s_str,$row_limit).'</div><div class="col-xl-1">'.get_column('id',
$sid,$s_str,$row_limit).'</div><div class="col-xl-2">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
	echo '<div class="row">';
	echo '<div class="col-xl-1">'.($j+1).'</div><div class="col-xl-2"><input id="'.$new_data[0].'_name" type="text" class="form-control" value="'.$new_data[1].'" /></div><div class="col-xl-1"><input id="'.$new_data[0].'_alias" type="text" class="form-control" value="'.$new_data[2].'" /></div><div class="col-xl-2"><input id="'.$new_data[0].'_link" type="text" class="form-control" value="'.$new_data[3].'" /></div><div class="col-xl-1"><input id="'.$new_data[0].'_logo" type="text" class="form-control" value="'.$new_data[4].'" /></div><div class="col-xl-1"><input id="'.$new_data[0].'_speed" type="text" class="form-control" value="'.$new_data[5].'" /></div><div class="col-xl-1">'.$new_data[8].'</div><div class="col-xl-1">'.$new_data[0].'</div>';

	echo '<div class="col-xl-2"><input class="btn btn-success" type="button" value="Save" onclick="save_provider('.$new_data[0].')" /> <input type="button" class="btn btn-danger" value="Delete" onclick="delete_provider('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';


echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="provider.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
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
		window.location.href='provider.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function save_provider(rid)
{
	var yn = confirm("Are you sure you want to save this data?");
	if(yn)
	{
		
		var name = $('#'+rid+'_name').val();
		var alias = $('#'+rid+'_alias').val();
		var my_link = $('#'+rid+'_link').val();
        var my_logo = $('#'+rid+'_logo').val();
        var speed = $('#'+rid+'_speed').val();
		window.location.href='provider.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&sav='+rid+'&name='+name+'&alias='+alias+'&my_link='+my_link+'&my_logo='+my_logo+'&speed='+speed;
		
	}
}

function delete_provider(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='provider.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}
document.getElementById('ajax_load').style.display="none";

order_active('<?= $s_type ?>','<?= $s_order ?>');
</script>