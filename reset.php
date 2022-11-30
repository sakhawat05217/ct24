<?php
include("pages/header.php");
?>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Reset<span class="text-white">  your password.</span></div>
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
				$password = $_POST['password'];
				$new_password = $_POST['new_password'];
				//echo "$username : $password";
				
				$sql= 'select * from ' . ' ct_users WHERE email = "' . $email . '" and password = "' . $password . '"';
			
				$result = mysqli_query($link,$sql) or die(mysqli_error($link));
										
				$data = mysqli_fetch_array($result);
							  
				  if ($data===null)
				  {
					  echo 'Invalid User Email or Password!';
				  }
				  else
				  {
					  $sql = "update ct_users set password = '" . $new_password . "' where  email = '". $email."'";
			
					  $result = mysqli_query($link,$sql) or die(mysqli_error($link));
					  echo "Your password has been successfully reset.";
				  }
			}
			?>
         </div>
         
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        
              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Reset password</h5>
                    <p class="text-center small">Please enter your email and a new password.</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="post">

                   
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter your email adddress.</div>
                    </div>
                    
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Current Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your current password!</div>
                    </div>
                    
                    <div class="col-12">
                      <label for="your_new_Password" class="form-label">New Password</label>
                      <input type="password" name="new_password" class="form-control" id="your_new_Password" required>
                      <div class="invalid-feedback">Please enter your new password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Reset password</button>
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