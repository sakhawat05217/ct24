<?php
 include("zip.class.php");
 $dir = $_REQUEST['zipdir'];
 $mydir = $_REQUEST['mydir'];
 
 $destination = $dir . ".zip";
 $source = $dir . "/";
 $myZipper = new Zipper($destination);
 if(!$myZipper->makeZipFile($source))
 {
	 echo "<script>alert('$destination has been created succefully.');
	 window.location.href='index.php?dir=". $mydir . "'
	 </script>";
 }
?>