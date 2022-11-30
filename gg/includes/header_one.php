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
    
      <ul class="navbar-nav dropleft">
      
         <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="what_are_fcn.php">What are FCNs ?</a>
          <a class="dropdown-item" href="indicative_pricing.php">Indicative Pricing</a>
          <a class="dropdown-item" href="portfolio_analytics.php">Portfolio Analytics</a>  
          <div class="dropdown-divider"></div>
          <?php 
         if(isset($_SESSION['gg_myuser']))
         {
		?>	
            <a class="dropdown-item" href="logout.php">Logout</a>
        <?php 
         }
		 else
		 {
		 ?>
          <a class="dropdown-item" href="login.php">Login</a>
          <?php 
         }
		 ?>  
          
          <a class="dropdown-item" href="about_us.php">About Us</a>  
        </div>
      </li>
      
  </ul>  
      
    
      
  </div>
</nav>
    

<br><br>
<main id="main">
<br><br>