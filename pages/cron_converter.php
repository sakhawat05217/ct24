<?php
include("config.php");
include("functions.php");


$today = date("Y-m-d h:i:s A");

$source_country = get_settings('currency_converter','source_country');        

$sql= 'select * from ct_currency_converter';
$result = mysqli_query($link,$sql);
$data = mysqli_fetch_all($result);

if(null!==$data)
{
    
    $step_sql= "select * from ct_settings WHERE parameter_type = 'currency_converter' and parameter_name='step' ";
    $step_result = mysqli_query($link,$step_sql);
    $step_data = mysqli_fetch_assoc($step_result);

    if($step_data===null)
    {
        $step_insert_sql= "insert into ct_settings (parameter_type, parameter_name, parameter_value, created_at) values('currency_converter','step','1', '$today')";
        $step_insert_result = mysqli_query($link,$step_insert_sql);
    }
    
    
    $country_count = count($data);
    $step = get_settings('currency_converter','step');
    
   if($step==1)
   {
       for($i=0;$i<71;$i++)
        {
            $converter_id=$data[$i][0];
            $target_country=$data[$i][1];

            $current_rate = get_current_rate(1,$source_country,$target_country);

            $sql2 = "insert into ct_view_currency_converter (converter_id,mid_rate,created_at) value( " . 
            $converter_id . ", ".
            $current_rate . ", '".
            $today . "') ";

            $result2 = mysqli_query($link,$sql2);

            if($target_country=='BD')
            {
                $sql3 = "insert into ct_converter_bd (converter_id,mid_rate,created_at) value( " . 
                $converter_id . ", ".
                $current_rate . ", '".
                $today . "') ";

                $result3 = mysqli_query($link,$sql3);
            }
        } 
       $step=2;
   }
   else if($step==2)
   {
       
       for($i=71;$i<$country_count;$i++)
        {
            $converter_id=$data[$i][0];
            $target_country=$data[$i][1];
           
            $current_rate = get_current_rate(1,$source_country,$target_country);

            $sql2 = "insert into ct_view_currency_converter (converter_id,mid_rate,created_at) value( " . 
            $converter_id . ", ".
            $current_rate . ", '".
            $today . "') ";

            $result2 = mysqli_query($link,$sql2);

            if($target_country=='BD')
            {
                $sql3 = "insert into ct_converter_bd (converter_id,mid_rate,created_at) value( " . 
                $converter_id . ", ".
                $current_rate . ", '".
                $today . "') ";

                $result3 = mysqli_query($link,$sql3);
            }
        }
       $step=1;
   } 
    
    $step_update_sql= "update ct_settings set parameter_value='$step', updated_at='$today' WHERE parameter_type = 'currency_converter' and parameter_name='step' ";
    $step_update_result = mysqli_query($link,$step_update_sql);

}

$current_day = date("Y-m-d");
$nine_day = date('Y-m-d', strtotime($current_day. " - 9 days"));
//echo $current_day."<br>".$nine_day;exit;

$delete_old_sql= "delete from ct_view_currency_converter where  created_at < '$nine_day'";
$delete_old_result = mysqli_query($link,$delete_old_sql);

?>