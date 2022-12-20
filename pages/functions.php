<?php

function add_settings($parameter_type,$parameter_name,$parameter_value,$info)
{
	include("config.php");
    $date = date("Y-m-d h:i:s A");
    
    $status = get_settings($parameter_type,$parameter_name);
    
    if($status!=null)
    {
        $sql = "update ct_settings set 
        parameter_value = '" . $parameter_value . "',
        info = '" . $info . "'
        where parameter_type = '".$parameter_type . "' and 
        parameter_name = '" .	$parameter_name . "'";
    }
    else
    {
        $sql = "insert into ct_settings (parameter_type,parameter_name,parameter_value,info,created_at) value( '" . 
		$parameter_type . "', '".
		$parameter_name . "', '".
		$parameter_value . "', '".
        $info . "', '".    
		$date . "') ";
    }
	
	

	mysqli_query($link,$sql);
}

function check_alias($alias)
{
	include("config.php");
	
	$sql= 'select * from ct_provider WHERE alias = "' . $alias . '"';
	$result = mysqli_query($link,$sql);
	$alias_data = mysqli_fetch_array($result);

    $get_alias=0;
    if($alias_data!==null) $get_alias=1;
	return $get_alias;
}

function check_ip($ip)
{
	include("config.php");
	
	$sql= 'select ip from ct_new_users WHERE ip = "' . $ip . '"';
	$result = mysqli_query($link,$sql);
	$ip_data = mysqli_fetch_row($result);

    $get_ip=0;
    if($ip_data!==null) $get_ip=1;
	return $get_ip;
}

function check_user($email)
{
	include("config.php");
	
	$sql= 'select * from ct_users WHERE email = "' . $email . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	$user=0;
    if($data!==null) $user=1;
	return $user;
}

function get_client_ip() 
{
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'unknown';
		
	return $ipaddress;
}

function get_column($column_name,$sid,$s_str,$row_limit)
{
	$column_title=$column_name;
	if($column_name=='date') $column_name = 'created_at';
	
	if(strpos($column_title,"_")>0)
	{
		$column_title = str_replace("_"," ",$column_title);
	}
	
	if($column_title=='ip') $column_title = 'IP';
    
    if($row_limit=='') $row_limit = 30;
	
	return "<a href='?li=$row_limit&s_type=$column_name&s_order=asc&sid=$sid&s_str=$s_str'><span id='$column_name"."_"."asc' class='arr'>&darr; </span></a>" . ucwords($column_title) . "<a href='?li=$row_limit&s_type=$column_name&s_order=desc&sid=$sid&s_str=$s_str'><span id='$column_name"."_"."desc' class='arr'> &uarr;</span></a>";
}

function get_controls($parameter_type,$parameter_name,$info)
{
	$parameter_value = "";
	include("config.php");
	
	$sql= "select * from ct_settings WHERE parameter_type = '$parameter_type' and parameter_name='$parameter_name' and info='$info'";
	$result = mysqli_query($link,$sql);
	$setting_data = mysqli_fetch_array($result);
	
	if($setting_data!==null)
	{
        $parameter_value = $setting_data['parameter_value'];
	}
	
	return $parameter_value;
}

function get_country()
{
	include("config.php");
	$email = $_SESSION['ct_myuser'];
	
	$sql= 'select * from ct_users WHERE email = "' . $email . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	
	$send_amount = $data['send_amount'];
	$send_country = $data['send_country'];
	$receive_country = $data['receive_country'];
	
	return $send_amount.",".$send_country.",".$receive_country;
}

function get_country_code($country_name)
{
	
	include("config.php");
	
	$sql= "select * from ct_country where country_name like '%$country_name%'";
    
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	$country_code='US';
	if($data!==null)
	{
		$country_code = $data['country_code'];
	}
	
	return $country_code;
}

function get_country_tk($country_code)
{
	$country['name'] = "United States";
	$country['tk'] = "USD";
	$country['taka'] = "United States Dollar";
	
	include("config.php");
	
	$sql= 'select * from ct_country WHERE country_code = "' . $country_code . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	
	if($data!==null)
	{
		$country['name'] = $data['country_name'];
		$country['tk'] = $data['currency_code'];
		$country['taka'] = $data['currency_name'];
	}
	
	return $country;
}

