<?php
include("config.php");
include("functions.php");

$today = date("Y-m-d h:i:s A");

$sql= 'select * from ct_data_collection WHERE watch_status = 1';
$result = mysqli_query($link,$sql);
$data = mysqli_fetch_all($result);

foreach($data as $dt)
{
    $data_id=$dt[0];
    $send_country=$dt[2];
    $receive_country=$dt[3];
    $send_amount=$dt[4];
    $watch_till=$dt[5];
    $created_at=$dt[7];
    
    $now   = new DateTime();
    $my_date = new DateTime($created_at);
    $diff=date_diff($my_date,$now);
    $diff_days = $diff->format("%a");
    
    if($diff_days>=$watch_till)
    {
        $sql2= 'update ct_data_collection set watch_status = 0, updated_at = "'.$today.'" WHERE id = '.$dt[0];
        $result2 = mysqli_query($link,$sql2);
    }
    else if($send_country!=$receive_country)
    {
        $send_country_arr = get_country_tk($send_country);
        $send_country_tk = $send_country_arr['tk']; 
        $receive_country_arr = get_country_tk($receive_country);
        $receive_country_tk = $receive_country_arr['tk'];
        
       $providers = get_providers($send_amount, $send_country, $receive_country);
        
        foreach ($providers as $pd)
   		{
            $mid_rate = round($pd['rate'],4);
			$fee = round($pd['fee'],4);
			$received_amount = round($pd['received_amount'],4);
            $web = get_web($pd['alias']);
            $provider_name = $web['name'];
            $provider_link = $web['link'];
        
            $sql2 = "insert into ct_view_data_collection (data_id,provider_name,provider_link,received_amount,mid_rate,fee,created_at) value( " . 
            $data_id . ", '".
            $provider_name . "', '".
            $provider_link . "', '".
            $received_amount . "', ".
            $mid_rate . ", ".    
            $fee . ",  '".
            $today . "') ";

            $result2 = mysqli_query($link,$sql2);
            
        }
        
    
    }
    
}

$sql= 'select * from ct_alert WHERE send_status = 0';
$result = mysqli_query($link,$sql);
$data = mysqli_fetch_all($result);

foreach($data as $dt)
{
    
    $email=$dt[2];
    $send_country=$dt[3];
    $receive_country=$dt[4];
    $max_rate=$dt[5];
    $watch_till=$dt[6];

    $send_country_arr = get_country_tk($send_country);
    $send_country_tk = $send_country_arr['tk']; 
    $receive_country_arr = get_country_tk($receive_country);
    $receive_country_tk = $receive_country_arr['tk'];
    
    $my_rate = get_current_rate(1,$send_country,$receive_country);
    
 	
    if(floatval($my_rate)!=floatval($max_rate))
    {
        
        
        $msg_body ="<h1>Today's ". $send_country_arr['taka'] ." to ". $receive_country_arr['taka'] ." rate is: <br> 1 $send_country_tk = $my_rate $receive_country_tk </h1>"."\r\n";
         
        $to = $email;
        $subject = 'Exchange rates';
        $from = 'support@ct-24.com';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$from."\r\n".
            'X-Mailer: PHP/' . phpversion();
        
        //echo $msg_body;
        //exit;
        
        mail($to, $subject, $msg_body, $headers);

        $sql2= 'update ct_alert set send_status = 1, updated_at = "'.$today.'" WHERE id = '.$dt[0];
        $result2 = mysqli_query($link,$sql2);
    }
     
}


$sql3= 'select * from ct_alert WHERE send_status = 1';
$result3 = mysqli_query($link,$sql3);
$data3 = mysqli_fetch_all($result3);

foreach($data3 as $dt3)
{
    $updated_at = $dt3[9];
    $watch_till=$dt3[6];
    $to = $dt3[2];
    $from = 'support@ct-24.com';
 
    $send_country=$dt3[3];
    $receive_country=$dt3[4];
    $send_country_arr = get_country_tk($send_country);
    $send_country_tk = $send_country_arr['tk']; 
    $receive_country_arr = get_country_tk($receive_country);
    $receive_country_tk = $receive_country_arr['tk'];
    
    $my_rate = get_current_rate(1,$send_country,$receive_country);
    
    $now   = new DateTime();
    $my_date = new DateTime($updated_at);
    $diff=date_diff($my_date,$now);
    $diff_days = $diff->format("%a");
    
    if($diff_days>=$watch_till)
    {
        $msg_body ="<h1>Today's ". $send_country_arr['taka'] ." to ". $receive_country_arr['taka'] ." rate is: <br> 1 $send_country_tk = $my_rate $receive_country_tk </h1>"."\r\n";
        $subject = 'Exchange rates';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$from."\r\n".
            'X-Mailer: PHP/' . phpversion();
        
        mail($to, $subject, $msg_body, $headers);
        
        $msg_body ="<h1>Alert expired.</h1><br>\r\n";
        
        $msg_body .="<h3>We have stopped watching your alert. Please set a new alert in below link.</h3><br>\r\n";
        $msg_body .= "<a target='_blank' href='https://www.ct-24.com/alert.php'>Create Alert</a><br>\r\n" ;
        $msg_body .="<br>Thanks<br>\r\n";
        $msg_body .="CT24 Support<br>\r\n";
        
        $subject = 'Alert expired';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$from."\r\n".
            'X-Mailer: PHP/' . phpversion();
        
        //echo $msg_body;
        //exit;
        
        mail($to, $subject, $msg_body, $headers);
        
        $sql4= 'delete from ct_alert WHERE id = '.$dt3[0];
        $result4 = mysqli_query($link,$sql4);
    }
    
  
}

?>