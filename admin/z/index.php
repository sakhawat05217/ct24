<?php 
session_start(); 
//if($_SERVER['HTTP_HOST']=='localhost:8000')
 error_reporting(0);
//else
 //error_reporting(E_ALL);
ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
ini_set('max_execution_time', 600);
ini_set('memory_limit','1024M');

if(!isset($_SESSION['muser'])) echo "<script>window.location='../l/login.php?ref=z';</script>";

?>

<html>
<head><title>F</title>
<script type="text/javascript" src="script.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="right"><a href="../l/logout.php">Logout</a></div>
<div class=heads>
<form enctype="multipart/form-data"  multipart=""  action="" method="POST">

Upload a file on the current dir: 

 <input name="uploadedfile[]" type="file" multiple />
 <input type="submit" value="Upload File" name="upload_file" />
 
 
</form>

<form action="" method="post">
<input type="text" size="60" name="system_command" />
<input type="submit" value="Execute Command" name="execute_command" />
<input type="submit" formtarget="_blank" value="Open Terminal Here" name="open_terminal" />
<input type="submit" formtarget="_blank" value="New Window" name="new_window" />
</form>

<form action="" method="POST">

Create a folder: 

 <input id="folder_name" name="folder_name" type="text" style="text-align:center" size="20" value="New Folder" />
 <input type="submit" value="Create The Folder" id="create_folder" name="create_folder" />
 
 <input type="button" value="Date Folder" onClick="create_date_folder()"  />
 <input type="button" value="Refresh" onClick="window.location.href='index.php'" />
 
</form>

<?php

function reArrayFiles($file)
{
    $file_ary = array();
    $file_count = count($file['name']);
    $file_key = array_keys($file);
   
    for($i=0;$i<$file_count;$i++)
    {
        foreach($file_key as $val)
        {
            $file_ary[$i][$val] = $file[$val][$i];
        }
    }
    return $file_ary;
}

 $docname = basename(getenv('script_name'));

function fileext ($file) {
$p = pathinfo($file);
return $p['extension'];
}

function convertsize($size){

$times = 0;
$comma = '.';
while ($size>1024){
$times++;
$size = $size/1024;
}
$size2 = floor($size);
$rest = $size - $size2;
$rest = $rest * 100;
$decimal = floor($rest);

$addsize = $decimal;
if ($decimal<10) {$addsize .= '0';};

if ($times == 0){$addsize=$size2;} else
 {$addsize=$size2.$comma.substr($addsize,0,2);}

switch ($times) {
  case 0 : $mega = ' bytes'; break;
  case 1 : $mega = ' KB'; break;
  case 2 : $mega = ' MB'; break;
  case 3 : $mega = ' GB'; break;
  case 4 : $mega = ' TB'; break;}

$addsize .= $mega;

return $addsize;
}
$dir = $_GET['dir'];
$action = $_GET['action'];
$adm_user = $_POST['adm_user'];
$adm_pass = $_POST['adm_pass'];
$adm_pass_conf = $_POST['adm_pass_conf'];

/*      THE REAL STUFF BEGINS HERE     */

include "pclzip.lib.php";

chdir($dir);

$basedir = getcwd();
$mypath = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$mypath = substr($mypath,0,strpos($mypath,'/z/index.php'));
//echo "Base: " . $mypath;
//exit();
$basedir = str_replace('\\','/',$basedir);        //'

//echo $basedir; exit();

if(isset($_POST['execute_command']))
{
	$system_command = $_POST['system_command'];
	$command = system($system_command,$return_value);
	echo "<h3>Return Code: $return_value</h3>";
}
else if(isset($_POST['open_terminal']))
{
 	echo "<script>window.location.href='".$mypath."/t/index.php?dir=". $basedir . "';</script>";
}
else if(isset($_POST['new_window']))
{
 	echo "<script>window.location.href='".$mypath."/z/index.php?dir=". $basedir . "';</script>";
}
else if(isset($_POST['upload_file']))
{

   $my_files = $_FILES['uploadedfile'];

	if(!empty($my_files))
	{
		$my_files_desc = reArrayFiles($my_files);
	   
		foreach($my_files_desc as $val)
		{
			 $target_path = $basedir."/" . $val['name'];
			 
			 if(move_uploaded_file($val['tmp_name'],$target_path)) 
			 {
				 echo $val['name']. " => OK, ";
			 }
			 else
			 {
				 echo $val['name']. " => Error, ";
			 }
		}
	}
 
 
 
 
 
}
else if(isset($_POST['create_folder']))
{

 $folder_name = $_POST['folder_name'];
 $target_dir = $basedir."/".$folder_name;
 mkdir($target_dir);
}

