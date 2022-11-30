<?php 
session_start();
$ref = $_REQUEST['ref'];

if($ref=='msql') $ref='m/sql.php';
else if($ref=='pdosql') $ref='p/sql.php';
else $ref=$ref;

//echo $ref;
//exit; 
$my_main_path = $_SERVER['SCRIPT_FILENAME'];
$my_main_path = str_replace("login.php","",$my_main_path );

foreach(file($my_main_path.'p.db') as $line) 
{
   $file_data[] = $line;
}
$file_zuser = $file_data[0];
$file_zpass = $file_data[1];
//echo $file_zuser . ": " . $file_zpass;
//exit();

 if(isset($_COOKIE['muser']))
 {
  $_SESSION['muser'] = $_COOKIE['muser'];
  echo "<script>window.location='../". $ref ."';</script>";
 }
?>

<title>Login</title>

<div style="margin-left: 2%" align="center">

    <div class='info' align="center">
        <?php 
         
        if(isset($_POST['login']))  //checking login information
        {
            
			$username = $_POST['username'];
            $password = $_POST['password'];
			
						  
			  if (trim($file_zuser) != md5(trim($username))){
				  echo 'Invalid User Name / Password!';
			  }else{

				if( trim($file_zpass) == md5(trim($password)) ){
					
					if(isset($_POST['remember']))
						{
							$remember = $_POST['remember'];
							$username = $_POST['username'];
							setcookie("muser",$username,time()+360*60*60);
							//echo $_COOKIE['username'];
						}	

				  $_SESSION['muser'] = $username;
				  echo "<script>window.location='../". $ref ."';</script>";

				}else{
				  echo "Invalid password for $username.";
				}
			  }
			  
		}
	
        
        ?>
    </div><br />
<!-- Login from -->
    <form name="login" action="" method="post">
        <table>
        <tr>
         <td><b>User Name</b></td> <td>:</td>
         <td><input type="text" name="username" required='required'  size="30" /></td>
        </tr>
        
        <tr>
         <td><b>Password</b></td> <td>:</td>
         <td><input type="password" name="password" required='required'  size="30" /></td>
        </tr>
        
        <tr>
         <td></td> <td></td>
         <td><input type="checkbox" name="remember" checked="checked" /> <b>Remember Me</b></td>
        </tr>
        
        <tr align="center"><td colspan="3"><input type="submit" class="button1" name="login" value="Login" />
        </td></tr>
       </table> 
        </form> 
</div>