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
       	 <div class="text-primary">Currency Conversion Chart</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="my_container">
<?php
    
$converter_id = isset($_GET['converter_id'])? $_GET['converter_id'] : 1;    

$source_country_code = get_settings('currency_converter','source_country');        
$source_country = get_country_tk($source_country_code);    
    
$sql= "select * from ct_currency_converter where id = $converter_id";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$data = mysqli_fetch_row($result);
$target_country_code = $data[1];        
$target_country = get_country_tk($target_country_code);    

$my_label =  $source_country['taka'] . ' => ' .$target_country['taka'];   

$day = isset($_GET['day'])? $_GET['day'] : 7;
$today = date("Y-m-d");
$u_a = array();
$d_a = array(); 
$user_array ='';
$day_array  ='';  
$current_rate = get_current_rate(1,$source_country_code,$target_country_code);    

if($day==7) $steps = 4;
else if($day==30) $steps = 29;
else $steps = 11;

$day_diff = intval($day/$steps);
for($start_day=($day+$day_diff); $start_day>($day_diff-1); $start_day-=$day_diff)
{
    $end_day = $start_day-$day_diff;
    $new_da = $start_day-($day_diff-1);
    $from_day = date('Y-m-d', strtotime($today. " - $start_day days"));
    $d_a[] = date('j M', strtotime($today. " - $new_da days"));
    $day_limit = date('Y-m-d', strtotime($today. " - $end_day days"));
    $sql= "select * from  ct_view_currency_converter where  created_at >= '$from_day' and created_at < '$day_limit' and converter_id = $converter_id";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link));
    $data = mysqli_fetch_row($result);
    if(null!==$data) $my_data= $data[2];
    else $my_data = 0;
    $old_data = $u_a[] = $my_data;

    //echo "start_day: $start_day, end_day: $end_day<br>";
}

    
$d_a[] = date('j M');
$day_like = $today;
$sql= "select * from  ct_view_currency_converter where  created_at like '%$day_like%' and converter_id = $converter_id";
$result = mysqli_query($link,$sql) or die(mysqli_error($link));
$data = mysqli_fetch_row($result);
if(null!==$data) $my_data= $data[2];
else $my_data = $current_rate;
$u_a[] = $my_data;    
    
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
<!--Show data for the days: 
<select id="history_day" onChange="show_chart()">
    <option value="7">Last 7 Days</option>
    <option value="30" <?= ($day==30)? ' selected="selected" ':'' ?>>Last 30 Days</option>
    <option value="90" <?= ($day==90)? ' selected="selected" ':'' ?>>Last 3 Months</option>
    <option value="180" <?= ($day==180)? ' selected="selected" ':'' ?>>Last 6 Months</option>
    <option value="365" <?= ($day==365)? ' selected="selected" ':'' ?>>Last 1 Year</option>
</select> -->

<input type="button" value="Refresh" class="btn btn-success" onclick="window.location.href='chart_converter.php?converter_id=<?= $converter_id ?>'" />

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
					label: '<?= $my_label ?>',
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
							labelString: '<?= $my_label ?>'
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
    
	window.location.href='chart_converter.php?day='+day+'&converter_id=<?= $converter_id ?>';
	
}    

document.getElementById('ajax_load').style.display="none";

</script>