if (is_dir($basedir)) { //show directory list

$parent = dirname($basedir);

$cur = $basedir;

while (substr($cur,0,1) == '/') {
        $cur = substr($cur,1,strlen($cur));
        $path .= '/'; }

$p_out = $path;
while (strlen($cur) > 0) {
$k = strpos($cur,'/');
if (!strpos($cur,'/')) $k = strlen($cur);
$my_cur_dir = $s = substr($cur,0,$k);
$cur = substr($cur,$k+1,strlen($cur));
$path .= $s.'/';
$p_out .= "<a href='?dir=$path'>$s</a>/";
}

echo "<br><center><div>Current dir: ".$p_out."</div>";

$my_main_path = $_SERVER['SCRIPT_FILENAME'];
$my_main_path = str_replace("index.php","",$my_main_path );
$current_path = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//echo "m: " . $my_main_path; 

if(isset($_POST['add_bookmark']))
{
	$name = $_POST['bookmark_name'];
	 
    $fp = fopen($my_main_path."bookmark.txt","a");
    fwrite($fp,$name."\n");
	fwrite($fp,$current_path."\n");
	fclose($fp);
}


$i=1;
foreach(file($my_main_path.'bookmark.txt') as $line) 
{
   if(($i%2)!=0)
    $bk_name[] = $line;
   else
    $bk_url[] = $line;
   //echo $line. "<br />";
   $i++;
}

//echo "<pre>name: "; print_r($bk_name); echo "url: " ;print_r($bk_url); 

?>

<form action="" method="post">

<input type="submit" name="add_bookmark" value="Add to bookmark">
<input style="text-align:center" type="text" id="bookmark_name" name="bookmark_name" size="20" value="New Bookmark">
<input type="button" onClick="window.open('edit_bookmark.php');" value="Edit bookmark">

<select name="load_bookmark" onChange="window.location.href=this.value">
	<?php
	 foreach ($bk_name as $k=>$v)
	 {
		 if(trim($current_path)==trim($bk_url[$k]))
		  echo '<option value="'. $bk_url[$k] . '" selected="selected">'. $v . " => " . $bk_url[$k] . '</option>';
		 else 
		  echo '<option value="'. $bk_url[$k] . '">'. $v . " => " . $bk_url[$k] . '</option>'; 
	 }
	?>

</select>

</form>



<?php

$file_count = 0;
$dir_count = 0;
$zip_count = 0;

$glob = array();
$c = 0;
if ($dh = opendir(getcwd())) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '..' && $file != '.') $glob[$c++] = $file;
        }
    closedir($dh);
    }
sort($glob);

foreach ($glob as $filename) {
	if (is_dir($filename)) 
	{
		$dir_count++;
	}
	else
	{
		$file_count++;
		if (strtolower(fileext($filename)) == 'zip')
		{
			$zip_count++;
		}
	}
}

echo "<center><div class=bigblock><div class=contents>";
echo "<div class=dirlist>";
echo "<div class='filedirtitle'>Files: $file_count, Folders: $dir_count</div>";
echo "<b><center><a href='?dir=$parent'>Parent directory</a></b></center><br>\n";


