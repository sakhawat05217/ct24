
<div class="container">
      <div class="row">
          <div class="col-lg-2" >
          </div>

        <div class="col-lg-8" >


          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"> Profile View</h3>
            </div>

           <?php
            $user_pic = $row['img_path'].$row['img'];
            $pic_path = empty($user_pic)?'../img/profile.jpg':$user_pic;
            ?>
            <div class="panel-body">
              <div class="row">
                  
                  <div class="col-lg-2" >
                  </div>

                <div class="col-lg-8 " align="center">
                    
                    <img id="user_pic" alt="User Pic" src="<?= $pic_path ?>" class="img-circle img-responsive">
                    
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Name:</td>
                        <td><?= $row['firstname'] ?></td>
                      </tr>
                        <tr>
                          <td>Email:</td>
                          <td><?= $row['emailid'] ?></td>
                        </tr>
                        
                        <tr>
                          <td></td>
                          <td><a href=<?php echo "../posts/post.php?user=".$_REQUEST['user']; ?> class="btn btn-default">View All Posts</a></td>
                        </tr>


                    </tbody>
                  </table>

                  

                </div>
              </div>
            </div>
 
          </div>
        </div>
      </div>
  </div>
