<?php
include("includes/header_one.php");
include("includes/functions.php");
?>

<div class="container">
 
<div class="card" style="background-color: #E2F0D9;">
  <div class="card-body">
    FCN - Pricing result
  </div>
</div>

    <br>

    
    <div class="row">
        <div class="col-lg-2">Underlying GG</div>
        <div class="col-lg-4">  
          
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Google">
              <label class="form-check-label" for="inlineCheckbox1">Google</label>
            </div>
            
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Tesla">
              <label class="form-check-label" for="inlineCheckbox2">Tesla</label>
            </div>
            
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Exon">
              <label class="form-check-label" for="inlineCheckbox3">Exon</label>
            </div>
         
        </div>   
        
    </div>
    
    <br>
    <div class="row">
        <div class="col-lg-2">Maturity</div>
        <div class="col-lg-2"><input class="form-control" type="text"></div>
    </div>
    
    <br>
    <div class="row">
        <div class="col-lg-2">Coupon</div>
        <div class="col-lg-2"><input class="form-control" type="text"></div>
    </div>
    
    <br>
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-2"><button onClick="window.location.href='tell_me_more.php';" class="btn btn-outline-success" type="button">Tell me more</button></div>
    </div>
   
    
</div>


<?php
include("includes/footer.php");
?>