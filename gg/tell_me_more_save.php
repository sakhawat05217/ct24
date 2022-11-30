<?php
include("includes/header_two.php");
include("includes/functions.php");
?>

<div class="container">
 
<div class="card" style="background-color: #E2F0D9;">
  <div class="card-body">
    FCN - Pricing result
  </div>
</div>
 <br><br>   
<?php 
 if(isset($_SESSION['gg_myuser']))
 {
   $user = get_user();
   echo 'Hi '.$user['name'].', this trade has been saved in your portfolio.';
 }
 else
 {
 ?>
To add to a portfolio, please create an account.
<br>
<a href="login.php">Using google account</a>
<br>
<a href="login.php">Using facebook account</a>
<br>
<a href="register.php">Signup</a>
  <?php 
 }
 ?>     

    
</div>


<?php
include("includes/footer.php");
?>