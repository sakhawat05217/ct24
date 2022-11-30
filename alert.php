<?php
include("pages/header.php");

if(!isset($_SESSION['ct_myuser']))
 {
  echo "<script>window.location='login.php';</script>";
 } 


$ip = get_ip_link(get_client_ip());
$server = $_SERVER['HTTP_HOST'];
$ip_data = get_ip_data();
$user_name = get_user_link($_SESSION['ct_myuser']);
    
$info = "$user_name is in the alert page now. $ip_data, $ip";
save_log('Alert Page',$server, $info);

$date = date("Y-m-d h:i:s A");

$send_country = "SG";
$receive_country = "IN";

$send_country_arr = get_country_tk($send_country);
$send_country_tk = $send_country_arr['tk']; 
$receive_country_arr = get_country_tk($receive_country);
$receive_country_tk = $receive_country_arr['tk'];

?>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Create your <span class="text-white">free remit rate alert</span></div>
        </h1>
    </div>
</div>
<br><br>	

    <div class="">
    
    <div class="card-body example_small">
        
    <div align="center" id="alert" style="display: none;" class="alert alert-success">
         	<?php
			if(isset($_POST['max_rate']))
			{
                $user = get_user();
                //echo $user['id'];
                
                $email=$_POST['email'];
                $send_country=$_POST['send_country'];
                $receive_country=$_POST['receive_country'];
                $max_rate=$_POST['max_rate'];
                $watch_till=$_POST['watch_till'];
                
                $send_country_arr = get_country_tk($send_country);
                $send_country_tk = $send_country_arr['tk']; 
                $receive_country_arr = get_country_tk($receive_country);
                $receive_country_tk = $receive_country_arr['tk'];
                
               
                
                $my_rate = get_current_rate(1,$send_country,$receive_country);

				$sql = "insert into ct_alert (user_id,email,send_country,receive_country,max_rate, 	watch_till,send_status,created_at) value( " . 
                    $user['id'] . ", '".
					$_POST['email'] . "', '".
					$_POST['send_country'] . "', '".
					$_POST['receive_country'] . "', ".
                    $_POST['max_rate'] . ", ".
                    $_POST['watch_till'] . ", ".
                    "0, '".
					$date . "') ";
	
				$result = mysqli_query($link,$sql);
				
				if(mysqli_error($link)) echo mysqli_error($link);
				
                
                $alert=$send_country_arr['name'].' => '.$receive_country_arr['name'].', max_rate => '.$max_rate.', watch_till => '.$watch_till;
                
                $info = '<a href="user.php?p=1&li=10&sid=eid&s_str='.$user_name.'" target="_blank">'.$user_name.'</a>'." has been created an alert. $ip_data, $ip";
                save_log('Alert Created',$alert, $info);
                
                $msg_body ="<h1>Today's ". $send_country_arr['taka'] ." to ". $receive_country_arr['taka'] ." rate is: <br> 1 $send_country_tk = $my_rate $receive_country_tk </h1>"."\r\n";
				   
				   
                $to = $email;
                $subject = 'Exchange rates';
                $from = 'support@ct-24.com';

                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: '.$from."\r\n".
                    'X-Mailer: PHP/' . phpversion();

                if(mail($to, $subject, $msg_body, $headers))
                {
                    echo 'Rate alert successfully created! We have send you a sample email. <br>If email went to spam folder, please whitelist “support@ct-24.com”.<br>  You can also prevent our emails from going to spam by marking them as “Not spam”.';
                } 
                else
                {
                    echo 'Unable to send email. Please try again.';
                }
                
                echo "<script>document.getElementById('alert').style.display='block';</script>";
            }
            else if(isset($_GET['del']))
            {
                $rid = $_GET['del'];
                $sql= "delete from ct_alert where id=$rid ";
                mysqli_query($link,$sql) or die(mysqli_error($link));

                echo "Your data has been successfully deleted.";
                echo "<script>document.getElementById('alert').style.display='block';</script>";
            }
            else if(isset($_GET['sav']))
            {
                $email = $_GET['email'];
                $send_country = $_GET['send_country'];
                $receive_country = $_GET['receive_country'];
                $max_rate = $_GET['max_rate']; 
                $watch_till = $_GET['watch_till']; 
                $rid = $_GET['sav'];

                $sql= "update ct_alert set
                email = '$email',
                send_country = '$send_country',
                receive_country = '$receive_country',
                max_rate = $max_rate,
                watch_till = $watch_till
                where id=$rid ";

                mysqli_query($link,$sql) or die(mysqli_error($link));

                echo "Your data has been successfully saved.";
                echo "<script>document.getElementById('alert').style.display='block';</script>";
            }
			?>
         </div>    
        
	
    <form method="post" action="" class="form-group">
    <input type="hidden" id="send_amount" name="send_amount" value="1">
    <input type="hidden" id="receive_amount" name="receive_amount" value="">	

		<div class="row">
            <div class="col-lg-7">
					<label for="email" class="form-label">Which email should we send you the rate alert?*</label>
                      <input type="email" value="<?= $_SESSION['ct_myuser'] ?>" name="email" class="form-control" id="email" required>
			</div>
         
        </div>
        
        <br><br>
        
        <div class="row">    
            
			<div class="col-lg-12">
					<label for="send_country" class="form-label">Sending from*</label>
                      <select onChange="ShowExchangeRate()"  name="send_country" id="send_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="<?= $send_country ?>"></select>
          
                      <label for="receive_country" class="form-label">Sending to*</label>
                      <select onChange="ShowExchangeRate()" name="receive_country" id="receive_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="<?= $receive_country ?>"></select>
			</div>
            
           
        </div>
        
        <br><br>
        
        <div class="row">
            
            <div class="col-lg-5">
					
                <label for="rate" class="form-label">Current rate is: </label>
                      
                <h3 id="rate">  </h3>
					
			</div>
           
         </div>
        
        <br><br>
        
        <div class="row">
            
            <div class="col-lg-7">
				
                <label for="max_rate" class="form-label">Which rate would you like to receive alert?*</label>
                      <input type="text" value="" name="max_rate" class="form-control" id="max_rate" required>
          					
			</div>
           
        </div>
        
        <br><br>
        
        <div class="row">
            
            <div class="col-lg-5">
				<label for="watch_till" class="form-label">Watch till</label>
                      <select name="watch_till" class="form-control" id="watch_till">
                          <option value="1">1 Day</option>  
                          <option value="7">1 Week</option>
                          <option value="30">1 Month</option>
                      </select>	
          					
			</div>
          
        </div>
        
        <br><br>
        
        <div class="row">
            
            <div class="col-lg-2">
				 <button class="btn btn-primary" type="submit">Create Alert</button>
			</div>
						
	
			
		</div>
       
       </form> 
       
       </div>
        
	</div>


