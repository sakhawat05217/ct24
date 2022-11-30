<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>CT24</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,shrink-to-fit=no">
<meta content="" name="description">
<meta content="" name="keywords">


<link href="../img/ct24.png" rel="icon">

<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap.min_two.css">
<link rel="stylesheet" href="../css/bootstrap-select.min.css">
<link rel="stylesheet" href="../css/bootstrap-select-country.min.css" />
<link rel="stylesheet" href="../css/style.css">


</head>

<body>
<?php

include("../pages/config.php");

if(isset($_SESSION['ct_myuser']))
{
	$email = $_SESSION['ct_myuser'];
	
	//echo "$username : $password";
	
	$sql= 'select * from ' . ' ct_users WHERE email = "' . $email . '"';
	
	$result = mysqli_query($link,$sql) or die(mysqli_error($link));
							
	$data = mysqli_fetch_array($result);

	if($data['role']!=0)
	{
		echo "<script>window.location='../index.php';</script>";
	}
}
else
{
	echo "<script>window.location='../login.php';</script>";
}


$uri = $_SERVER['REQUEST_URI'];
$uri_arr = explode("/",$uri);
$page_arr = explode(".",$uri_arr[count($uri_arr)-1]);
$page = $page_arr[0];

?>
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="../index.php"><img src="../img/ct24.png" alt="CT24" > </a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
        <li><a <?= ($page=='user')? 'class="active"':'' ?> href="user.php">User</a></li>
         
         <li><a <?= ($page=='provider')? 'class="active"':'' ?> href="provider.php">Provider</a></li>
         
         <li><a <?= ($page=='history')? 'class="active"':'' ?> href="history.php">History</a></li>
        
        <li><a <?= ($page=='alert')? 'class="active"':'' ?> href="alert.php">Alert</a></li>    
            
          <li><a <?= ($page=='country')? 'class="active"':'' ?> href="country.php">Country</a></li>
         
        <li><a <?= ($page=='data_collection')? 'class="active"':'' ?> href="data_collection.php">Data</a></li>    
        
        <li><a <?= ($page=='admin')? 'class="active"':'' ?> href="admin.php">Admin</a></li>     
         
        <?php 
         if(isset($_SESSION['ct_myuser']))
         {
		?>	
        <li><a href="../logout.php">Logout</a></li>
        <?php 
         }
		 else
		 {
		 ?>
          <li><a <?= ($page=='login.php')? 'class="active"':'' ?> href="../login.php">Login</a></li>
          <?php 
         }
		 ?>
          
         
          

          <!--<li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>-->
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header>
<br><br>
<main id="main" class="admin">
<br><br>