<?php
 $file = $_REQUEST['tarfile'];
 $mydir = $_REQUEST['mydir'];
 chdir($mydir);
 system("tar -xzvf $file",$return_value);
 //echo "tar -xzvf $file :: $return_value" ; exit();
 if($return_value==0)
 {
	 echo "<script>alert('$file has been untar succefully.');
	 window.location.href='index.php?dir=". $mydir . "'
	 </script>";
 }
 else {echo "Error! System return code: " . $return_value;}
?>