foreach ($glob as $filename) {
	if (is_dir($filename)) 
	
	{
		//ibrahim 
		//it's a directory
		echo "&nbsp;&nbsp;
		/<a href='?dir=$basedir/$filename'>$filename</a>
		<a href='zip.php?zipdir=$basedir/$filename&mydir=$basedir'>[zip, </a>	
		<a href='tar.php?zipdir=$basedir/$filename&mydir=$basedir'>tar, </a> ";
		
	?>
    
    <a target="_blank"  href='dir_info.php?basedir=<?php echo "$basedir/$filename"; ?>'>info</a>,
    
    <a onClick="chmod_me('<?php echo $filename; ?>','<?php echo $basedir; ?>')" href='#'>chmod</a>,
    <a onClick="rmdir_me('<?php echo $filename; ?>','<?php echo $basedir; ?>')" href='#'>rmdir</a>,
    <a onClick="rename_file('<?php echo $filename; ?>','<?php echo $basedir; ?>')" href='#'>rename</a>]<br /><br />
    
    <?php	
		
	}
	else //ibrahim
	//it's a file
	{
		
		$new_file_name = "New_".$filename;
		echo "&nbsp;&nbsp;
		/$filename
		<a href='?myfile=$filename&basedir=$basedir'>[zip </a>, 
		<a href='tar.php?zipdir=$basedir/$filename&mydir=$basedir'>tar, </a>
		";
		
		?>
        <a target="_blank"  href='file_edit.php?f_name=<?php echo $filename; ?>&basedir=<?php echo $basedir; ?>'>edit</a>,
        
        <a target="_blank"  href='file_info.php?f_name=<?php echo $filename; ?>&basedir=<?php echo $basedir; ?>'>info</a>,
        
        <a onClick="rename_file('<?php echo $filename; ?>','<?php echo $basedir; ?>')" href='#'>rename</a>,
        
        <a onClick="copy_file('<?php echo $filename; ?>','<?php echo $basedir; ?>')" href='#'>copy</a>,
         
		<a onClick="delete_me('<?php echo $filename; ?>','<?php echo $basedir; ?>')" href='#'>delete</a>]<br /><br />	
		<?php
	}
}

echo "<br>\n&nbsp;&nbsp;<a href='?allfile=1&basedir=$basedir'>[zip all files, </a> ";
echo "<br>\n&nbsp;&nbsp;<a href='?allfolder=1&basedir=$basedir'>zip all folders]</a><br>\n";
//ibrahim

if($_GET['del'])
{
	
    $myfile = $_GET['delete_file'];
	$mydir = $_GET['basedir'];
	unlink($mydir."/".$myfile);
	
	$new_location = "index.php?dir=$mydir";
	echo "<script>window.location.href='".$new_location."';</script>";
}
else if($_GET['chmod_me'])
{
	
    $myfile = $_GET['rename_file'];
	$mydir = $_GET['basedir'];
	$new_mod = $_GET['new_mod'];
	chmod($mydir."/".$myfile,$new_mod);
	
	$new_location = "index.php?dir=$mydir";
	echo "<script>window.location.href='".$new_location."';</script>";
}
else if($_GET['rmdir_me'])
{
	
    $myfile = $_GET['rmdir_file'];
	$mydir = $_GET['basedir'];
	rmdir($mydir."/".$myfile);
	$new_location = "index.php?dir=$mydir";
	echo "<script>window.location.href='".$new_location."';</script>";
}
else if($_GET['rename'])
{
	
    $myfile = $_GET['rename_file'];
	$mydir = $_GET['basedir'];
	$my_new_name = $_GET['new'];
	rename($mydir."/".$myfile,$mydir."/".$my_new_name);
	
	$new_location = "index.php?dir=$mydir";
	echo "<script>window.location.href='".$new_location."';</script>";
}
else if($_GET['copy_file'])
{
	
    $myfile = $_GET['file_name'];
	$new_loc = $_GET['new_loc'];
	$basedir = $_GET['basedir'];

	copy($basedir."/".$myfile,$new_loc."/".$myfile);
	
	$new_location = "index.php?dir=$basedir";
	echo "<script>window.location.href='".$new_location."';</script>";
}
else if($_GET['myfile'])
{
	
    $myfile = $_GET['myfile'];
	$mydir = $_GET['basedir'];
	$myarr = explode(".",$myfile);
	$mynewfile = $myarr[0];
	echo "my: $myfile <br /> $mynewfile";
	$myzip = new ZipArchive;
	if ($myzip->open("$mydir/$mynewfile.zip", ZipArchive::CREATE) === TRUE)
	{
		// Add files to the zip file
		$myzip->addFile("$mydir/$myfile");
		
		$myzip->close();
	}
	$new_location = "index.php?dir=$mydir";
	echo "<script>window.location.href='".$new_location."';</script>";
}

