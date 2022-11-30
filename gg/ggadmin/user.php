<?php
include("header.php");
include("../includes/functions.php");

?>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">User Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="container">
	<div id="alert" class="alert alert-success" role="alert">
<?php

$date = date("Y-m-d");

if(isset($_POST['name']))
{
	

	$sql = "insert into gg_users (name,email,password,status,role,created_at) value( '" . 
		$_POST['name'] . "', '".
		$_POST['email'] . "', '".
		$_POST['password'] . "', ". 
		$_POST['status'] . ", ".
		$_POST['role'] . ", ".
		"'". $date . "') ";

	$result = mysqli_query($link,$sql);
	
	if(mysqli_error($link))
	{
		echo mysqli_error($link);
	}
	else
	{
		echo "New user has been successfully added.";
	}
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
			
$default_low_limit = 30;

$sid = isset($_GET['sid'])? $_GET['sid'] : ''; 
$s_str = isset($_GET['s_str'])? $_GET['s_str'] : '';

$s_type = isset($_GET['s_type'])? $_GET['s_type'] : 'name'; 
$s_order = isset($_GET['s_order'])? $_GET['s_order'] : 'asc';

if(isset($_GET['sav']))
{
	$status = $_GET['st'];
	$role = $_GET['r'];
	$rid = $_GET['sav'];
	
	$sql= "update gg_users set
	status = $status,
	role = $role,
	updated_at = '$date'
	where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully saved.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}
else if(isset($_GET['del']))
{
	$rid = $_GET['del'];
	$sql= "delete from gg_users where id=$rid ";
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	echo "Your data has been successfully deleted.";
	echo "<script>document.getElementById('alert').style.display='block';</script>";
}

if(isset($_GET['s_str']))
{
	$sr_type = 'name';
	$s_string = $s_str;
    switch($sid)
	{
		case 'nid': $sr_type = 'name'; break;
		case 'eid': $sr_type = 'email'; break;
            
		case 'stid': 
		$sr_type = 'status'; 
		if(strtolower($s_str)=='active') $s_string = 1;
		else if(strtolower($s_str)=='inactive') $s_string = 0;
		
		break;
		
		case 'rid': 
		$sr_type = 'role'; 
		if(strtolower($s_str)=='user') $s_string = 1;
		else if(strtolower($s_str)=='admin') $s_string = 0;
		break;
	}
	
	
	
	$sql= "select * from gg_users where $sr_type like '%$s_string%'  order by $s_type $s_order";
}
else
{
	$sql= "select * from gg_users  order by $s_type $s_order";
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
  <div class="col-2">User Name</div>
  <div class="col-2"><input required="required" type="text" class="form-control" name="name" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">User Email</div>
  <div class="col-2"><input required="required" type="email" class="form-control" name="email" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Password</div>
  <div class="col-2"><input required="required" type="password" class="form-control" name="password" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Status</div>
  <div class="col-2"><select name="status" ><option value="1">Active</option><option value="0">Inactive</option></select></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Role</div>
  <div class="col-2"><select name="role"><option value="1">User</option><option value="0" >Admin</option></select></div>
</div> 
<br /> 
<div class="row">
  <div class="col-2"></div>
  <div class="col-2"><input type="submit" class="btn btn-primary" value="Add New User" /></div>
</div>  
</form>
    
<h1 align="center">Found: <?= $total_rows ?></h1>     

<br /><br />    
Search User By: 
<select name="sid" id="sid">
    <option value="nid" <?= ($sid=='nid')? ' selected="selected" ':'' ?>>Name</option>
    <option value="eid" <?= ($sid=='eid')? ' selected="selected" ':'' ?>>Email</option>
    <option value="stid" <?= ($sid=='stid')? ' selected="selected" ':'' ?>>Status</option>
	<option value="rid" <?= ($sid=='rid')? ' selected="selected" ':'' ?>>Role</option>
</select>
<input type="text" size="40" value="<?= $s_str ?>" style="text-align:center;" name="s_str" id="s_str" />
<input type="button" value="Search" class="btn btn-primary" onclick="search_sid()" />
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='user.php'" />
<br /><br />
Total users found: <?= $total_rows ?>
, Current Page: <?=  $current_page ?> / <?= $total_pages ?>

<br /><br />
Display users per page: 
<select onchange="window.location.href='user.php?p=<?= $current_page ?>&li='+this.value">
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


echo '<div class="container"><div class="row"><div class="col-sm-1">#</div><div class="col-sm-2">'.get_column('name',$sid,$s_str,$row_limit).'</div><div class="col-sm-3">'.get_column('email',$sid,$s_str,$row_limit).'</div><div class="col-sm-1">'.get_column('status',$sid,$s_str,$row_limit).'</div><div class="col-sm-1">'.get_column('role',$sid,$s_str,$row_limit).'</div><div class="col-sm-2">Action</div></div><br>';


for($j=$low_limit; $j<=$high_limit; $j++)
{
	$my_select='';
	$new_data = $data[$j];
	echo '<div class="row">';
	echo '<div class="col-sm-1">'.($j+1).'</div><div class="col-sm-2">'.$new_data[1].'</div><div class="col-sm-3">'.$new_data[2]."</div>";
	
	if($new_data[4]==0) $my_select='selected="selected"';
	echo '<div class="col-sm-1"><select name="status" id="'.$new_data[0].'_status"><option value="1">Active</option><option value="0" '.$my_select.'>Inactive</option></select></div>';
	
	if($new_data[5]==0) $my_select='selected="selected"';
	echo '<div class="col-sm-1"><select name="role" id="'.$new_data[0].'_role"><option value="1">User</option><option value="0" '.$my_select.'>Admin</option></select></div>';
	
	echo '<div class="col-sm-2"><input class="btn btn-success" type="button" value="Save" onclick="save_user('.$new_data[0].')" /> <input type="button" class="btn btn-danger" value="Delete" onclick="delete_user('.$new_data[0].')" /></div>';
	
	echo "</div><br>";
}


echo '</div>';

echo '<div class="pagination">';

for($i=1; $i<=$total_pages; $i++)
{
	$active_class='';
	if($i==$current_page) $active_class='active';
?>

 <a class="<?= $active_class ?>" href="user.php?p=<?= $i ?>&li=<?= $row_limit ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>"><?= $i ?></a>
	
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
		window.location.href='user.php?p=1&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid='+sid+'&s_str='+s_str;
	}
}

function save_user(rid)
{
	var yn = confirm("Are you sure you want to save this data?");
	if(yn)
	{
		
		var status = $('#'+rid+'_status').val();
		var role = $('#'+rid+'_role').val();
		window.location.href='user.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&st='+status+'&r='+role+'&sav='+rid;
		
	}
}

function delete_user(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		
		window.location.href='user.php?p=<?= $current_page ?>&li=<?= $row_limit ?>&s_type=<?= $s_type ?>&s_order=<?= $s_order ?>&sid=<?= $sid ?>&s_str=<?= $s_str ?>&del='+rid;
	}
}


order_active('<?= $s_type ?>','<?= $s_order ?>');

</script>