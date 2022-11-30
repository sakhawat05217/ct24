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
    <div class="col-lg-3">Autocall Barrier as %</div>
    
    <div class="col-lg-2">
     <input value="0" onchange="$('#strike_range').val(this.value);" name="strike_value" id="strike_value" type="text" class="form-control" size="6">
    </div>

    <div class="col-lg-7">
     0 <input oninput="$('#strike_value').val(this.value);" onchange="$('#strike_value').val(this.value);" type="range" id="strike_range" name="strike_range" min="0" max="100" value="0" step="1"> 100%
    </div>

</div>
    
<br>
    
<div class="row">
    <div class="col-lg-3">Autocall Observation</div>

    <div class="col-lg-2">
     <select class="custom-select">
        <option value="Continuous">Continuous</option>
        <option value="Period End">Period End</option>
      </select>
    </div>

</div> 
    
<br>
    
<div class="row">
    <div class="col-lg-3">Non-call period</div>
    
    <div class="col-lg-2">
     <input type="text" class="form-control" size="6">
    </div>

</div>    

<br>    
<div class="clearfix">
  <button onClick="window.location.href='national.php';" class="btn btn-outline-success float-left" type="button">Continue</button>   
</div>
    
</div>


<?php
include("includes/footer.php");
?>