<!DOCTYPE html>
<html lang="en">
<head>
<title>CT24</title>
<meta charset="utf-8" />


</head>

<body>

<link href="../../img/ct24.png" rel="icon">

<nav class="navbar navbar-default">
  
        
    <div class="container-fluid">
      
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        
      <a href="../../index.php"><img height="35px" src="../../img/ct24.png" alt="CT24" ></a> 
            
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li><a  href="../../index.php" > 
          Home
        </a></li>
          
        <li><a href=<?php echo $posts_url; ?> >  <!--All posts-->
          All Posts
        </a></li>

        <li><a href=<?php echo $top_posts_url; ?>  >Top posts</a></li>
        <li><a href=<?php echo $contact_us_url; ?>  >Contact Us</a></li>
      </ul>

      <!--  search box  -->
         <form class="navbar-form pull-left" role="search" action=<?php echo $search_url; ?> method="post">
            <div class="input-group">
               <input type="text" class="form-control" placeholder="Search" name="q">
               <div class="input-group-btn">
                  <button type="submit" class="btn btn-default" name="submit"> 
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
               </div>
            </div>
          </form>
    <!--end of search box   -->

      <ul class="nav navbar-nav navbar-right">

       <?php
            if(!isset($_SESSION['username'])) {
                include("loginform.php");
              }
            else {
                include("userdetail.php");
              }
       ?>


      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<main id="main">
