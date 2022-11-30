<?php
include("functions.php");
include("config.php");


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
			//echo "<pre>";
			//print_r($my_data);
			
			echo "<h3>".($sk+1).") Source Currency: $sa ($country[$sa]), ".($tk+1).") Target Currency: $ta ($country[$ta])</h3>";
			echo "<h3>Total Data Found: ".count($my_data->providers) ."</h3>";
			
			foreach ($my_data->providers as $pd)
			   {
				   echo "# ".($i+1)." => Alias => ".$pd->alias.", Name => ".$pd->name.", Logo => ".$pd->logo;
                   $alias=check_alias($pd->alias);
                   if($alias==0) echo ' ************************************ New ************************************';
                   echo "<br><br>";
				   $rate_arr[$i] = $providers['alias'][$i] = $pd->alias;
				   $providers['name'][$i] = $pd->name;
				   $i++;
			   }
		}
	}
}

/*exit;

$providers['alias']=array_unique($providers['alias']);
$providers['name']=array_unique($providers['name']);
$rate_arr=array_unique($rate_arr);

asort($rate_arr);

$i=1;
foreach($rate_arr as $k=>$v)
{
	//echo $i++.") ".$providers['name'][$k]."<br>";
	$web_arr = get_web($providers['alias'][$k]);
	echo $i++.") Alias => ".$providers['alias'][$k].", Name => ".$providers['name'][$k]."<br>";
	echo "Web => ".$web_arr['link'].", Name => ".$web_arr['name']."<br><br>";
}*/

?>