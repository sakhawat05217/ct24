<?php

/* search.php?q='dp' */

include("../include/url_posts.php");

if(isset($_POST['submit'])) {
	$q=$_POST['q'];
} else {
	printf("No search Result found");
	$q='';
}

$query="SELECT *
		FROM blog_posts
		WHERE postTitle like '%$q%' OR
					postTag like '%$q%' OR
					postDesc like '%$q%' OR
					postAuthor like '%$q%'
		";

$result=mysqli_query($conn , $query);

if(mysqli_num_rows($result)) {
	while($post=mysqli_fetch_assoc($result)) {
		$id=$post['postID'];
		$title=$post['postTitle'];
		$desc=$post['postDesc'];
		$tags=$post['postTag'];
		$author=$post['postAuthor'];
		$time=$post['postTime'];
		$shortpost=1;  /* short post with read more  */
        
        $user_query="SELECT *  FROM blog_users WHERE username='$author' ";
        $user_result=mysqli_query($conn , $user_query);
        $my_user=mysqli_fetch_assoc($user_result);
        @$user_pic = $my_user['img_path'].$my_user['img'];
        @$pic_path = empty($user_pic)?'../img/profile.jpg':$user_pic;

		include("../include/frame_post.php");
	}
}
include_once("../include/footer.php");
?>
