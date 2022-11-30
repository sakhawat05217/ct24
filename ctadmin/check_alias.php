<?php
include("header.php");
include("../pages/functions.php");
include("../pages/config.php");
//error_reporting(E_ALL);
?>


<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Alias View Section</div>
        </h1>
    </div>
</div>
<br><br>	

<div class="container">
<?php

$date = date("Y-m-d h:i:s A");    

$sql= "select * from ct_country order by currency_code asc";
    
$result = mysqli_query($link,$sql);
$data = mysqli_fetch_all($result);

$country = array();
$currency = array();

foreach($data as $dt)
{
    $country[$dt[3]]=$dt[2];
    $currency[]=$dt[3];
}

//$source_array = array("SGD","INR","PHP","BDT","EUR","MYR","AED","USD","AUD");
//$target_array = array("SGD","INR","PHP","BDT","EUR","MYR","AED","USD","AUD");
//$source_array = array("SGD","INR","BDT");
//$target_array = array("SGD","INR","BDT");

$source_array = $currency;
$target_array = $currency; 

echo "Currency: ";
print_r($source_array);
echo "<br><br>Country: ";
print_r($country);

//exit;

$providers = array();

$rate_arr = array();
$i=0;
			
foreach ($source_array as $sk=>$sa)
{
	foreach ($target_array as $tk=>$ta)
	{
		if($sa!==$ta)
		{
			
			$url = "https://api.transferwise.com/v3/comparisons/?sourceCurrency=$sa&targetCurrency=$ta&sendAmount=100";
			
			$headers = array(
				'Content-Type:application/json'
			);
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			
			$my_data = json_decode($result);
			
			echo "<h3>".($sk+1).") Source: $sa ($country[$sa]), ".($tk+1).") Target: $ta ($country[$ta])</h3>";
			
            if($my_data!==null)
            {
                echo "<h3>Data: ".count($my_data->providers) ."</h3>";

                foreach ($my_data->providers as $pd)
                   {
                       echo "# ".($i+1)." => Alias => ".$pd->alias.", Name => ".$pd->name.", Logo => ".$pd->logo;
                       $alias=check_alias($pd->alias);
                       $info = $country[$sa]." => ".$country[$ta];
                       if($alias==0) 
                       {

                           $sql2 = "insert into ct_provider (name,alias,link,logo,info,created_at, updated_at) value( '" . 
                            $pd->name . "', '".
                            $pd->alias . "', 'https://wise.com', '". 
                            $pd->logo . "', '".
                            $info. "', '".   
                            $date . "', '".   
                            $date . "') ";

                            $result2 = mysqli_query($link,$sql2);

                            if(mysqli_error($link))
                            {
                                echo mysqli_error($link);
                            }
                           echo '<h3>************************************ New ************************************</h3>';
                       }

                       echo "<br><br>";
                       $rate_arr[$i] = $providers['alias'][$i] = $pd->alias;
                       $providers['name'][$i] = $pd->name;
                       $i++;
                   }
            }
            else echo "<h3>Offline: Net Issue</h3>";
		}
	}
}

?>
</div>

<?php
include("footer.php");
?>