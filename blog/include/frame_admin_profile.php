
<div class="container">
      <div class="row">

        <div class="col-lg-12" >


          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"> Profile </h3>
            </div>
       <form method="post" enctype="multipart/form-data" action="admin.php"> 

           <input type="hidden" name="user_id" value="<?= $admin_row['id']?>">
           <input type="hidden" id="delete_pic" name="delete_pic" value="0">
           <?php
            $user_pic = $admin_row['img_path'].$admin_row['img'];
            $pic_path = empty($user_pic)?'../img/profile.jpg':$user_pic;
            ?>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-3 " align="center">
                  <img id="user_pic" alt="User Pic" src="<?= $pic_path ?>" class="img-circle img-responsive">
                   
                    <input onChange="$('#user_pic').attr('src', window.URL.createObjectURL(this.files[0]));" type="file" class="custom-file-input" name="profile_pic" accept=".jpe,.jpg,.jpeg,.gif,.png,.bmp,.tif,.tiff,.psd,.webp">
                    <?php
                    if($user_pic!='')
                    {
                    ?>
                    <br>
                    <button type="button" class="btn btn-danger" onClick="$('#user_pic').attr('src', '../img/profile.jpg');$('#delete_pic').val(1);$(this).hide();">Remove my pic</button>
                    <?php
                    }
                    ?>
                    
                </div>

                <div class="col-lg-9 ">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Name</td>
                        <td><input type="text" name="firstname" value="<?= $admin_row['firstname'] ?>" class="form-control"></td>
                      </tr>
                      <tr>
                        <td>User Login</td>
                        <td><?= $admin_row['username'] ?></td>
                      </tr>
                        <tr>
                          <td>Email</td>
                          <td><input type="text" name="emailid" value="<?= $admin_row['emailid'] ?>" class="form-control"></td>
                        </tr>

                      </tr>

                    </tbody>
                  </table>
                
                <button type="submit" name="update_profile" class="btn btn-default">Update</button>

                  <a href=<?php echo "../posts/post.php?user=".$user; ?> class="btn btn-default">My Posts</a>

                </div>
              </div>
            </div>
       </form>  
          </div>
        </div>
      </div>
  </div>
