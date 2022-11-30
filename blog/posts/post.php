<?php

include("../include/url_posts.php");
include_once("../include/algos.php");

	/* post.php?id=2 */
	if(isset($_REQUEST['id'])) {
		$id=$_REQUEST['id'];

		$query="SELECT * FROM blog_posts WHERE postID='$id'";
		$result=mysqli_query($conn , $query);

		if($post=mysqli_fetch_assoc($result)) {
				$id=$post['postID'];
				$title=$post['postTitle'];
				$desc=$post['postDesc'];
				$tags=$post['postTag'];
				$author=$post['postAuthor'];
				$time=$post['postTime'];
				$shortpost=0;
				/* increament view by 1 */
				$views=increament_views($id, $author);
            
            $user_query="SELECT *  FROM blog_users WHERE username='$author' ";
            $user_result=mysqli_query($conn , $user_query);
            $my_user=mysqli_fetch_assoc($user_result);
            @$user_pic = $my_user['img_path'].$my_user['img'];
            @$pic_path = empty($user_pic)?'../img/profile.jpg':$user_pic;
				include("../include/frame_post.php");
		}
	}

		/* post.php?tags=dp */
	if(isset($_REQUEST['tags'])) {
		$tag=$_REQUEST['tags'];

		$query="SELECT * FROM blog_posts WHERE postTag='$tag'";
		$result=mysqli_query($conn , $query);

		if(mysqli_num_rows($result) > 0) {
			while($post=mysqli_fetch_assoc($result)) {
				$id=$post['postID'];
				$title=$post['postTitle'];
				$desc=$post['postDesc'];
				$tags=$post['postTag'];
				$author=$post['postAuthor'];
				$time=$post['postTime'];
                
                $user_query="SELECT *  FROM blog_users WHERE username='$author' ";
                $user_result=mysqli_query($conn , $user_query);
                $my_user=mysqli_fetch_assoc($user_result);
                $user_pic = $my_user['img_path'].$my_user['img'];
                $pic_path = empty($user_pic)?'../img/profile.jpg':$user_pic;


				include("../include/frame_post.php");
			}

		}

	}

	/* post.php?user=qt */
if(isset($_REQUEST['user'])) {
	$user=$_REQUEST['user'];

	$query="SELECT * FROM blog_posts WHERE postAuthor='$user'";
	$result=mysqli_query($conn , $query);

	if(mysqli_num_rows($result) > 0) {
		while($post=mysqli_fetch_assoc($result)) {
			$id=$post['postID'];
			$title=$post['postTitle'];
			$desc=$post['postDesc'];
			$tags=$post['postTag'];
			$author=$post['postAuthor'];
			$time=$post['postTime'];
			$shortpost=0;  /*  Full post with without read more */
            
            $user_query="SELECT *  FROM blog_users WHERE username='$author' ";
            $user_result=mysqli_query($conn , $user_query);
            $my_user=mysqli_fetch_assoc($user_result);
            $user_pic = $my_user['img_path'].$my_user['img'];
            $pic_path = empty($user_pic)?'../img/profile.jpg':$user_pic;
            
			include("../include/frame_post.php");
		}

	}

}
include_once("../include/footer.php");
?>
