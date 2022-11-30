<?php

include("function.php");

$basedir = $_REQUEST['basedir'];
$dir_arr = explode("/",$basedir);
$dir_name=$dir_arr[count($dir_arr)-1];

$folder_size = '';
$disk_total_space = disk_total_space($basedir);
$total_disk_size = ConvertSize($disk_total_space);

$disk_free_space = disk_free_space($basedir);
$disk_free_size = ConvertSize($disk_free_space);

$disk_used_space = $disk_total_space-$disk_free_space;
$disk_used_size = ConvertSize($disk_used_space);

if(php_uname('s')=='Windows NT')
{
	
	$f = $basedir;
    $obj = new COM ( 'scripting.filesystemobject' );
    if (is_object ($obj))
    {
        $ref = $obj->getfolder ( $f );
        $folder_size = ConvertSize($ref->size);
		$obj = null;
    }
    else
    {
        echo 'can not create object';
    }
	
}
else
{
	$f = $basedir;
    $io = popen ( '/usr/bin/du -sh ' . $f, 'r' );
    $size = fgets ( $io, 4096);
    $size = substr ( $size, 0, strpos ( $size, "\t" ) );
    pclose ( $io );
    $folder_size =$size;
	
}

echo "Path: " . $basedir;
echo "<br><br>";
echo "Directory Name: " . $dir_name;
echo "<br><br>";
echo "Size: " . $folder_size;
echo "<br><br>";
echo "Total Disk Space: " . $total_disk_size;
echo "<br><br>";
echo "Total Used Space: " . $disk_used_size;
echo "<br><br>";
echo "Total Free Space: " . $disk_free_size;
echo "<br><br>";
echo "Last modified on: " . date("d-m-Y h:i:s A", filemtime($basedir));
echo "<br><br>";
echo "Last accessed on: " . date("d-m-Y h:i:s A", fileatime($basedir));
echo "<br><br>";
echo "Last created on: " . date("d-m-Y h:i:s A", filectime($basedir));
echo "<br><br>";
echo "File permissions: " . sprintf('%o', fileperms($basedir));
echo "<br><br>";
echo "User ID: " . fileowner($basedir);
echo "<br><br>";
echo "Group ID: " . filegroup($basedir);
echo "<br><br>";
echo "<pre>";
print_r(stat($basedir));

/*

echo "Name: " . $f_name;
echo "<br><br>";
echo "Path: " . $basedir;
echo "<br><br>";
echo "Size: " . $file_size;
echo "<br><br>";
echo "Last modified on: " . date("d-m-Y h:i:s A", filemtime($my_file));
echo "<br><br>";
echo "Last accessed on: " . date("d-m-Y h:i:s A", fileatime($my_file));
echo "<br><br>";
echo "Last created on: " . date("d-m-Y h:i:s A", filectime($my_file));
echo "<br><br>";
echo "File permissions: " . sprintf('%o', fileperms($my_file));
echo "<br><br>";
echo "User ID: " . fileowner($my_file);
echo "<br><br>";
echo "Group ID: " . filegroup($my_file);
echo "<br><br>";
echo "<pre>";
print_r(stat($my_file));*/
?>
