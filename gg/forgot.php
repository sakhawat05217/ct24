<?php
include("includes/header_two.php");
?>

 
<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Request<span class="text-white">  a new password.</span></div>
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
				$password = bin2hex(random_bytes(3));
				
				//echo "$username : $password";
				
				$sql= 'select * from ' . ' gg_users WHERE email = "' . $email . '"';
			
				$result = mysqli_query($link,$sql) or die(mysqli_error($link));
										
				$data = mysqli_fetch_array($result);
							  
				  if ($data===null)
				  {
					  echo 'Invalid User Email!';
				  }
				  else
				  {
					  $sql = "update gg_users set password = '" . $password . "' where  email = '". $email."'";
			
						$result = mysqli_query($link,$sql) or die(mysqli_error($link));
						$msg ="Your new password is: $password"."\r\n"."Please go to this link to reset your password $home_page/reset.php";
						mail($email,"GG – New password",$msg);
						
						echo "Your password has been successfully reset.<br>Please check your email for details.";
				  }
			}
			?>
         </div>
         
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        
              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Request a new password</h5>
                    <p class="text-center small">Please enter the email you signed up with and we will send you instructions on how to obtain a new password.</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="post">

                   
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter your email adddress.</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Request a new password</button>
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
include("includes/footer.php");
?>