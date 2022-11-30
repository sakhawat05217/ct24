<?php
 $dir = $_REQUEST['zipdir'];
 $mydir = $_REQUEST['mydir'];
 
 $destination = $dir . ".tar.gz";
 $source = $dir;
 
 system("tar -czvf $destination $source",$return_value);
 if($return_value==0)
 {
	 echo "<script>alert('$destination has been created succefully.');
	 window.location.href='index.php?dir=". $mydir . "'
	 </script>";
 }
 else {echo "Error! System return code: " . $return_value;}
?>