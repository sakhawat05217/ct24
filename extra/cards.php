<!DOCTYPE html>
<html lang="en">
<head>
<title>CT24</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,shrink-to-fit=no">

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

</head>

<body>
<br><br>	
<?php

$url = "https://api.transferwise.com/v3/comparisons/?sourceCurrency=SGD&targetCurrency=BDT&sendAmount=100";

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
		
?>
    <div class="card">
    
     <h3 class="card-title" align="center">
     Found <?= count($my_data->providers) ?> Remittance Service Providers
     </h3>
    
   <?php
   foreach ($my_data->providers as $pd)
   {
	    $web_arr = get_web($pd->alias);
		$web = $web_arr['link'];
		
		$png_logo = $pd->logos->normal->pngUrl;
		
		$rate = $pd->quotes[0]->rate;
		$fee = $pd->quotes[0]->fee;
		$receivedAmount = $pd->quotes[0]->receivedAmount;
	   
   ?> 
    
    <div class="card-body example">

		<div class="row">
		
			
			<div class="col-lg-5">
            
            <img width="300px" src="<?= $png_logo ?>" alt="logo">

			</div>
            
            <div class="col-lg-5">
				<?= "Rate: ".$rate.", Fee: ".$fee. ", Amount Received: ".$receivedAmount ?>	
			</div>
            
            <div class="col-lg-2">
            <br><br>
				<a href="<?= $web ?>" target="_blank" class="btn btn-success">Send money now</a>
			</div>
						
	
			
		</div>
       
       </div>
       
       <br><br>
       
   <?php
   	}
   ?>
        
	</div>

</body>

</html>