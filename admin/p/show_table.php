<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Table View</title>
<link href="../z/style.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php
include("config.php");
include("function.php");

$table_name = $_REQUEST['tb'];
$limit = $_REQUEST['l'];

$sql = "select * from $table_name";
$total_data = RunSQL($sql);

foreach($total_data[0] as $k=>$v)
{
	if(is_string($k))
	{ $my_column = $k; break; }
}

echo "<h1>Table: '".$table_name."', Total Rows: " . (count($total_data)) . "</h1>";

$my_order = (isset($_POST['my_order']))? $_POST['my_order'] : '';
$order_text = (isset($_POST['my_order']))? ' order by ' : '';
$my_column = (isset($_POST['my_column']))? $_POST['my_column'] : '';
$limit = (isset($_POST['my_limit']))? $_POST['my_limit'] : 10;
$my_sql = "select * from $table_name where ";

$sql = "select * from $table_name $order_text $my_column $my_order limit $limit";
$data = RunSQL($sql);

if(isset($_POST['runsql']))
{
	$my_sql = $_POST['my_sql'];
	$data = RunSQL($my_sql);
}


/*if(count($data)<2)
{
	$sql = "select * from $table_name order by $my_column $my_order limit $limit";
    $data = RunSQL($sql);
}*/

$first=0;
$c=1;
foreach($data as $d)
{
	
	
	if($d)
	{
		if($first==0)
		{
			echo '<table border="2" cellpadding="5"><thead><tr align="center"><th>#</th>';
			
			foreach($d as $k=>$v)
			{
				if(is_string($k))
				echo "<th>".$k . "</th>";
			}
			echo "</tr></thead>";
			
			$first=1;
			
		}
		
		echo '<tr align="center">';
		echo "<td>".$c++."</td>";
		foreach($d as $k=>$v)
		{
			
			if(is_string($k))
				echo "<td>".$v . "</td>";
		}
		
		echo "</tr>";
		//print_r($d) . "<br />";
		
	}
}

echo "</table>";

?>
<br />
<form action="" method="post">
<table>
<tr>
<td>
 Column:
 <select name="my_column">
  <?php

 foreach($data[0] as $k=>$v)
	{
		if(is_string($k))
		{
		?>
        
        
		 <option value="<?php echo $k; ?>" <?php if(isset($my_column) and ($my_column==$k)) echo 'selected="selected"'; ?>><?php echo $k; ?></option>
	    
		<?php
		}
    }
  ?>
 </select>
</td>
<td> 
 Order: <select name="my_order">
  <option value="asc" <?php if(isset($my_order) and ($my_order=='asc')) echo 'selected="selected"'; ?>>ASC</option>
  <option value="desc" <?php if(isset($my_order) and ($my_order=='desc')) echo 'selected="selected"'; ?>>DESC</option>
 </select>
</td>
<td>  
 Limit: <input type="text" size="10" name="my_limit" value="<?php echo $limit; ?>" />
 </td>
<td> 
 <input type="submit" value="Update" name="update" />
 <input type="button" value="Refresh" onclick="window.location.href='show_table.php?tb=<?= $table_name ?>&l=10'" />
 <a target="_blank" style="text-decoration:none;" href="show_info.php?tb=<?= $table_name ?>">Info</a>
</td>
</tr>

<tr>
</table>

<table>
<tr>
<td>
 <input type="text" size="80" id="sql_body" name="my_sql" value="<?php echo $my_sql; ?>" /> 
 <input type="submit" value="RunSQL" name="runsql" />

<select onchange="document.getElementById('sql_body').value=this.value;">
    <option value=""></option>
    <option value="TRUNCATE <?= $table_name ?>">TRUNCATE</option>
    <option value="DROP TABLE <?= $table_name ?>">DROP TABLE</option>
    <option value="SELECT * FROM <?= $table_name ?> WHERE ">SELECT</option>
    <option value="SELECT * FROM <?= $table_name ?> GROUP BY column_name">GROUP BY</option>
    <option value="INSERT INTO <?= $table_name ?> (col1, col2) VALUES (val1, val2)">INSERT</option>
    <option value="UPDATE <?= $table_name ?> SET col1=val1, col2=val2 WHERE ">UPDATE</option>
    <option value="DELETE FROM <?= $table_name ?> WHERE ">DELETE</option>
</select>

</td>
</tr>

</table>
</form>
</body>
</html>