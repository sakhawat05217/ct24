<?php

/* SHOWS MOST VIEWED POSTS */

include("../include/url_posts.php");
include("../db/dbconnect.php");
include_once("../include/algos.php");


	$query="SELECT *
      FROM blog_user_post , blog_posts
      WHERE blog_user_post.postID=blog_posts.postID
      ORDER BY postViews DESC
      ;
			";

	$result=mysqli_query($conn , $query);

  if($result==false) {
    echo "problem fetching posts";
  } else {
      if(mysqli_num_rows($result)) {
        while($post=mysqli_fetch_assoc($result)) {
          /* set variables */
          $id=$post['postID'];
          $title=$post['postTitle'];
          $desc=$post['postDesc'];
          $tags=$post['postTag'];
          $author=$post['postAuthor'];
          $time=$post['postTime'];
					$views=showViews($id,$author);
          $shortpost=1;  /* short post with read more  */
          
         $user_query="SELECT *  FROM blog_users WHERE username='$author' ";
        $user_result=mysqli_query($conn , $user_query);
        $my_user=mysqli_fetch_assoc($user_result);
       @$user_pic = $my_user['img_path'].$my_user['img'];
       @$pic_path = empty($user_pic)?'../img/profile.jpg':$user_pic;
            
          include('../include/frame_post.php');

        }
      }
  }
include_once("../include/footer.php");
?>
