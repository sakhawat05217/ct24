<?php
	include_once("bootstrap_cdn.php");
?>

<!-- POSTS -->
<br />
<div class="container">
		<div class="row">
			<div class="col-xl">

			<div class="panel panel-default">
				<!-- TITLE -->
		  		<div class="panel-heading">
		    		<h3 class="panel-title">
		    			<a href=<?php echo "post.php?id="; echo $id; ?> ><?php echo $title; ?></a>
		    		</h3>
		  		</div>


		  		<!-- FOOTER-->
		  		<div class="panel-footer">
						<span class="col-xl-3">
				  		
                            <img alt="User Pic" src="<?= $pic_path ?>" class="img-circle profile_pic">
                            <a href=<?php echo "../users/view.php?user=".$author; ?> >
				  			<?php 
                            $my_author = explode("@",$author);
    
                            echo $my_author[0];
                            
                            ?>
				  			</a>
					</span>

						<!-- views -->

						<span class="col-xl-2">

							<?php
								 if(isset($views)) {
									 echo ", Views:"." ".$views;
								 }
							?>
						</span>

						<!-- time -->
		  			<span class="col-xl-2">
							 <?php echo ", Date:"." ". date("m-d-Y",strtotime($time)) ?>
						</span>


			  			<?php
			  				$delete_post_link='../posts/delete_post.php?postid='.$id;
							if(isset($_SESSION['username']) ) {
								if($_SESSION['username']==$author || $_SESSION['usertype']=='admin') {
									echo "
									<span class='pull-right'>
									<a href='update.php?id=$id'  type=\"button\" class=\"btn btn-sm btn-default\">
										<i class=\"glyphicon glyphicon-edit\"></i>
									</a>

									<a href=$delete_post_link type=\"button\" class=\"btn btn-sm btn-default\">
										<i class=\"glyphicon glyphicon-remove\"></i>
									</a>
									</span>
									";
								}
							}
						?>

		  		</div>

			<!-- comments -->
			<?php
					if(isset($_REQUEST['id'])) {
							include("../posts/comments.php");
							if(isset($_SESSION['username']))
									include("../include/commentform.php");
					}
			?>

			</div>
				<!-- end of panel -->
		</div>

		</div>
</div>
<br />