function get_current_rate($send_amount,$send_country,$receive_country)
{
    include("config.php");
    
    if($send_country==$receive_country) return 0;
    
    $send_country_arr = get_country_tk($send_country);
    $send_country_tk = $send_country_arr['tk']; 
    $receive_country_arr = get_country_tk($receive_country);
    $receive_country_tk = $receive_country_arr['tk'];
    
    $url = "https://api.sandbox.transferwise.tech/v1/rates?source=$send_country_tk&target=$receive_country_tk";

    $headers = array(
    'Content-Type:application/json',
    'Authorization: Bearer 4825bc9e-1165-4fc2-9190-7ebc5dab8a7a' 
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $my_data = json_decode($result);
    
    if(is_array($my_data))
    {
        $my_rate = round(floatval($my_data[0]->rate), 4);
    }
    else
    {
        $my_rate=0;
    }

    return $my_rate;
    
}

function get_ip_data()
{
    $data='';    
    //$ip_data = @json_decode(file_get_contents(get_settings('ip','ip_plugin').get_client_ip()));
    //http://www.geoplugin.net/json.gp?ip=
    //$data="$ip_data->geoplugin_region, $ip_data->geoplugin_city, $ip_data->geoplugin_countryName";
    
    if( $_SERVER['HTTP_HOST']!='localhost')
    {
        $ip_data = @unserialize(file_get_contents(get_settings('ip','ip_plugin').get_client_ip()));
        @$data=$ip_data['regionName'].', '.$ip_data['city'].', '.$ip_data['country'];
    }
    
    return $data;
    
    /*
    Array
    (
        [status] => success
        [country] => Bangladesh
        [countryCode] => BD
        [region] => C
        [regionName] => Dhaka Division
        [city] => Paltan
        [zip] => 1000
        [lat] => 23.7362
        [lon] => 90.4143
        [timezone] => Asia/Dhaka
        [isp] => BANGLALINK
        [org] => Banglalink Digital Communications Ltd
        [as] => AS45245 Banglalink Digital Communications Ltd
        [query] => 116.58.203.162
    )
    */
}

function get_ip_link($ip)
{
    $new_ip = '<a href="'.get_settings('ip','ip_location').$ip.'" target="_blank">'.$ip.'</a>';
    return $new_ip;
}

function get_providers($send_amount,$send_country,$receive_country)
{
    include("config.php");
    $provider_data = array();
	$rate_arr = array();
    $providers = array();
    
    $send_country_arr = get_country_tk($send_country);
    $send_country_tk = $send_country_arr['tk']; 
    $receive_country_arr = get_country_tk($receive_country);
    $receive_country_tk = $receive_country_arr['tk'];
    
    $url = "https://api.transferwise.com/v3/comparisons/?sourceCurrency=$send_country_tk&targetCurrency=$receive_country_tk&sendAmount=$send_amount";
	
	$headers = array(
		'Content-Type:application/json'
	);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	
	$my_data = json_decode($result);
    
    $i=0;
    
    foreach ($my_data->providers as $pd)
    {
        $alias = $pd->alias;
        $provider_data[$i]['id'] = 0;
        $provider_data[$i]['speed'] = '4-5 business days';
        $provider_data[$i]['alias'] = $alias;
        $provider_data[$i]['rate'] = $pd->quotes[0]->rate;
        $provider_data[$i]['fee'] = $pd->quotes[0]->fee;
        $rate_arr[$i] = $provider_data[$i]['received_amount'] = $pd->quotes[0]->receivedAmount;
        
        $web_link='https://wise.com';
        $new_data = get_web($alias);
        if(!empty($new_data['link'])) 
        {
            $web_link=$new_data['link'];
            $provider_data[$i]['id'] = $new_data['id'];
            $provider_data[$i]['speed'] = $new_data['speed'];
        }
        $provider_data[$i]['web'] = $web_link;

        if($alias=='aspire-bank') 
        {
            $my_link = "<a href='$web_link' target='_blank'>link</a>";
            $provider_data[$i]['web_info'] = "* Business Users Only.</br>Open account using this $my_link to recieve awards. E-mail <a href='mailto:support@ct-24.com'>support@ct-24.com</a> after account is opened.";
            $provider_data[$i]['active_class'] = 'provider_active';
        }
        else 
        {    
            $provider_data[$i]['web_info'] = '';
            $provider_data[$i]['active_class'] = '';
        }
        
        $provider_data[$i]['png_logo'] = $pd->logos->normal->pngUrl;
        $i++;
    }
		
    
    if(count($my_data->providers)>0)
    {
        
        //Start of instarem
        
         $url = "https://www.instarem.com/api/v1/public/transaction/computed-value?source_currency=$send_country_tk&source_amount=$send_amount&destination_currency=$receive_country_tk";

        $headers = array(
            'Content-Type:application/json'
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $instarem_data = json_decode($result);
        $alias = 'instarem';
        
        if(@$instarem_data->data->destination_amount!==null)
        {    
            $provider_data[$i]['id'] = 0;
            $provider_data[$i]['speed'] = '4-5 business days';
            $provider_data[$i]['alias'] = $alias;
            $provider_data[$i]['rate'] = $instarem_data->data->instarem_fx_rate;
            $provider_data[$i]['fee'] = floatval($instarem_data->data->margin_percent)*10;
            $rate_arr[$i] = $provider_data[$i]['received_amount'] = $instarem_data->data->destination_amount;


            $png_logo = '';
            $web_link='https://www.instarem.com';
            $new_data = get_web($alias);
            if(!empty($new_data['link'])) 
            {
                $web_link=$new_data['link'];
                $provider_data[$i]['id'] = $new_data['id'];
                $png_logo = $new_data['logo'];
                $provider_data[$i]['speed'] = $new_data['speed'];
            }
            $my_link = "<a href='$web_link' target='_blank'>link</a>";
            $provider_data[$i]['web'] = $web_link;
            $provider_data[$i]['web_info'] = "</br>Open account using this $my_link to recieve awards. E-mail <a href='mailto:support@ct-24.com'>support@ct-24.com</a> after account is opened.";
            $provider_data[$i]['active_class'] = 'provider_active';

            $provider_data[$i]['png_logo'] = $png_logo;

            $i++;
        }
        
        //End of instarem
        
    }
    
	
	 
	arsort($rate_arr);	
    
    $i=0;
    foreach ($rate_arr as $k=>$v)
    {
	    $providers[$i]['id'] = $provider_data[$k]['id'];
        $providers[$i]['alias'] = $provider_data[$k]['alias'];
        $providers[$i]['rate'] = $provider_data[$k]['rate'];
		$providers[$i]['fee'] = $provider_data[$k]['fee'];
		$providers[$i]['received_amount'] = $provider_data[$k]['received_amount'];
		$providers[$i]['web'] = $provider_data[$k]['web'];
        $providers[$i]['web_info'] = $provider_data[$k]['web_info'];
        $providers[$i]['active_class'] = $provider_data[$k]['active_class'];
		$providers[$i]['png_logo'] = $provider_data[$k]['png_logo'];
        $providers[$i]['speed'] = $provider_data[$k]['speed'];
        $i++;
    }
    
    return $providers;
}

function get_settings($parameter_type,$parameter_name)
{
	$parameter_value = "";
	include("config.php");
	
	$sql= "select * from ct_settings WHERE parameter_type = '$parameter_type' and parameter_name='$parameter_name'";
	$result = mysqli_query($link,$sql);
	$setting_data = mysqli_fetch_array($result);
	
	if($setting_data!==null)
	{
        $parameter_value = $setting_data['parameter_value'];
	}
	
	return $parameter_value;
}

function get_user()
{
	include("config.php");
	$email = $_SESSION['ct_myuser'];
	
	$sql= 'select * from ct_users WHERE email = "' . $email . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
	
	return $data;
}

function get_user_link($user_name)
{
    if(strpos($user_name,"@")>0) 
	{
		$user_name = '<a href="user.php?p=1&li=10&sid=eid&s_str='.$user_name.'" target="_blank">'.$user_name.'</a>';
	}
    
    return $user_name; 
}

function is_admin()
{
    include("config.php");
	$email = $_SESSION['ct_myuser'];
	$sql= 'select * from ct_users WHERE email = "' . $email . '"';
	$result = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($result);
 	$user=0;
    if(@$data['role']==0) $user=1;
 	return $user;
}

function get_web($alias)
{
	$web['link'] = "https://wise.com";
	$web['name'] = "Wise";
    $web['id'] = 0;
	$web['logo'] = '';
    $web['speed'] = '4-5 business days';
	
	include("config.php");
	
	$sql= 'select * from ct_provider WHERE alias = "' . $alias . '"';
	$result = mysqli_query($link,$sql);
	$web_data = mysqli_fetch_array($result);
	
	if($web_data!==null)
	{
		
        $web['id'] = $web_data['id'];
        $web['name'] = $web_data['name'];
        $web['link'] = $web_data['link'];
		$web['logo'] = $web_data['logo'];
        $web['speed'] = $web_data['speed'];
	}
	
	return $web;
}

function save_country($send_amount, $send_country, $receive_country)
{
	include("config.php");
	$email = $_SESSION['ct_myuser'];
	
	 $sql = "update ct_users set 
	 
	 send_amount = " . $send_amount . ", 
	 
	 send_country = '" . $send_country . "',
	 
	 receive_country = '" . $receive_country . "'
	 
	 where  email = '". $email."'";
	 
	 $result = mysqli_query($link,$sql);
	 
	 $date = date("Y-m-d h:i:s A");
	 
	 save_history($email,$send_amount, $send_country, $receive_country);

}

function save_history($user_name,$send_amount, $send_country, $receive_country)
{
	include("config.php");
	 
	 $date = date("Y-m-d h:i:s A");

	 $send_country_name = get_country_tk($send_country);
	 $receive_country_name = get_country_tk($receive_country);
	 $ip = get_client_ip();
	 $server = $_SERVER['HTTP_HOST'];
    
     $ip_data = @unserialize(file_get_contents(get_settings('ip','ip_plugin').$ip));
     $user_country=@$ip_data['country'];
     if($user_country=='') $user_country='Singapore';
 
	 $sql = "insert into ct_history (user_name,send_country,receive_country,send_amount,ip,server,created_at,user_country) value( '" . 
		$user_name . "', '".
		$send_country_name['name'] . "', '".
		$receive_country_name['name'] . "', '".
		$send_amount . "', '".
		$ip . "', '".
		$server . "', ". 
		"'". $date . "', ". 
		"'". $user_country . "') ";
	$result = mysqli_query($link,$sql);
    
    
}

function save_log($parameter_name,$parameter_value, $info)
{
	 include("config.php");
	 
	 $date = date("Y-m-d h:i:s A");
 
	 $sql = "insert into ct_log (parameter_name,parameter_value,info,created_at) value( '" . 
		$parameter_name . "', '".
		$parameter_value . "', '".
		addslashes($info) . "', '". $date . "') ";
    
	$result = mysqli_query($link,$sql);
    
    $ip = get_client_ip();
    $check_ip = check_ip($ip);
    if($check_ip == 0)
    {
        if(isset($_SESSION['ct_myuser']))
        {
            $user_name = $_SESSION['ct_myuser'];
        }
        else
        {
            $user_name = 'Guest';
        }
        
        $ip_data = @unserialize(file_get_contents(get_settings('ip','ip_plugin').$ip));
        $country=@$ip_data['country'];
        if($country=='') $country='Singapore';
	    
        $server = $_SERVER['HTTP_HOST'];
        
        $sql = "insert into ct_new_users (user_name,ip,country,server,created_at) value( '" . 
		$user_name . "', '".
		$ip . "', '".
        $country . "', '".    
		$server . "', ". 
		"'". $date . "') ";
	   $result = mysqli_query($link,$sql);
    }
}

function set_comma($price)
{
    $arr_price = explode(".",$price);
    
    if(@$arr_price[1]!=null) 
    {
        $float_val = $arr_price[1];
    }
    else $float_val = "00";
    
    $price = intval($arr_price[0]);
    $negative = 0;
    if($price<0)
    {
        $negative = 1;
        $price = (-1)*$price;
    }
    
    $rev_price = strrev($price);
    $new_price = '';
    
    $step=0;
 
    for($i=0;$i<strlen($rev_price);$i++)
    {
        $step++;
        if($step%3==0) $new_price .= $rev_price[$i].",";
        else $new_price .= $rev_price[$i];
    }

    if($new_price[strlen($new_price)-1]==',')
    {
        $new_price[strlen($new_price)-1]=' ';
    }

    $new_price = strrev($new_price);

    
    if($negative) $new_price = '-'.$new_price;
    
    $new_price = $new_price.".".$float_val;
 
    return $new_price;
}

?>