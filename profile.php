<?php
include("pages/header.php");

if(!isset($_SESSION['ct_myuser']))
 {
  echo "<script>window.location='login.php';</script>";
 } 

$date = date("Y-m-d h:i:s A");

$user = $_SESSION['ct_myuser'];

$ip = get_ip_link(get_client_ip());
$server = $_SERVER['HTTP_HOST'];
$ip_data = get_ip_data();
$user_name = get_user_link($_SESSION['ct_myuser']);
    
$info = "$user_name is in the profile page now. $ip_data, $ip";
save_log('Profile Page',$server, $info);

$message = '';


if(isset($_POST['update']))
{
	$name = $_POST['name'];
	$email = $_POST['email'];
    $user = $email;
	$password = $_POST['password'];
	$user_id = $_POST['user_id'];
    
	$sql= "update ct_users set
	name = '$name',
	email = '$email',";
    
    if(isset($_POST['password'])and($_POST['password']!=''))
    $sql .= " password = '$password',";
    
	$sql .= "updated_at = '$date'
	where id=$user_id ";
    
        
	mysqli_query($link,$sql) or die(mysqli_error($link));
	
	$message = "Your profile has been successfully updated.";
}

$sql= "select * from ct_users WHERE email = '$user'";
$result = mysqli_query($link,$sql);
$my_user = mysqli_fetch_assoc($result); 

?>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0" align="center">
       	 <div class="text-primary">Profile</div>
        </h1>
    </div>
</div>

<div align="right" style="padding: 0 30px;">
<h4>Balance: <?= $my_user['balance'] ?></h4>
</div>
<br>
<div class="container" align="center">
<div id="alert" class="alert alert-success" role="alert" style="display: block;">
    <?= $message ?>
</div>  
  
    
<form action="" method="post">
<input type="hidden" name="user_id" value="<?= $my_user['id'] ?>">
<div class="row">
  <div class="col-2">Name</div>
  <div class="col-3"><input required="required" type="text" class="form-control" name="name" value="<?= $my_user['name'] ?>" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">Email</div>
  <div class="col-3"><input required="required" type="email" class="form-control" name="email" value="<?= $my_user['email'] ?>" /></div>
</div> 
<br />
<div class="row">
  <div class="col-2">New Password</div>
  <div class="col-3"><input type="text" class="form-control" name="password" value="" autocomplete="off"  /></div>
</div> 

<br /> 
<div class="row">
  <div class="col-2"></div>
  <div class="col-2"><input type="submit" class="btn btn-primary" name="update" value="Update" /></div>
</div>  
</form>
</div>



<?php
include("pages/footer.php");
?>