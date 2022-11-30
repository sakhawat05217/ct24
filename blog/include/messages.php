<?php

if(!isset($_SESSION['username'])){
	header('Location:../index.php');
}
else if($_SESSION['usertype']!='admin') {
  header('Location:../index.php');
}
else {
	$user=$_SESSION['username'];
}

/* fetch user detail */
$query="SELECT * FROM blog_messages ORDER BY id DESC";

$result=mysqli_query($conn , $query );

echo "
<table class='table'>
    <tr>
      <th>Name </th>
      <th>Email</th>
      <th>Message </th>
      <th>Time</th>
      <th>Action</th>
    </tr>

<tbody>
";

if($result) {

	if(mysqli_num_rows($result)>0) {
		while($row=mysqli_fetch_assoc($result)) {
			//include("../include/frame_profile_detail.php");
      echo "<tr>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['message']."</td>";
        echo "<td>".$row['time']."</td>";
        $delete_message='../include/delete_message.php?message_id='.$row['id'];
        echo "<td><a href=$delete_message ><button type=\"button\" class=\"btn btn-danger\">Delete</button></a></td>";    
      echo "</tr>";

    }
    echo "
    </tbody>
  </table>
   ";

  }
} else {
	echo "failed";
}

?>
