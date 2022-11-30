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
    <div class="col-lg-3">Solve for</div>

    <div class="col-lg-2">
     <select class="custom-select">
        <option value="Coupon">Coupon</option>
        <option value="Strike">Strike</option>
        <option value="Barrier">Barrier</option>
        <option value="Autocall Barrier">Autocall Barrier</option>
        <option value="Fees">Fees</option> 
      </select>
    </div>

</div> 

<br>    
<div class="clearfix">
  <button onClick="window.location.href='strike.php';" class="btn btn-outline-success float-left" type="button">Continue</button>   
</div>
    
</div>


<?php
include("includes/footer.php");
?>