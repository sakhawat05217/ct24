<?php
include("pages/header.php");

$ip = get_ip_link(get_client_ip());
$server = $_SERVER['HTTP_HOST'];
$ip_data = get_ip_data();
@$mystr = $_REQUEST['str'];
@$str_arr = explode(".",$mystr);

@$send_amount = $str_arr[0];
@$send_country = $str_arr[1];
@$receive_country = $str_arr[2];
$current_user = 'Guest';



if($send_country==$receive_country)
{
	echo '<h1 align="center">Invalid Request <a href="index.php"> Please Try Again </a></h1>';
}
else
{
	
	
	
	if(isset($_SESSION['ct_myuser']))
	{
        $current_user = $_SESSION['ct_myuser'];
        
        $user_name = get_user_link($_SESSION['ct_myuser']);
    
        $info = "$user_name is in the currency converter page now. $ip_data, $ip";
        
        save_country($send_amount, $send_country, $receive_country);
	}
	else
	{
        $info = "Guest is in the currency converter page now. $ip_data, $ip";
        save_history('Guest',$send_amount, $send_country, $receive_country);
	}
    
  	$send_country_arr = get_country_tk($send_country);
	$send_country_tk = $send_country_arr['tk']; 
	$receive_country_arr = get_country_tk($receive_country);
	$receive_country_tk = $receive_country_arr['tk']; 
    
    $search=$send_country_arr['name'].' => '.$receive_country_arr['name'].' => '.$send_amount;
    save_log('Currency Converter, '.$server,$search, $info);
	
?>
    <div class="ajax_load" id="ajax_load">
    	<img src="img/my_ajax3.gif" alt="Loading..." />
    </div>
    
    <div class="bg-secondary page-header">
        <div class="container">
            <h1 class="m-0">
             <div class="text-primary">
             Currency Converter
             </div>
            </h1>
        </div>
    </div>
    
    <h2 align="center">

    </h2>
    
    <br><br>
    

   <div>
    
    <div class="card-body example">
    

		<div class="row">
		<form method="post" action="" class="form-group">	
        <input type="hidden" id="receive_amount">	
			<div class="col-sm-4">
            <div id="info"></div>
					<h4>From</h4>
					<select name="send_country" id="send_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="<?= $send_country ?>"></select>
			</div>
            
            <div class="col-sm-4">
					<h4>To</h4>
					<select name="receive_country" id="receive_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="<?= $receive_country ?>"></select>
					
			</div>
            
            <div class="col-sm-4">
            <h4>Amount</h4>
				    <input value="<?= $send_amount ?>" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control my_text"  name="send_amount" id="send_amount">
            
				<input type="button" onclick="$('#ajax_load').show();show_chart();" value="Convert" class="btn btn-success">
			</div>
	 
		</form> 
       </div>	
     
       </div>
        
	</div>

<div align="center">
    
    <h2>Convert <?= $send_country_arr['taka'] ?> to <?= $receive_country_arr['taka'] ?> (<?= $send_country_tk ?> to <?= $receive_country_tk ?>)</h2>

    <?php
        
    $data_collection_sql= "select * from ct_currency_converter where target_country = '$receive_country'";
    $data_collection_result = mysqli_query($link,$data_collection_sql) or die(mysqli_error($link));
    $data_collection_data = mysqli_fetch_row($data_collection_result);        


    if(null!==$data_collection_data)
    {
        $target_country_id = $data_collection_data[0];
        
       // echo "converter_id is $target_country_id <br>";exit;
        
        $source_country_code = $send_country;
        $source_country = $send_country_arr;  
        
        $source_country_sql= "select * from ct_currency_converter where target_country = '$send_country'";
        $source_country_result = mysqli_query($link,$source_country_sql) or die(mysqli_error($link));
        $source_country_data = mysqli_fetch_row($source_country_result);
        $source_country_id = 0;
        
        if(null!==$source_country_data) $source_country_id = $source_country_data[0];
        //echo $source_country_id;exit;
        
        $target_country = $receive_country_arr;    

        $my_label =  $source_country['taka'] . ' => ' .$target_country['taka'];   

        $day = 7;
        $today = date("Y-m-d");
        $u_a = array();
        $d_a = array(); 
        $user_array ='';
        $day_array  ='';  
        $current_rate = get_current_rate($send_amount,$send_country,$receive_country);    

        $steps = 4;

        $day_diff = intval($day/$steps);
        for($start_day=($day+$day_diff); $start_day>($day_diff-1); $start_day-=$day_diff)
        {
            $end_day = $start_day-$day_diff;
            $new_da = $start_day-($day_diff-1);
            $from_day = date('Y-m-d', strtotime($today. " - $start_day days"));
            $d_a[] = date('j M', strtotime($today. " - $new_da days"));
            $day_limit = date('Y-m-d', strtotime($today. " - $end_day days"));
            
            $sql= "select * from  ct_view_currency_converter where  created_at >= '$from_day' and created_at < '$day_limit' and converter_id = $target_country_id";
            $result = mysqli_query($link,$sql) or die(mysqli_error($link));
            $data = mysqli_fetch_row($result);
            if(null!==$data) $target_data= $data[2];
            else $target_data = $current_rate;
            $my_rate = $target_data;
            if($send_country!='US')
            {   
                $sql= "select * from  ct_view_currency_converter where  created_at >= '$from_day' and created_at < '$day_limit' and converter_id = $source_country_id";
                $result = mysqli_query($link,$sql) or die(mysqli_error($link));
                $data = mysqli_fetch_row($result);
                if(null!==$data) 
                {
                    $source_data= $data[2];
                    if($source_data!=0) $my_rate = round(floatval($target_data/$source_data), 4);
                    else $my_rate = $current_rate;
                }
                else $my_rate = $current_rate;
            }
            
            $u_a[] = $my_rate*$send_amount;

            //echo "start_day: $start_day, end_day: $end_day<br>";
        }


        $d_a[] = date('j M');
        $day_like = $today;
        
        $sql= "select * from  ct_view_currency_converter where  created_at like '%$day_like%' and converter_id = $target_country_id";
        $result = mysqli_query($link,$sql) or die(mysqli_error($link));
        $data = mysqli_fetch_row($result);
        if(null!==$data) $target_data= $data[2];
        else $target_data = $current_rate;
        $my_rate = $target_data;
            
        if($send_country!='US')
        {
            $sql= "select * from  ct_view_currency_converter where  created_at like '%$day_like%' and converter_id = $source_country_id";
            $result = mysqli_query($link,$sql) or die(mysqli_error($link));
            $data = mysqli_fetch_row($result);

            if(null!==$data) 
            {
                $source_data= $data[2];
                if($source_data!=0) $my_rate = round(floatval($target_data/$source_data), 4);
                else $my_rate = $current_rate;
            }
            else $my_rate = $current_rate;
        }
        
        $u_a[] = $my_rate*$send_amount;    

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

        /*print_r($d_a);
        print_r($u_a);    
        echo $user_array; 
        exit; */
        
        ?>
    
    <br /><br/>
    

    <canvas id="canvas" style="display: block; background-color:#FFF;" class="chartjs-render-monitor"></canvas>

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
                        tension: 0
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
    
    
    <?php

    }   
    else
    {
        echo "<h2>No record found!</h2>";
    }

    


    ?>    

</div>

<?php
        
}
include("pages/footer.php");	
?>

 <script>

     document.getElementById('ajax_load').style.display="none";

     function show_chart()
        {
            var send_amount = $('#send_amount').val();
            var send_country = $('#send_country').val();
            var receive_country = $('#receive_country').val();
            var currentDate = new Date();
            var timestamp = currentDate.getTime();
            window.location.href = 'currency_converter.php?t='+timestamp +'&str='+send_amount+'.'+send_country+'.'+receive_country;
        }

 </script>

<script src="js/chart.js"></script>