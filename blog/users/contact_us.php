<?php
include("../include/url_users.php");
 ?>

<?php
    if (isset($_POST["submit"])) {
        $name=$_POST['name'];
        $email=$_POST['email'];
        $msg=$_POST['message'];

          $query="INSERT INTO blog_messages (name , email , message )
          VALUES (' $name' , '$email' , '$msg' )";

          $result=mysqli_query($conn , $query);

          if($result) {
            echo "Message sent successfully";
          } else {
            echo "Some error occured.... :-(";
          }
      }

      else {
          include("../include/frame_contact_us.php");
      }
include_once("../include/footer.php");
?>