else if($_GET['allfile'])
{
	
	$myzip = new ZipArchive;
	$mydir = $_GET['basedir'];
	if ($myzip->open("$mydir/All_Files.zip", ZipArchive::CREATE) === TRUE)
	{
		
		
	 if ($handle = opendir($mydir))
		{
			// Add all files inside the directory
			while (false !== ($entry = readdir($handle)))
			{
				if ($entry != "." && $entry != ".." && !is_dir("$mydir/" . $entry))
				{
					$myzip->addFile("$mydir/" . $entry);
				}
			}
			closedir($handle);
		}
		
		$myzip->close();
	}
	
	$new_location = "index.php?dir=$mydir";
	echo "<script>window.location.href='".$new_location."';</script>";
}
else if($_GET['allfolder'])
{
	 include("zip.class.php");
	
	
	$myzip = new ZipArchive;
	$mydir = $_GET['basedir'];
	if ($myzip->open("$mydir/RootFiles.zip", ZipArchive::CREATE) === TRUE)
	{
		
		
	 if ($handle = opendir($mydir))
		{
			
			while (false !== ($entry = readdir($handle)))
			{
				if ($entry != "." && $entry != ".." and is_dir("$mydir/" . $entry) )
				{
					 // Making all folders to zip
					 $dir = "$mydir/" . $entry;
					 $destination = $dir . ".zip";
					 $source = $dir . "/";
					 $myZipper = new Zipper($destination);
					 $myZipper->makeZipFile($source);
					
				}
				else if ($entry != "." && $entry != ".." and !is_dir("$mydir/" . $entry) )
				{
					// Add Root Files
					$myzip->addFile("$mydir/" . $entry);
				}
				 
			}
			closedir($handle);
		}
		
		$myzip->close();
	}
	
	
	$myzip = new ZipArchive;
	if ($myzip->open("$mydir/All_Folders.zip", ZipArchive::CREATE) === TRUE)
	{
	$myzip->addFile("$mydir/RootFiles.zip");	
		
	 if ($handle = opendir($mydir))
		{
			//Adding all folder.zip to one file
			while (false !== ($entry = readdir($handle)))
			{
				if ($entry != "." && $entry != ".." && is_dir("$mydir/" . $entry))
				{
					$myzip_file = "$mydir/" . $entry . ".zip";
					$myzip->addFile($myzip_file);
					
					
				}
			}
			closedir($handle);
		}
		
		$myzip->close();
	}
	
	//erasing all folder.zip
	
	unlink("$mydir/RootFiles.zip");
	if ($handle = opendir($mydir))
		{
		while (false !== ($entry = readdir($handle)))
				{
					if ($entry != "." && $entry != ".." && is_dir("$mydir/" . $entry))
					{
						$myzip_file = "$mydir/" . $entry . ".zip";
						unlink($myzip_file);
						
					}
				}
		}
	
	$new_location = "index.php?dir=$mydir";
	echo "<script>window.location.href='".$new_location."';</script>";
}


