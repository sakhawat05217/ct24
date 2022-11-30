<?php
/* Authenticate user */
include("../db/dbconnect.php");

/* Redirect if postid is not set */
if(!isset($_REQUEST['message_id'])) {
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
	$message_id=$_REQUEST['message_id'];
}


/* delete from table posts */
$query="DELETE FROM blog_messages
		WHERE id='$message_id'
		";

$result=mysqli_query($conn , $query);

if($result==TRUE) {
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
	echo "Something went Wrong ! please try again later";
}

?>
