<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Bookmark</title>
</head>

<body>
<?php
$my_file = "bookmark.txt";
$my_str = file_get_contents($my_file);
 if(isset($_POST['save_data']))
{

	$my_str = $_POST['my_str'];
	
	$fp = fopen($my_file,"w");
    fwrite($fp,$my_str);
	echo "File Saved";
}
?>
<form action="" method="post">

<textarea  cols="120" rows="30" name="my_str"><?= $my_str ?></textarea>
<br />
<input type="submit" name="save_data" value="Save" />
</form>
</body>
</html>