<?php
include("header.php");
include("../pages/functions.php");

$value = get_settings('controls','home_trans');
$home_trans = ($value==null)?0:$value;

?>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Controls Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="alert alert-success text-center" role="alert">
  <?php
  if(isset($_POST['save']))
  {
     $ctr_name=$_POST['ctr_name'];
     $ctr_value=$_POST['ctr_value']; 
      
     if($ctr_name!="")
     {
         add_settings('controls',$ctr_name,$ctr_value,'');
         
         switch($ctr_name)
         {
             case 'home_trans': $home_trans = $ctr_value; break;
         }
         
         
         echo("Successfully Saved.");
     }
  }
  ?>
</div>


<br>

<form method="post" action="">
    
    <input name="ctr_name" id="ctr_name" type="hidden" value="" >
    
    <input name="ctr_value" id="ctr_value" type="hidden" value="0" >

    <div class="container text-center">

       <div class="row align-items-start">

            <div class="col">
              <h4>Enable translation in home page</h4>
            </div>

            <div class="col">

                <div class="form-check form-switch">
                    
                    <input type="hidden" value="<?= $home_trans ?>" id="home_trans">

                    <h4> <input <?= ($home_trans>0)? 'checked':'' ?> onClick="set_value('home_trans')"  class="form-check-input" type="checkbox" role="switch" > </h4>

                </div>

            </div>

        </div>
        
        <br><br>
        
        <input type="submit" class="btn btn-primary" name="save" value="Save">

    </div>

</form>    
<?php
include("footer.php");
?>

<script>
function set_value(ctr_name)
    {
        ctr_value = $('#'+ctr_name).val();
        ctr_value = parseInt(ctr_value);
        if(ctr_value>0) ctr_value = 0;
        else ctr_value = 1;
        
        $('#ctr_name').val(ctr_name);
        $('#ctr_value').val(ctr_value);
        $('#'+ctr_name).val(ctr_value); 
    }
</script>
