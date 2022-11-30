<?php
include("pages/header.php");



if(!isset($_SESSION['ct_myuser']))
 {
  echo "<script>window.location='login.php';</script>";
 } 
 
$send_amount = $_POST['send_amount'];
$send_country = $_POST['send_country'];
$receive_country = $_POST['receive_country'];
?>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Email Me</div>
        </h1>
    </div>
</div>

 
<div class="container">

      <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
         
         <div align="center">
         	<?php
			if(isset($_POST['email']))
			{
				$email = $_POST['email'];
				
				//echo $email.$send_amount.$send_country.$receive_country;
				
				$send_country_arr = get_country_tk($send_country);
				$send_country_tk = $send_country_arr['tk']; 
				$receive_country_arr = get_country_tk($receive_country);
				$receive_country_tk = $receive_country_arr['tk']; 
				
				$providers = get_providers($send_amount, $send_country, $receive_country);
                
				
				$msg_body ="<h1>Compare today's ". $send_country_arr['taka'] ." to ". $receive_country_arr['taka'] ." ($send_country_tk to $receive_country_tk) find the best remittance rates</h1>"."\r\n";	
				
				$msg_body .= '<br><br>'.'<table width="100%" border="1"  cellpadding="10px">';
				
				foreach ($providers as $pd)
				   {
						$msg_body .= '<tr>';
                        $rate = $pd['rate'];
                        $fee = $pd['fee'];
                        $received_amount = $pd['received_amount'];
                        $web = $pd['web'];
                        $png_logo = $pd['png_logo'];
                        $speed = $pd['speed'];
						
						$msg_body .= '<td><img width="300px" src="'. $png_logo .'" alt="logo"></td>';
						$msg_body .= '<td>'. "Received Amount: ".$received_amount .'<br>'.$send_amount .' '. $send_country_tk .' = <h2><span style="color:#303F69">'. round(($send_amount*floatval($rate)),4) .' '. $receive_country_tk .'</span></h2><br>1 '. $send_country_tk .' = '. round(floatval($rate),4) .' '. $receive_country_tk .'<br>'. "Fee: ".$fee .'<br>'.'<br>'. "Transfers typically take ".$speed." to post to your account, excluding weekends and Federal banking holidays." .'<br>'. '</td>';
						
						$msg_body .= '<td><a href="'. $web .'" target="_blank" class="btn btn-success">Send money now</a></td>';
						
						$msg_body .= '</tr>';
						
				   }
				   
				   $msg_body .= '</table>';
				  
				   
				   //echo $msg_body;
				   //exit; 
				   
				    $to = $email;
					$subject = 'Compare exchange rates';
					$from = 'support@ct-24.com';
					 
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.$from."\r\n".
						'X-Mailer: PHP/' . phpversion();
					 
					if(mail($to, $subject, $msg_body, $headers))
					{
						echo 'Your mail has been sent successfully.';
					} 
					else
					{
						echo 'Unable to send email. Please try again.';
					}
				

			}
			?>
         </div>
         
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        
              <div class="card mb-3">

                <div class="card-body">

            
                  <form class="row g-3 needs-validation" action="" method="post">
                  
                 	<input type="hidden" name="send_country" value="<?= $send_country ?>">
                    <input type="hidden" name="receive_country" value="<?= $receive_country ?>">
                    <input type="hidden" name="send_amount" value="<?= $send_amount ?>">

                   
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" value="<?= $_SESSION['ct_myuser'] ?>" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter your email adddress.</div>
                    </div>

                    
                  
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Send Email</button>
                    </div>
                    
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>    

<?php
include("pages/footer.php");
?>