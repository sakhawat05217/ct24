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

$value = get_settings('controls','home_trans');
$home_trans = ($value==null)?0:$value; 

$my_ip = get_client_ip();
$value = get_controls('controls','extra_param',$my_ip);
$extra_param = ($value==null)?'a':$value;

if($home_trans==0) $extra_param = 'a';


if($send_country==$receive_country)
{
	echo '<h1 align="center">Invalid Request <a href="index.php"> Please Try Again </a></h1>';
}
else
{
	
	
	
	if(isset($_SESSION['ct_myuser']))
	{
		save_country($send_amount, $send_country, $receive_country);
        $current_user = $_SESSION['ct_myuser'];
        
        $user_name = get_user_link($_SESSION['ct_myuser']);
    
        $info = "$user_name is in the price compare page now. $ip_data, $ip";
        
        
	}
	else
	{
        $info = "Guest is in the price compare page now. $ip_data, $ip";
        
        save_history('Guest',$send_amount, $send_country, $receive_country);
	}
    
    

	
	$send_country_arr = get_country_tk($send_country);
	$send_country_tk = $send_country_arr['tk']; 
	$receive_country_arr = get_country_tk($receive_country);
	$receive_country_tk = $receive_country_arr['tk']; 
    
    $search=$send_country_arr['name'].' => '.$receive_country_arr['name'].' => '.$send_amount;
    save_log('Search, '.$server,$search, $info);
	
	
?>



<input type="hidden" value="<?= $extra_param ?>" id="extra_param">

    <div class="ajax_load" id="ajax_load">
    	<img src="img/my_ajax3.gif" alt="Loading..." />
    </div>

    
    <div class="bg-secondary page-header">
        <div class="container">
            <h1 class="m-0">
             <div class="text-primary">
             Compare today's <span class="text-white"> <?= $send_country_arr['taka'] ?> to <?= $receive_country_arr['taka'] ?> </span> (<span translate="no"><?= $send_country_tk ?> </span> to <span translate="no"> <?= $receive_country_tk ?></span>) find the best remittance rates
             </div>
            </h1>
        </div>
    </div>
    
    <h2 align="center">
    <?php
	//echo $link_url;
	//exit;
	?>
    </h2>
    
    <br><br>
    
   <!--<div class="my_menu">-->
   <div>
    
    <div class="card-body example">
    

		<div class="row">
		<form method="post" action="" class="form-group">	
        <input type="hidden" id="receive_amount">	
			<div class="col-sm-4">
            <div id="info"></div>
					<h4>Transfer money from</h4>
					<select onChange="ShowExchangeRate()" name="send_country" id="send_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="<?= $send_country ?>"></select>
			</div>
            
            <div class="col-sm-4">
					<h4>Transfer money to</h4>
					<select onChange="ShowExchangeRate()" name="receive_country" id="receive_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="<?= $receive_country ?>"></select>
					
			</div>
            
            <div class="col-sm-4">
            <h4>Amount</h4>
				    <input onKeyUp="ShowExchangeRate()" value="<?= $send_amount ?>" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control my_text"  name="send_amount" id="send_amount">
            
				<input type="button" onclick="$('#ajax_load').show();compare_rate();" value="Search" class="btn btn-success">
			</div>
	 
		</form> 
       </div>	
     
       </div>
        
	</div>


 <p style="padding:50px;"  id="my_top">		  			
	 Wise Rate <span id="rate"></span> 
     <br>
	 Updated about an hour ago
  </p> 
  
    


<?php

	//echo "$send_amount, "."$send_country_tk, "."$receive_country_tk";
    $providers = get_providers($send_amount, $send_country, $receive_country);
    
    //echo "<pre>";
	//print_r($providers);
    //exit;
	
	$link_url  = $home_page."/"."compare.php?str=".$send_amount.".".$send_country.".".$receive_country;
	
    $link_title  = "Compare today's ". $send_country_arr['taka'] ." to ". $receive_country_arr['taka'] ." (". $send_country_tk ." to ". $receive_country_tk .") exchange rates";
    
    //echo "<pre>"; print_r($providers);exit;
    
    if(count($providers)==0)
    {

        $my_rate = get_current_rate($send_amount,$send_country,$receive_country);
        
        $my_msg="Our partners do not support this currency for remittance currently. Drop us a mail if you need this currency and we will try our best to add it. For your information, Mid rate is $my_rate";
    }
        


?>

    <div class="">
    
     <h3 class="card-title" align="center">
         
    <?php
    if(count($providers)==0)
    {
        echo '<div style="padding: 50px;">'.$my_msg.'</div>';
    }
    else
    {
        echo "Found ". count($providers) ." Remittance Service Providers";
    
    ?>
     </h3>
     
     <form method="post" action="email_me.php" class="form-group">	
     	<input type="hidden" name="send_country" value="<?= $send_country ?>">
        <input type="hidden" name="receive_country" value="<?= $receive_country ?>">
        <input type="hidden" name="send_amount" value="<?= $send_amount ?>">
        
        <div class="" align="center">
        <input type="submit" onclick="$('#ajax_load').show();" value="Email Me" class="btn btn-success">
        </div>
    
    </form>
    
    
    <div id="button_share">
    
  
    <!-- Email Social Media -->
    <a target="_blank" href="mailto:?Subject=<?=$link_title?>&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 <?=$link_url?>">
        <img src="img/social/email.png" alt="Email share link" />
    </a>
 
   <!-- Facebook Social Media -->
    <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?=$link_url?>">
        <img src="img/social/facebook.png" alt="Facebook share link" />
    </a>
    
      
    <!-- Twitter Social Media -->
    <a target="_blank" href="https://twitter.com/share?url=<?=$link_url?>&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons">
        <img src="img/social/twitter.png" alt="Twitter share link" />
    </a>
    
    <!-- LinkedIn Social Media -->
    <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?=$link_url?>">
        <img src="img/social/linkedin.png" alt="LinkedIn share link" />
    </a>
   
  
</div>
 
<?php
 
$my_root_rate = get_current_rate(1,'US','IN');
if($receive_country=='IN')
{
    $my_save_rate = '50,000.00';
}
else 
{
    $my_new_rate = get_current_rate(1,'US',$receive_country);
    $my_save_rate = set_comma(round(floatval((50000*$my_new_rate)/$my_root_rate),2));
}

?>
      
 <!-- Button trigger modal -->
<button type="button" id="show_social" style="display: none;" class="btn btn-primary" data-toggle="modal" data-target="#show_social_Modal">
  Launch demo modal
</button>
        

<!-- Modal -->
<div class="modal fade" id="show_social_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">CT24</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>CT24 helps average user save <?= $receive_country_arr['taka'] ?> <?= $my_save_rate ?> per year. <a href="blog/posts/post.php?id=32">How?</a></h4>
        <br>
        <h5>Help your friends by sharing CT24 with them. </h5>
         <br>
          
          <div align="center">
        <!-- Facebook Social Media -->
        <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?=$link_url?>">
            <img src="img/social/facebook.png" alt="Facebook share link" />
        </a>


        <!-- Twitter Social Media -->
        <a target="_blank" href="https://twitter.com/share?url=<?=$link_url?>&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons">
            <img src="img/social/twitter.png" alt="Twitter share link" />
        </a>

        <!-- LinkedIn Social Media -->
        <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?=$link_url?>">
            <img src="img/social/linkedin.png" alt="LinkedIn share link" />
        </a>
              
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>        
        
    
   <?php
    }
        
   foreach ($providers as $pd)
   {
	    $rate = set_comma($pd['rate']);
		$fee = set_comma($pd['fee']);
		$received_amount = set_comma($pd['received_amount']);
		$web = $pd['web'];
        $provider_id = $pd['id'];
        $web_info = $pd['web_info'];
		$png_logo = $pd['png_logo'];
        $provider_active_class = $pd['active_class'];
	    $speed = $pd['speed'];
   ?> 
    
    <div class="card-body example <?= $provider_active_class ?>">

		<div class="row">
		
			
			<div class="col-lg-5">
            
            <img width="300px" src="<?= $png_logo ?>" alt="logo">
                
             <div align="right">  <?= $web_info ?> </div>

			</div>
            
            <div class="col-lg-5">
                <br />
            	Received Amount: <h2><span style="color:#303F69"><?= $received_amount .' '. $receive_country_tk ?></span></h2>
				<?= set_comma($send_amount) ?> <span translate="no"> <?= $send_country_tk ?> </span> =
            	<?= set_comma(round(($send_amount*floatval($rate)),4)) ?> <span translate="no"> <?= $receive_country_tk ?></span>
                <br />
            	1 <span translate="no"> <?= $send_country_tk ?> </span> = <?= set_comma(round(floatval($rate),4)) ?> <span translate="no"> <?= $receive_country_tk ?></span><br>
				<?= "Fee: ".$fee ?><br>
                <br>
                <a id="show_<?= $provider_id ?>" href="javascript: return false;" onClick="$('#more_<?= $provider_id ?>').show();$(this).hide();">More...</a>
                <div id="more_<?= $provider_id ?>" style="display: none;" >
                <?= "Transfers typically take ".$speed." to post to your account, excluding weekends and Federal banking holidays." ?> <br><br><a  href="javascript: return false;" onClick="$('#show_<?= $provider_id ?>').show();$('#more_<?= $provider_id ?>').hide();">Less...</a>
                     
                </div>
                
			</div>
            
            <div class="col-lg-2">
            <br><br>
				<a href="<?= $web ?>" onClick="save_provider('<?= $current_user ?>','<?= $provider_id ?>')" target="_blank" class="btn btn-success">Send money now</a>
			</div>
						
	
			
		</div>
       
       </div>
       
       <br><br>
       
   <?php

   	}
   ?>
        
   <div align="center">
    
    <h2>Convert <?= $send_country_arr['taka'] ?> to <?= $receive_country_arr['taka'] ?> (<span translate="no"><?= $send_country_tk ?> </span> to <span translate="no"> <?= $receive_country_tk ?></span>)</h2>
  
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

    ?>   
       
   </div>    
        
     <script>
         
         document.getElementById('ajax_load').style.display="none";
        
    </script>   
	</div>
<?php

   	}
include("pages/footer.php");	
?>
<script src="js/chart.js"></script>

<script>
    
var my_message = getCookie('show_message');
    
//console.log("Message: ",my_message);

if(my_message=="")
    {
        //console.log("yes");
        setCookie('show_message', "on", 1);
        
        setTimeout(function showme()
        {
            $('#show_social').click();

        },10000);
    }
else
    {
        //console.log("no");
    }    
 

</script>