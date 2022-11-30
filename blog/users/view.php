<?php
include("../../pages/config.php");
            
include("../include/url_users.php");


$user=$_REQUEST['user'];
/* fetch user detail */
$query="SELECT *
		FROM blog_users
		WHERE username='$user'
		";

$result=mysqli_query($conn , $query );

if($result) {
	if(mysqli_num_rows($result)==1) {
		while($row=mysqli_fetch_assoc($result)) {
			
			include("../include/frame_profile_view.php");
		}
	}
} else {
	echo "failed";
}


?>
