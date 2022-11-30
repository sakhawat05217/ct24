<?php
$updated_at = "2022-04-01";
echo $updated_at."<br>";
    
$now   = new DateTime();
$my_date = new DateTime($updated_at);
$diff=date_diff($my_date,$now);
$diff_days = $diff->format("%a");
echo "diff_days:".$diff_days."<br>";