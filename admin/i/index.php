<?php 
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>I</title>
<script type="text/javascript" src="script.js"></script>
</head>

<body>
<div align="right"><a href="../l/logout.php">Logout</a></div>
<?php
if(!isset($_SESSION['muser'])) echo "<script>window.location='../l/login.php?ref=i';</script>";
$fp = fopen("inf.txt","r");
while(($data[] = fgets($fp))) { }
$file_connection_type = trim($data[0]);
$file_table_name = trim($data[1]);
unset($data);
fclose($fp);
//echo $file_connection_type . ", ". $file_table_name; exit;
?>

<div align="center">
<?php
if(isset($_POST['save_inf']))
{
	$connection_type = $_POST['connection_type'];
	$table_name = trim($_POST['table_name']);
	
	$fp = fopen("inf.txt","w");
    fwrite($fp,$connection_type."\n");
	fwrite($fp,$table_name."\n");
	fclose($fp);
	
	echo "Saved";
	
	$file_connection_type = $connection_type;
    $file_table_name = trim($table_name);
}

?>
</div>
<form action="" method="post" style="display:none;">
Current Connection:
<select name="connection_type">
<option <?= ($file_connection_type=='m')? ' selected="selected" ': '' ?> value="m">M</option>
<option <?= ($file_connection_type=='p')? ' selected="selected" ': '' ?> value="p">P</option>
</select>
<br /><br />
Current Table:
<input type="text" size="30" name="table_name" value="<?= $file_table_name ?>" />
<br /><br />
<input type="submit" value="Save" name="save_inf" />
</form>
<br /><br />
<?php
include("../$file_connection_type/config.php");
include("../$file_connection_type/function.php");


if(isset($_POST['table_create']))
{
	$table_name = trim($_POST['table_name']);
	$sql = "CREATE TABLE $table_name (id int(11) NOT NULL, title text   CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, info text   CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL)  ENGINE=InnoDB DEFAULT CHARSET=latin1";
   
    mysqli_query($link,$sql);
	
	$sql = "ALTER TABLE $table_name ADD PRIMARY KEY (id)";
   
    mysqli_query($link,$sql);
	
	$sql = "ALTER TABLE $table_name MODIFY id int(11) NOT NULL AUTO_INCREMENT;";
   
    mysqli_query($link,$sql);
	
	$sql = "INSERT INTO $table_name (id, title, info) VALUES (NULL, 'Test', 'Test');";
   
    mysqli_query($link,$sql);
	
	echo "<h3>Table creation successfull.<h3>";
	echo "<script>window.location.href='index.php';</script>";
	
}
else if(isset($_POST['insert_new']))
{
	$table_name = trim($_POST['table_name']);
	$title = trim($_POST['title']);
	$info = addslashes(trim($_POST['info']));
	 
	$sql = "insert into $table_name (title, info) values('$title','$info')";
   
    mysqli_query($link,$sql);
    echo "<script>window.location.href='index.php';</script>";
} 
else if(isset($_POST['save_info']))
{
	$table_name = trim($_POST['table_name']);
	$id = trim($_POST['title']);
	$title = trim($_POST['new_title']);
	$info = addslashes(trim($_POST['info']));
	$sql = "update $table_name set
	title='$title',
	info='$info'
	where id = $id";   
	mysqli_query($link,$sql);;

}
else if(isset($_POST['delete_info']))
{
	$id = $_POST['title'];
	$table_name = trim($_POST['table_name']);
	?>
    <script>
	var yn=confirm("Are you sure you want to delete this information?");
	if(yn)
	 window.location.href='index.php?del=<?= $id ?>&tbl=<?= $table_name ?>';
	</script>
    <?php
}
else if(isset($_REQUEST['del']))
{
	$id = $_REQUEST['del'];
	$table_name = $_REQUEST['tbl'];
	$sql = "delete from $table_name where id = $id";
    mysqli_query($link,$sql);;
}

