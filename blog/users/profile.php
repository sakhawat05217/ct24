<?php
include("../../pages/config.php");
            
include("../include/url_users.php");

if(!isset($_REQUEST['user'])) {
	header('Location:../index.php');
} 
else {
	$user=$_REQUEST['user'];
}

if($_REQUEST['user']!=$_SESSION['username']) 
{
    header('Location:../index.php');
}


if(isset($_POST['update_profile']))
{
    echo '<div id="alert" class="alert alert-success text-center" role="alert">';   
    
    $firstname = $_POST['firstname'];
    $emailid  = $_POST['emailid']; 
    $user_id  = $_POST['user_id'];
    $delete_pic  = $_POST['delete_pic'];

    $query="update blog_users
        set firstname = '$firstname', ";
    if($delete_pic==1)
    {
        $img_query="SELECT * FROM blog_users WHERE id=$user_id ";
        $img_result=mysqli_query($conn , $img_query );
        $img_row=mysqli_fetch_assoc($img_result);
        $pic_dir = '../img/users/'.$user_id;
        @unlink($pic_dir.'/'.$img_row['img']);
        $query .=" img = '', img_path = '', ";
    }
    else if($_FILES['profile_pic']['name']!='')
    {
        
        $img_query="SELECT * FROM blog_users WHERE id=$user_id ";

        $img_result=mysqli_query($conn , $img_query );
        $img_row=mysqli_fetch_assoc($img_result);
        
        $img = $_FILES['profile_pic']['name'];
        $pic_dir = '../img/users';
        if(!is_dir($pic_dir)) mkdir($pic_dir, 0777);
        
        $pic_dir = '../img/users/'.$user_id;
        if(!is_dir($pic_dir)) mkdir($pic_dir, 0777);
        
        @unlink($pic_dir.'/'.$img_row['img']);
        
        move_uploaded_file($_FILES['profile_pic']['tmp_name'],$pic_dir.'/'.$img);
        
        $img_path = $home_page.'/blog/img/users/'.$user_id.'/'; 
        
        //$img_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/blog/img/users/'.$user_id.'/'.$img;
        
        $query .=" img = '$img', img_path = '$img_path', ";
    }
    
    $query .=" emailid ='$emailid'	WHERE id=$user_id";
        

    $result=mysqli_query($conn , $query);

    if($result==TRUE) 
    {
         echo "Your profile has been successfully updated.";
    } 
    else 
    {
         echo "Something went Wrong! Please try again later.";
    }
    
    echo '</div>';    
}


/* fetch user detail */
$query="SELECT *
		FROM blog_users
		WHERE username='$user'
		";

$result=mysqli_query($conn , $query );

if($result) {
	if(mysqli_num_rows($result)==1) {
		while($row=mysqli_fetch_assoc($result)) {
			if($row['usertype']=='admin') {
					header("location:admin.php");
			}
			include("../include/frame_profile_detail.php");
		}
	}
} else {
	echo "failed";
}


?>
