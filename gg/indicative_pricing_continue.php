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
    <div class="col-lg-3">Select Maturity</div>

    <div class="col-lg-2">
     <select class="custom-select">
        <option value="3M">3M</option>
        <option value="6M">6M</option>
        <option value="1Y">1Y</option>
      </select>
    </div>
    
    <div class="col-lg-2"><input type="text" class="form-control" placeholder="Custom Date"></div>
</div> 
    
<br>
    
<div class="row">
    <div class="col-lg-3">Select Frequency of Observation</div>

    <div class="col-lg-2">
     <select class="custom-select">
        <option value="Weekly">Weekly</option>
        <option value="Monthly">Monthly</option>
        <option value="Quarterly">Quarterly</option>
      </select>
    </div>
    
</div>     

<br>    
<div class="clearfix">
  <button onClick="window.location.href='solve.php';" class="btn btn-outline-success float-left" type="button">Continue</button>   
</div>
    
</div>


<?php
include("includes/footer.php");
?>