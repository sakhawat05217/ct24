<?php
include("includes/header_two.php");
include("includes/functions.php");
?>

<div class="container">
 
<div class="card" style="background-color: #E2F0D9;">
  <div class="card-body">
    FCN Quiz
  </div>
</div>
    
<br>
<p>Q1. You enter a FCN with APPlE, MCSFT and Google as Underlying GG. At maturity, if Apple is 80%, MCSFT is 90% and Google is 60%. Which stock will get delivered to you?</p>

<br>
    
<div class="row">
    <div class="col-lg-2">
     <select class="custom-select">
        <option value="Apple">Apple</option>
        <option value="MCSFT">MCSFT</option>
        <option value="Google">Google</option>
      </select>
    </div>
</div> 
<br>    
<div class="clearfix">
  <button onClick="window.location.href='indicative_pricing_continue.php';" class="btn btn-outline-success float-right" type="button">Continue</button>  
</div>  

</div>


<?php
include("includes/footer.php");
?>