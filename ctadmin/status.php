<?php
include("header.php");
include("../pages/functions.php");
//error_reporting(E_ALL);
?>

<div class="ajax_load" id="ajax_load">
    	<img src="../img/my_ajax3.gif" alt="Loading..." />
</div>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Status Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">

<?php
$day_limit = isset($_GET['day'])? $_GET['day'] : 30;    
    
$today = date("Y-m-d");
$user_country_array = array();
$history_country_array = array();
$user_country_info = array();
$history_country_info = array();
    
$sql= "select * from ct_new_users";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$total_new_users = mysqli_affected_rows($link); 
    
$sql= "select * from ct_history group by ip";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$total_history_users = mysqli_affected_rows($link);     
    
$sql= "select * from ct_new_users group by country order by country asc";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$data = mysqli_fetch_all($result);  
    
foreach($data as $dt)  
{
    $user_country_array[] = $dt[3];
}
    
$sql= "select * from ct_history group by user_country order by user_country asc";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$data = mysqli_fetch_all($result);  
    
foreach($data as $dt)  
{
    $history_country_array[] = $dt[9];
} 
    
$user_country_array = array_filter($user_country_array);
$history_country_array = array_filter($history_country_array);    
    
$d_a = array();  
$u_a = array();
$u_c = array();    
$h_a = array(); 
$h_c = array();    
		
$d_a[] = date("Y-m-d");
$day_like = $today;
$sql= "select * from ct_new_users where created_at like '%$day_like%'";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$data = mysqli_affected_rows($link);
$u_a[] = $data;

$info='';    
foreach($user_country_array as $uc)  
{
    $sql= "select * from ct_new_users where created_at like '%$day_like%' and country='$uc'";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    if($data>0) $info .= $uc.': '.$data.'<br>';
}
$u_c[] = $info; 
    
$sql= "select * from ct_history where created_at like '%$day_like%'";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$data = mysqli_affected_rows($link);
$h_a[] = $data;  
 
$info='';    
foreach($history_country_array as $hc)  
{
    $sql= "select * from ct_history where created_at like '%$day_like%' and user_country='$hc'";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    if($data>0) $info .= $hc.': '.$data.'<br>';
}
$h_c[] = $info;    

    
for($i=1;$i<$day_limit;$i++)    
{
    $d_a[] = date('Y-m-d', strtotime($today. " - $i days"));
    $day_like = date('Y-m-d', strtotime($today. " - $i days"));
    $sql= "select * from ct_new_users where created_at like '%$day_like%'";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data; 
    
    $info='';    
    foreach($user_country_array as $uc)  
    {
        $sql= "select * from ct_new_users where created_at like '%$day_like%' and country='$uc'";
        $result = mysqli_query($link,$sql) or die(mysqli_error($link));
        $data = mysqli_affected_rows($link);
        if($data>0) $info .= $uc.': '.$data.'<br>';
    }
    $u_c[] = $info; 
    
    $sql= "select * from ct_history where created_at like '%$day_like%'";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $h_a[] = $data;
    
    $info='';    
    foreach($history_country_array as $hc)  
    {
        $sql= "select * from ct_history where created_at like '%$day_like%' and user_country='$hc'";
        $result = mysqli_query($link,$sql) or die(mysqli_error($link));
        $data = mysqli_affected_rows($link);
        if($data>0) $info .= $hc.': '.$data.'<br>';
    }
    $h_c[] = $info;

}    

    
    
/*print_r($d_a);
echo "<br>";
print_r($u_a);   
echo "<br>";
print_r($u_c);
echo "<br>"; 
print_r($h_a);    
echo "<br>";
print_r($h_c);    
exit;*/ 
?>
<div align="center">

Show data for the days: 
<select id="show_day" onChange="show_day()">
    <option value="30">30 Days</option>
    <option value="90" <?= ($day_limit==90)? ' selected="selected" ':'' ?>>3 Months</option>
    <option value="180" <?= ($day_limit==180)? ' selected="selected" ':'' ?>>6 Months</option>
    <option value="365" <?= ($day_limit==365)? ' selected="selected" ':'' ?>>1 Year</option>
</select>    
<br /><br />
    
<a href="chart_new_users.php" target="_blank" class="btn btn-primary">New Users</a>  
<a href="chart_history.php" target="_blank" class="btn btn-primary">Search History</a>
<a href="log.php" target="_blank" class="btn btn-primary">Log</a>    
<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='status.php'" /> 
<br /><br />
    
<h1 align="center">Total New Users: <?= $total_new_users ?>, Search Users: <?= $total_history_users ?></h1>  
    


</div>
<br /><br/>


<?php


echo '<div class="container-fluid"><div class="row"><div class="col-xl-1">#</div><div class="col-xl-1">Date</div><div class="col-xl-1">New Users</div><div class="col-xl-2">Based On Country</div><div class="col-xl-2">Search History Users</div><div class="col-xl-2">Based On Country</div></div><br>';

  
for($i=0;$i<$day_limit;$i++)
{
	    
	echo "<div class='row'>";
	echo '<div class="col-xl-1">'.($i+1).'</div><div class="col-xl-1">'.$d_a[$i].'</div><div class="col-xl-1">'.$u_a[$i].'</div><div class="col-xl-2">'.$u_c[$i].'</div><div class="col-xl-2">'. $h_a[$i].'</div><div class="col-xl-2">'. $h_c[$i].'</div>';
	
	echo "</div><br>";
}


echo '</div>';


?>
	
</div>
<?php
include("footer.php");
?>

<script>
    
function show_day()
{
    var day = $('#show_day').val();
    
	window.location.href='status.php?day='+day;
	
}   

document.getElementById('ajax_load').style.display="none";

</script>