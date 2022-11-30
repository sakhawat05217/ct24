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
    <div class="col-lg-2">Underlying GG</div>

</div>    
    
<br>
<div class="row">
    <div class="col-lg-3">Maturity</div>
    <div class="col-lg-2">Currency</div>
</div>   
    
<br>
    
<div class="row">
    <div class="col-lg-3">Frequency Solve for</div>

    <div class="col-lg-2">
     <select class="custom-select">
        <option value="Coupon">Coupon</option>
        <option value=""></option>
      </select>
    </div>

</div>

<br>
<div class="row">
    <div class="col-lg-3">Strike</div>
    <div class="col-lg-2">EKI</div>
</div>
    
<br>
<div class="row">
    <div class="col-lg-3">Autocall Barrier</div>
    <div class="col-lg-2">Non-Call period</div>
</div>
    
<br>
<div class="row">
    <div class="col-lg-3">Observation type</div>
    <div class="col-lg-2">
     <select class="custom-select">
        <option value="Fees">Fees</option> 
        <option value="Coupon">Coupon</option>
      </select>
    </div>
</div>    
    
    
</div>


<?php
include("includes/footer.php");
?>