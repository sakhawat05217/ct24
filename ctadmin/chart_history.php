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
       	 <div class="text-primary">Search History Chart Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
<?php

$day = isset($_GET['day'])? $_GET['day'] : 7;
$today = date("Y-m-d");
$u_a = array();
$d_a = array(); 
$user_array ='';
$day_array  ='';  

if($day==7)
{
    
    $d_a[] = date('j M', strtotime($today. " - 7 days"));
    $day_like = date('Y-m-d', strtotime($today. " - 7 days"));
    $sql= "select * from ct_history where created_at like '%$day_like%' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
    
    $d_a[] = date('j M', strtotime($today. " - 6 days"));
    $day_like = date('Y-m-d', strtotime($today. " - 6 days"));
    $sql= "select * from ct_history where created_at like '%$day_like%' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
    
    $d_a[] = date('j M', strtotime($today. " - 5 days"));
    $day_like = date('Y-m-d', strtotime($today. " - 5 days"));
    $sql= "select * from ct_history where created_at like '%$day_like%' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
    
    $d_a[] = date('j M', strtotime($today. " - 4 days"));
    $day_like = date('Y-m-d', strtotime($today. " - 4 days"));
    $sql= "select * from ct_history where created_at like '%$day_like%' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
    
    $d_a[] = date('j M', strtotime($today. " - 3 days"));
    $day_like = date('Y-m-d', strtotime($today. " - 3 days"));
    $sql= "select * from ct_history where created_at like '%$day_like%' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
    
    $d_a[] = date('j M', strtotime($today. " - 2 days"));
    $day_like = date('Y-m-d', strtotime($today. " - 2 days"));
    $sql= "select * from ct_history where created_at like '%$day_like%' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
    
    $d_a[] = date('j M', strtotime($today. " - 1 days"));
    $day_like = date('Y-m-d', strtotime($today. " - 1 days"));
    $sql= "select * from ct_history where created_at like '%$day_like%' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
    
    $d_a[] = date("j M");
    $day_like = $today;
    $sql= "select * from ct_history where created_at like '%$day_like%' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
    
}
else
{
    
    if($day==365) $steps = 12;
    else $steps = 6;
    
    $day_diff = intval($day/$steps);
    for($start_day=($day+$day_diff); $start_day>$day_diff; $start_day-=$day_diff)
    {
        $end_day = $start_day-$day_diff;
        
        $from_day = date('Y-m-d', strtotime($today. " - $start_day days"));
        $d_a[] = date('j M', strtotime($today. " - $end_day days"));
        $day_limit = date('Y-m-d', strtotime($today. " - $end_day days"));
        $sql= "select * from ct_history where  created_at >= '$from_day' and created_at < '$day_limit' group by ip";
        $result = mysqli_query($link,$sql) or die(mysqli_error($link));
        $data = mysqli_affected_rows($link);
        $u_a[] = $data;
        
        //echo "start_day: $start_day, end_day: $end_day<br>";
    }
    
   
    $from_day = date('Y-m-d', strtotime($today. " - $end_day days"));
    $d_a[] = date('j M');
    $day_limit = $today;
    $sql= "select * from ct_history where  created_at >= '$from_day' and created_at <= '$day_limit' group by ip";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_affected_rows($link);
    $u_a[] = $data;
}
    
foreach ($d_a as $k=>$v)
{
   $day_array .= "'".$v."'"; 
   if($k<count($d_a)-1)  $day_array .= ","; 
}
    
foreach ($u_a as $k=>$v)
{
   $user_array .= $v; 
   if($k<count($u_a)-1)  $user_array .= ","; 
}    
      

//print_r($u_a);    
//echo $user_array; 
//exit;    
?>

<br /><br />    
<div align="center">
Show data for the days: 
<select id="history_day" onChange="show_chart()">
    <option value="7">Last 7 Days</option>
    <option value="30" <?= ($day==30)? ' selected="selected" ':'' ?>>Last 30 Days</option>
    <option value="90" <?= ($day==90)? ' selected="selected" ':'' ?>>Last 3 Months</option>
    <option value="180" <?= ($day==180)? ' selected="selected" ':'' ?>>Last 6 Months</option>
    <option value="365" <?= ($day==365)? ' selected="selected" ':'' ?>>Last 1 Year</option>
</select> 

<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='chart_history.php'" />

</div>

<br /><br/>
    

<canvas id="canvas" style="display: block; background-color:#FFF;" height="100px" class="chartjs-render-monitor"></canvas>
    
<script>
	
		
/*
  "red": "rgb(255, 99, 132)",
  "orange": "rgb(255, 159, 64)",
  "yellow": "rgb(255, 205, 86)",
  "green": "rgb(75, 192, 192)",
  "blue": "rgb(54, 162, 235)",
  "purple": "rgb(153, 102, 255)",
  "grey": "rgb(201, 203, 207)"
*/
		
		
		
		var Days = [<?= $day_array ?>];
		var config = {
			type: 'line',
			data: {
				labels: Days,
				datasets: [
				{
					label: 'Users',
					backgroundColor: "rgb(54, 162, 235)",
					borderColor: "rgb(54, 162, 235)",
					data: [<?= $user_array ?>],
					fill: false,
				}
				
				]
			},
			options: {
				responsive: true,
				title: {
					display: false,
					text: '',
					
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Days'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Users'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};

	
</script>      

</div>
<?php
include("footer.php");
?>

<script>
    
function show_chart()
{
    var day = $('#history_day').val();
    
	window.location.href='chart_history.php?day='+day;
	
}    

document.getElementById('ajax_load').style.display="none";

</script>