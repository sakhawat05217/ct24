<?php
include("includes/header_two.php");
include("includes/functions.php");
?>

<div class="container">
 
<div class="card" style="background-color: #E2F0D9;">
  <div class="card-body">
    FCN
  </div>
</div>
    
<br>
    
<div class="row">
    
    <div class="col-lg-3">Select Underlying GG</div>

    <div class="col-lg-2">
     <select class="custom-select">
        <option value=""></option>
      </select>
    </div>
</div> 
<br>    
<div class="clearfix">
  <button onClick="window.location.href='indicative_pricing_continue.php';" class="btn btn-outline-success float-left" type="button">Continue</button>   
  <button onClick="window.location.href='summary.php';" class="btn btn-outline-success float-right" type="button">Summary</button>  
</div>  

</div>


<?php
include("includes/footer.php");
?>