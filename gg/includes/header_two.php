<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>GG</title>
<meta charset="utf-8" />

<meta property="og:title" content="GG"/>
<meta property="og:image" content=""/>
<meta property="og:url" content=""/>
<meta property="og:description" content=""/>

<meta name="author" content="Anoop Puthenveedu">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,shrink-to-fit=no">
<meta name="description" content="" >
<meta name="keywords" content="">
  

<!--<link href="img/ct24.png" rel="icon">-->

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

</head>

<body>
<?php

include("config.php");
$uri = $_SERVER['REQUEST_URI'];
$uri_arr = explode("/",$uri);
$page = $uri_arr[count($uri_arr)-1];
   
?>
    
    
    
 <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">GG</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
    </ul>
    
      <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
     
      <?php 
         if(isset($_SESSION['gg_myuser']))
         {
		?>	
        
        <li class="nav-item <?= ($page=='logout.php')? 'active':'' ?>">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>           

            
        <?php 
         }
		 else
		 {
		 ?>
          <li class="nav-item <?= ($page=='login.php')? 'active':'' ?>">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <?php 
         }
		 ?>    
         
      <li class="nav-item <?= ($page=='about_us.php')? 'active':'' ?>">
        <a class="nav-link" href="about_us.php">About Us</a>
      </li>

    </ul>  
      
    
      
  </div>
</nav>
    

<br><br>
<main id="main">
<br><br>