<?php
    $email = $_SESSION['ct_myuser'];
    $sql= "select * from ct_alert where email='$email'  order by created_at asc";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_fetch_all($result);
    //echo "<pre>";
    //print_r($data);
                             
     if(count($data)>0) 
     {    
         echo('<h1 align="center">My Previous Alert</h1><div class="card-body example container">'); 

         echo '<div class="row"><div class="col-sm-2">Email</div><div class="col-sm-3">Send Country</div><div class="col-sm-3">Receive Country</div><div class="col-sm-1">Max Rate</div><div class="col-sm-1">Watch Till</div><div class="col-sm-1">Action</div></div><br>';

        $i=1;
        foreach($data as $new_data)
        {
            $send_country = $new_data[3];
            $receive_country = $new_data[4];

            $selected_7 = '';
            $selected_30 = '';
            if($new_data[6]==7) $selected_7 = 'selected';
            else if($new_data[6]==30) $selected_30 = 'selected';

            $watch_till='<select class="form-control" id="'.$new_data[0].'_watch_till">
                              <option value="1">1 Day</option>  
                              <option value="7" '.$selected_7.'>1 Week</option>
                              <option value="30" '.$selected_30.'>1 Month</option>
                          </select>';  

            $send_country_name ='<select id="'.$new_data[0].'_send_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="'.$send_country .'"></select>';

            $receive_country_name ='<select id="'.$new_data[0].'_receive_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="'.$receive_country .'"></select>';

            echo '<div class="row">';
            echo '<div class="col-sm-2"><input id="'.$new_data[0].'_email" type="text" class="form-control" value="'.$new_data[2].'" /></div><div class="col-sm-3">'.$send_country_name.'</div><div class="col-sm-3">'.$receive_country_name.'</div><div class="col-sm-1"><input id="'.$new_data[0].'_max_rate" type="text" class="form-control" value="'.$new_data[5].'" /></div><div class="col-sm-1">'.$watch_till.'</div>';

            echo '<div class="col-sm-2"><input class="btn btn-success" type="button" value="Save" onclick="save_alert('.$new_data[0].')" /> <input type="button" class="btn btn-danger" value="Delete" onclick="delete_alert('.$new_data[0].')" /></div>';

            echo "</div><br>";
        }


        echo '</div>';
    }     
                             
?>


<script>
    
function save_alert(rid)
{
	var yn = confirm("Are you sure you want to save this data?");
	if(yn)
	{
		
		var email = $('#'+rid+'_email').val();
		var send_country = $('#'+rid+'_send_country').val();
		var receive_country = $('#'+rid+'_receive_country').val();
        var max_rate = $('#'+rid+'_max_rate').val();
        var watch_till = $('#'+rid+'_watch_till').val();
        
		window.location.href='alert.php?sav='+rid+'&email='+email+'&send_country='+send_country+'&receive_country='+receive_country+'&max_rate='+max_rate+'&watch_till='+watch_till;
		
	}
}    

function delete_alert(rid)
{
	var yn = confirm("Are you sure you want to delete this data?");
	if(yn)
	{
		window.location.href='alert.php?del='+rid;
	}
}

</script>

<?php
include("pages/footer.php");
?>