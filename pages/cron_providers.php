<?php
include("config.php");
include("functions.php");

$today = date("Y-m-d h:i:s A");


$sql= "select * from ct_settings WHERE parameter_type = 'provider' and parameter_name='source_country' ";
$result = mysqli_query($link,$sql);
$data = mysqli_fetch_assoc($result);

if($data===null)
{
    $sql= "insert into ct_settings (parameter_type, parameter_name, parameter_value, created_at) values('provider','source_country','AED', '$today')";
    $result = mysqli_query($link,$sql);
}
else
{
    $current_index = $data['parameter_value'];
    $next_index='';
    
    $country_sql= "select * from ct_country order by currency_code asc";
    
    $country_result = mysqli_query($link,$country_sql);
    $country_data = mysqli_fetch_all($country_result);
    $country = array();
    $currency = array();

    foreach($country_data as $dt)
    {
        $country[$dt[3]]=$dt[2];
        $currency[]=$dt[3];
    }

    $current_key = array_search($current_index, $currency);
    $next_key =  $current_key+1;
    if($next_key>=count($currency)) 
    {
        $next_key=0;
        
        $loop_sql= "select * from ct_settings WHERE parameter_type = 'provider' and parameter_name='loop' ";
        $loop_result = mysqli_query($link,$loop_sql);
        $loop_data = mysqli_fetch_assoc($loop_result);

        if($loop_data===null)
        {
            $loop_insert_sql= "insert into ct_settings (parameter_type, parameter_name, parameter_value, created_at) values('provider','loop','1', '$today')";
            $loop_insert_result = mysqli_query($link,$loop_insert_sql);
        }
        else
        {
            $loop_count = $loop_data['parameter_value']+1;
            $loop_update_sql= "update ct_settings set parameter_value='$loop_count', updated_at='$today' WHERE parameter_type = 'provider' and parameter_name='loop' ";
            $loop_update_result = mysqli_query($link,$loop_update_sql);
        }
    }
        
    
    $next_index = $currency[$next_key];
    
    $sa = $current_index;
    $target_array = $currency; 
    $i=0;
    
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
			
			foreach ($my_data->providers as $pd)
			   {

                   $alias=check_alias($pd->alias);
                   $info = $country[$sa]." => ".$country[$ta];
                   if($alias==0) 
                   {
                       
                       $sql2 = "insert into ct_provider (name,alias,link,logo,info,created_at) value( '" . 
                        $pd->name . "', '".
                        $pd->alias . "', 'https://wise.com', '". 
                        $pd->logo . "', '".
                        $info. "', '".   
                        $today . "') ";

                        $result2 = mysqli_query($link,$sql2);
                       
                       $new_insert_sql= "insert into ct_settings (parameter_type, parameter_name, parameter_value, info, created_at, updated_at) values('provider','new','$pd->alias','$info', '$today', '$today')";
                        $new_insert_result = mysqli_query($link,$new_insert_sql);
                   }
				   $i++;
			   }
		}
	}
    
   $info = ($next_key+1).") => ".$country[$next_index];
    
    $sql= "update ct_settings set parameter_value='$next_index', info='$info', updated_at='$today' WHERE parameter_type = 'provider' and parameter_name='source_country' ";
    $result = mysqli_query($link,$sql);

}

?>