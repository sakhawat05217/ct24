<?php
include("includes/header_two.php");
include("includes/functions.php");

$ref = isset($_REQUEST['ref'])?$_REQUEST['ref']:'index.php';



if(isset($_COOKIE['gg_username']))
 {
    $_SESSION['gg_myuser'] = $_COOKIE['gg_username'];
    
    if(is_admin()) $ref = 'ggadmin';
    echo "<script>window.location='".$ref."';</script>";
 }

?>

<meta name="google-signin-client_id" content="610198069749-np8149grr5fo7bv6o1778824tldqcq5d.apps.googleusercontent.com">

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Log in<span class="text-white"> to your GG account.</span></div>
        </h1>
    </div>
</div>
 
<div class="container">

      <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
         
         <div align="center">
         	<?php
          
            if(isset($_REQUEST['my_email']))
			{
				$date = date("Y-m-d");
                $email=$_REQUEST['my_email'];
                
                $check_user=check_user($email);
                
                                
                setcookie("gg_username",$email,time()+360*60*60);
                $_SESSION['gg_myuser'] = $email;
                if(is_admin()) $ref = 'ggadmin';
				echo "<script>window.location='".$ref."';</script>";
   			
			}
			else if(isset($_POST['name']))
			{
				$date = date("Y-m-d");
                
                $email=$_POST['email'];
                
                $check_user=check_user($email);
                
                if($check_user==0)
                {
                    $sql = "insert into gg_users (name,email,password,created_at) value( '" . 
                        $_POST['name'] . "', '".
                        $email . "', '".
                        $_POST['password'] . "', '".
                        $date . "') ";

                    $result = mysqli_query($link,$sql);

                    if(mysqli_error($link)) echo mysqli_error($link);
                    else echo "Your account has been successfully created.<br>You may now login.";
                    $_SESSION['gg_myuser'] = $email;
               }
               else
                {
                   echo "User already exists with this email: $email"; 
                }
                
				
			}
			else if(isset($_POST['email']))
			{
				$email = $_POST['email'];
				$password = $_POST['password'];
				
				//echo "$username : $password";
				
				$sql= 'select * from ' . ' gg_users WHERE email = "' . $email . '" and status=1';
			
				$result = mysqli_query($link,$sql) or die(mysqli_error($link));
										
				$data = mysqli_fetch_array($result);
				
							  
				  if (!$data){
					  echo 'Invalid User Email!';
				  }else{
					
					$dbpass = $data['password'];  
					
	
					if( $dbpass == $password ){
						
						if(isset($_POST['remember']))
							{
								$remember = $_POST['remember'];
								$email = $_POST['email'];
								setcookie("gg_username",$email,time()+360*60*60);
							}	
	
					 $_SESSION['gg_myuser'] = $email;
                     if(is_admin()) $ref = 'ggadmin';   
					  echo "<script>window.location='".$ref."';</script>";
	
					}else{
					  echo "Invalid password for $email.";
					}
				  }
			}
			?>
         </div>
         
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        
              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    
                  </div>
                 
                    <div class="g-signin2" data-width="300" data-onsuccess="onSignIn" data-longtitle="true"></div>
                    
                 
                    <h3>OR</h3>
                    <p class="text-center small">Enter your email & password to login</p>
                    <br>

                  <form class="row g-3 needs-validation" action="" method="post">

                   
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter your email adddress.</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    
                    <div class="col-12">
                      <a href="forgot.php">Forgot Password?</a>
                    </div>
                    
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="register.php">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div> 

<script>
function onSignIn(googleUser) {

  var profile = googleUser.getBasicProfile();
  //console.log('ID: ' + profile.getId()); 
  //console.log('Name: ' + profile.getName());
  //console.log('Image URL: ' + profile.getImageUrl());
  //console.log('Email: ' + profile.getEmail()); 
  window.location='?my_email='+ profile.getEmail()+'&my_name='+ profile.getName();  
}
</script>

<script src="https://apis.google.com/js/platform.js" async defer></script>

<?php
include("includes/footer.php");
?>