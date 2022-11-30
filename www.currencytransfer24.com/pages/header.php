<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>CT24</title>
<meta charset="utf-8" />

<meta property="og:title" content="CT-24.COM"/>
<meta property="og:image" content="img/ct24.png"/>
<meta property="og:url" content="https://www.currencytransfer24.com"/>
<meta property="og:description" content="CT24 helps Individuals and Companies access best Forex rates"/>

<meta name="author" content="Anoop Puthenveedu">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,shrink-to-fit=no">
<meta name="description" content="CT24 helps Individuals and Companies access best Forex rates" >
<meta name="keywords" content="forex exchange, money transfer, currency transfer, instant money transfer overseas, money transfer overseas, international money transfer, remittance, fast money transfer overseas, cheapest way to transfer money overseas, online money transfer overseas, best money transfer, international business payment, money transfer overseas for business, freelancers overseas, money transfer, send money, best transfer rate, best money transfer service, best rate to send money to india, best transfer rate to india, best way to send money online, compare money transfer to india, easy online money transfer, global remittance, how to transfer money online, instant money transfer online, international money transfer online, international remittance, money remittance, money to india from usa, money transfer services, money transfer services online, money transfers online, online money transfer, online money transfer comparison, online money transfer in usa, online money transfer services, remittance transfer, remittances to mexico, safe online money transfer, send money from india to usa, send money from singapore to usa, send money from usa to india, send money online, send money online free, send money online instantly, send money to bangladesh, send money to singapore, send money to india from usa, send money to europe, send money to malaysia, send money to united arab emirates, send money to singapore from usa, send money to pakistan, send money to pakistan from usa, send money to philippines from usa, sending money online, transfer money online free, transfer money worldwide online, ways to send money online, ways to transfer money online, wire transfer money online, worldwide money transfer online">
  

<link href="img/ct24.png" rel="icon">
<link rel="canonical" href="https://www.currencytransfer24.com/">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.min_two.css">
<link rel="stylesheet" href="css/bootstrap-select.min.css">
<link rel="stylesheet" href="css/bootstrap-select-country.min.css" />
<link rel="stylesheet" href="css/style.css">

 <!-- Appzi: Capture Insightful Feedback -->

<script async src="https://w.appzi.io/w.js?token=vo1zS"></script>

<!-- End Appzi -->

</head>

<body>
<?php

include("config.php");
include("functions.php");
$value = get_settings('controls','home_trans');
$home_trans = ($value==null)?0:$value; 
    
$uri = $_SERVER['REQUEST_URI'];
$uri_arr = explode("/",$uri);
$page = $uri_arr[count($uri_arr)-1];
    
    
?>
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.php"><img src="img/ct24.png" alt="CT24" > </a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        
  

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
        
       <li><a <?= ($page=='index.php')? 'class="active"':'' ?> href="index.php">Home</a></li>     
            
        <li><a <?= ($page=='alert.php')? 'class="active"':'' ?> href="alert.php">Alert</a></li>
        
        <li><a href="blog">Blog</a></li>    
            
        <?php 
         if(isset($_SESSION['ct_myuser']))
         {
		?>	
        
       <li><a <?= ($page=='profile.php')? 'class="active"':'' ?> href="profile.php">Profile</a></li>     
            
                    
        <li><a href="logout.php">Logout</a></li>
            
        <?php 
         }
		 else
		 {
		 ?>
          <li><a <?= ($page=='login.php')? 'class="active"':'' ?> href="login.php">Login</a></li>
          <?php 
         }
		 ?>
            
       <?php if($home_trans==1) { ?> 

          <li class="dropdown"><a href="#"><span>Language</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a onClick="save_controls('ms');" href="#"> Malay <img src="img/flags/singapore2.png"  class="rounded" alt="Malay" width="20px" height="15px"></a></li>  
                
              <li><a onClick="save_controls('hi');" href="#"> Hindi <img src="img/flags/india.png"  class="rounded" alt="India" width="20px" height="15px"></a></li>
                
              <li><a onClick="save_controls('bn');" href="#">Bangla <img src="img/flags/bangladesh.png"  class="rounded" alt="Bangladesh" width="20px" height="15px"></a></li>
                
              <li><a onClick="save_controls('ar');" href="#">Arabic <img src="img/flags/soudi.png"  class="rounded" alt="Soudi Arabia" width="20px" height="15px"></a></li>
                
              <li><a onClick="save_controls('zh-TW');" onClick="save_controls('bn');" href="#">Chinese <img src="img/flags/china.png"  class="rounded" alt="China" width="20px" height="15px"></a></li>
                
              <li><a onClick="save_controls('ja');" href="#">Japanese <img src="img/flags/japan.png"  class="rounded" alt="Japan" width="20px" height="15px"></a></li>
                
              <li><a onClick="save_controls('es');" href="#">Spanish <img src="img/flags/spain.png"  class="rounded" alt="Spain" width="20px" height="15px"></a></li> 
                
              <li><a onClick="save_controls('fr');" href="#">French <img src="img/flags/france.png"  class="rounded" alt="France" width="20px" height="15px"></a></li>
                
              <li><a onClick="save_controls('pt');" href="#">Portuguese <img src="img/flags/portugal.png"  class="rounded" alt="Portugal" width="20px" height="15px"></a></li>
                
              <li><a onClick="save_controls('id');" href="#">Indonesian <img src="img/flags/indonesia2.png"  class="rounded" alt="Indonesia" width="20px" height="15px"></a></li>
                
              <li><a onClick="save_controls('tr');" href="#">Turkish <img src="img/flags/turkey.png"  class="rounded" alt="Turkey" width="20px" height="15px"></a></li>  
            </ul>
          </li>
        <?php } ?>      
         
        <li><a <?= ($page=='about.php')? 'class="active"':'' ?> href="about.php">About Us</a></li>
          
          

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
<main id="main">
<br><br>