if($file_connection_type!='p')
{
	$sql = "select * from $file_table_name";
    try
    {
        $result = mysqli_query($link,$sql);
    }
    catch(Exception $e)
	{
		?>
		<h2>Table '<?= $file_table_name ?>' Not Found!</h2>
		<form action="" method="post">
		<input type="hidden" name="table_name" value="<?= $file_table_name ?>" />
		<input type="submit" value="Create The Table" name="table_create" />
		</form>
		<?php	
		exit;
	}
	$total_data = RunSQL($sql);
}
else
{


  ?>
		<form action="" method="post">
		<input type="hidden" name="table_name" value="<?= $file_table_name ?>" />
		<input type="submit" value="Create The Table" name="table_create" />
		</form>
        <br />
<?php	
	
}
?>
<div style="float:left;">
<form action="" method="post">
<input type="hidden" name="table_name" value="<?= $file_table_name ?>" />
Title: <input type="text" size="60" name="title" required="required" />
<br /><br />
Information: <br />
<textarea cols="60" rows="10" name="info" required="required"></textarea>
<br /><br />
<input type="submit" value="Insert" name="insert_new" />
</form>
</div>

<div style="float:right; margin-top:-140px; width:55%;">

<?php
if(isset($_POST['search']))
{
	$sr_txt = $_POST['sr_txt'];
	$sql = "select * from $file_table_name where title like'%$sr_txt%' or info like'%$sr_txt%' order by title asc";
}
else $sql = "select * from $file_table_name order by title asc";

$total_data = RunSQL($sql);
$title = isset($_POST['title'])? trim($_POST['title']): '';

?>

<div  id="div_info">
<?php
if(isset($_POST['search']))
{
	if($file_connection_type!='p') $data_count = (count($total_data)-1);
	else $data_count = count($total_data);
	
	echo "<h3>Total ". $data_count . " data found.</h3>";
}

?>
</div>
<br />

<form action="" method="post">
<input type="hidden" name="table_name" value="<?= $file_table_name ?>" />
<br /><br /><br /><br />

Title:
<select id="title" name="title" onchange="view_info('<?= $file_connection_type ?>','<?= $file_table_name ?>', this.value);">

<option value="0"></option>
<?php

foreach($total_data as $td)
{
  if($file_connection_type!='p')
  {
	  $my_id = $td['id'];
	  $my_title = stripslashes($td['title']);
  }
  else
  {
	  $my_id = $td->id;
	  $my_title = stripslashes($td->title);
  }
 
 if(($title!='')and($title==$my_title))
  echo '<option selected="selected" value="'. $my_id .'">'. $my_title .'</option>';
 else if ($my_title!='')
  echo '<option value="'. $my_id .'">'. $my_title .'</option>';
}
?>
</select>

<?php

foreach($total_data as $td)
{
  if($file_connection_type!='p')
  {
	  $my_id = '';
	  $my_title = '';
      if($td!==null)
      {
           $my_id = $td['id'];
	       $my_title = stripslashes($td['title']);
      }
      
      
  }
  else
  {
	  $my_id = $td->id;
	  $my_title = stripslashes($td->title);
  }
  
 echo '<input type="hidden" id="hidden_title_'. $my_id .'" name="hidden_title" value="'.$my_title .'" />';	
}

?>

<input type="text" size="60" name="new_title" id="new_title" required="required" />
<br /><br />
Information: <br />
<textarea required="required" cols="87" rows="15" id="info" name="info"></textarea>
<br /><br />
<!--<input type="button" onclick="save_info('< ?= $file_connection_type ?>','< ?= $file_table_name ?>')" value="Save" />-->
<input type="submit" value="Save" name="save_info" />
<input type="submit" value="Delete" name="delete_info" />

</form>
<br />
<form action="" method="post">
<input type="text" value="" size="30" name="sr_txt" />
<input type="submit" value="Search" name="search" />
<input type="button" value="Refresh" onclick="window.location.href='index.php'" />
</form>

</div>

</body>
</html>