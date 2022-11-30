<?php

/* If form is submitted then authenticate it*/

include("../include/url_users.php");

if(isset($_POST['submit'])) {

	$username=$_POST['username'];
	$password=$_POST['password'];


	/* Check login  correctness*/
	$query="SELECT * FROM blog_users WHERE username='$username' AND password='$password' ";
	$result=mysqli_query($conn , $query);
	//$rows=1;

	/* query failed */
	if($result==FALSE) {
		printf("Query failed \n");
		header("location:login.php");
	}

	if(mysqli_num_rows($result) == 1) {
		$_SESSION['username']=$username;
		$_SESSION['password']=$password;
		/* user type */
		$detail=mysqli_fetch_assoc($result);
		$_SESSION['usertype']=$detail['usertype'];

		/* Redirect to current / previous page*/
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	} 
    else 
    {
		
       $query="SELECT * FROM ct_users WHERE email='$username' AND password='$password' ";
	   $result=mysqli_query($conn , $query); 
       
       if(mysqli_num_rows($result) == 1) 
       {
            $new_detail=mysqli_fetch_assoc($result);
            //echo "<pre>"; 
            //print_r($new_detail);
           $new_query="INSERT INTO blog_users (username, firstname, password, emailid)
				VALUES ('".$new_detail['email']."','".$new_detail['name']."','".$new_detail['password']."','".$new_detail['email']."')";
		   mysqli_query($conn , $new_query);
           
           $_SESSION['username']=$username;
           $_SESSION['password']=$password;
           $_SESSION['usertype']='normal';
           header('Location: ' . $_SERVER['HTTP_REFERER']);

       }
       else
       {
           echo "
		<div class=\"alert alert-danger container\" role=\"alert\">
	  <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
	  <span class=\"sr-only\">Error:</span>
	   Invalid Username or Password
		</div>";
       }
        
	}
} 
else {
			if(!isset($_SESSION['username'])) {
			echo "
			<div class=\"alert alert-danger\" role=\"alert\">
		  <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
		  <span class=\"sr-only\">Error:</span>
		   Login Again
			</div>
			";
			} else {
				header("location:../index.php");
			}
}


?>