echo "</div><div class=filelist>";
echo "<div class='filedirtitle'>ZIP files: $zip_count</div>";
$filez = $glob;
reset($filez);
if (sizeof($filez) > 0)
foreach ($filez as $filename) {

if (strtolower(fileext($filename)) == 'zip')
{
	if (is_file($filename)) {
		
		$size = convertsize(filesize($filename));
		
	echo "&nbsp;&nbsp;<a href='?dir=$basedir&unzip=$filename&action=view' title='View archive contents'>$filename [view]</a> <a href='?dir=$basedir&unzip=$filename&action=unzip' title='Extract files from archive'><font color=red>[Unzip]</font></a>
	<a href='$mypath/$filename' title='Download archive'><font color=red>[Download, $size]</font></a>
	<br>";
	}
}

else if (strtolower(fileext($filename)) == 'gz')
{
	if (is_file($filename)) {
		
		$size = convertsize(filesize($filename));
		
	echo "&nbsp;&nbsp;$filename <a href='untar.php?tarfile=$basedir/$filename&mydir=$basedir'><font color=red>[Untar]</font></a>
	<a href='$mypath/$filename' title='Download archive'><font color=red>[Download, $size]</font></a>
	<br>";
	}
}

else if (strtolower(fileext($filename)) == 'bz2')
{
	if (is_file($filename)) {
		
		$size = convertsize(filesize($filename));
		
	echo "&nbsp;&nbsp;$filename <a href='?dir=$basedir&bzip=$filename&action=bz2' title='Extract files from archive'><font color=red>[Unzip]</font></a>
	<a href='$mypath/$filename' title='Download archive'><font color=red>[Download, $size]</font></a>
	<br>";
	}
}

}


echo "</div></div><br>";
}

$bzip = $_GET['bzip'];
$dir = $_GET['dir'];
$bz2 = $dir."/".$bzip;
 if ($_GET[action] == 'bz2')
	 {
     
	 exec("tar -jxvf $bz2");
	 //echo $bz2;
	 }
	 
	 
$unzip = $_GET['unzip'];

if (is_file($unzip)) {       //unzipping...

$zip = new PclZip($unzip);
if (($list = $zip->listContent()) == 0) {die("Error : ".$zip->errorInfo(true));  }

/*
File 0 / [stored_filename] = config
File 0 / [size] = 0
File 0 / [compressed_size] = 0
File 0 / [mtime] = 1027023152
File 0 / [comment] =
File 0 / [folder] = 1
File 0 / [index] = 0
File 0 / [status] = ok
*/

//calculate statistics...
  for ($i=0; $i<sizeof($list); $i++) {
    if ($list[$i][folder]=='1') {$fold++;
       $dirs[$fold] = $list[$i][stored_filename];
    if ($_GET[action] == 'unzip')
	 {
     $dirname = $list[$i][stored_filename];
     $dirname = substr($dirname,0,strlen($dirname)-1);
     mkdir($basedir.'/'.$dirname); 
	 
	 }
	
	 
     chmod($basedir.'/'.$dirname,0777);
       }
	   else{$fil++;}
    $tot_comp += $list[$i][compressed_size];
    $tot_uncomp += $list[$i][size];
    }


echo "<div class=unzip>".($_GET[action] == 'unzip' ? 'Unzipping' : 'Viewing')." file <b>$unzip</b><br>\n";
echo "$fil files and $fold directories in archive<br>\n";
echo "Compressed archive size: ".convertsize($tot_comp)."<br>\n";
echo "Uncompressed archive size: ".convertsize($tot_uncomp)."<br>\n";

if ($_GET[action] == 'unzip') {
echo "<br><b>Starting to decompress...</b><br>";
$zip->extract('');
echo "Archive sucessfuly extracted!<br>\n";
}

if ($_GET[action] == 'view') {
echo "<br>";
for ($i=0; $i<sizeof($list); $i++) {
    if ($list[$i][folder] == 1) {
         echo "<b>Folder: ".$list[$i][stored_filename]."</b><br>";
         } else {
         echo $list[$i][stored_filename]." (".convertsize($list[$i][size]).")<br>";
         }
  }
}



echo "</div>";

}

?>
</div>
</body>
<script>
document.getElementById('bookmark_name').value = '<?= $my_cur_dir ?>';
function create_date_folder()
{
	var my_date = new Date();
	document.getElementById('folder_name').value = my_date.getDate()+'-'+(my_date.getMonth()+1)+'-'+my_date.getFullYear();
	document.getElementById('create_folder').click();
}
</script>
</html>