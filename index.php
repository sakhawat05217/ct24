<?php
include("pages/header.php");

$value = get_settings('controls','home_trans');
$home_trans = ($value==null)?0:$value;

$send_amount = 1000;
$send_country = 'SG';
$receive_country = 'IN';

$my_ip = get_client_ip();
$value = get_controls('controls','extra_param',$my_ip);
$extra_param = ($value==null)?'a':$value;

if($home_trans==0) $extra_param = 'a';


?>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0">
       	 <div class="text-primary">Currency Transfer 24 hours. <span class="text-white">Find the best remittance rates.</span></div>
        </h1>
    </div>
</div>
<br><br>	
<?php 


$ip = get_ip_link(get_client_ip());
$server = $_SERVER['HTTP_HOST'];
$ip_data = get_ip_data();

if(isset($_SESSION['ct_myuser']))
{
	$get_country = get_country();
	$c_arr = explode(",",$get_country);
	
	$send_amount = $c_arr[0];
	$send_country = $c_arr[1];
	$receive_country = $c_arr[2];
	//echo $send_amount.$send_country.$receive_country;
    $user_name = get_user_link($_SESSION['ct_myuser']);
    
    $info = "$user_name is in the home page now. $ip_data, $ip";
    save_log('Home Page',$server, $info);
}
else
{
    $info = "Guest is in the home page now. $ip_data, $ip";
    save_log('Home Page',$server, $info);
}

//exit;

?>
<input type="hidden" value="<?= $extra_param ?>" id="extra_param">

    <div class="">
    
    <div class="card-body example">
	
    <form method="post" action="compare.php" class="form-group">
    <input type="hidden" id="rate">
    <input type="hidden" id="ajax_load">	
    
		<div class="row">
		
			
			<div class="col-lg-5">
            <div id="info"></div>
					<h4>You Send</h4>
				    <input onKeyUp="ShowExchangeRate()" value="<?= $send_amount ?>" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control my_text"  name="send_amount" id="send_amount">
					<select onChange="ShowExchangeRate()" name="send_country" id="send_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="<?= $send_country ?>"></select>
			</div>
            
            <div class="col-lg-5">
					<h4>Recipient Gets</h4>
				    <input type="text" class="form-control my_text" readonly name="receive_amount" id="receive_amount">
					<select onChange="ShowExchangeRate()" name="receive_country" id="receive_country" class="selectpicker countrypicker" data-live-search="true" data-flag="true" data-default="<?= $receive_country ?>"></select>
					
			</div>
            
            <div class="col-lg-2">
            <br><br>
				<input type="button" onclick="compare_rate();" value="Search" class="btn btn-primary">
			</div>
						
	
			
		</div>
       
       </form> 
       
       </div>
        
	</div>

<br><br>
<div class="container-fluid">
  <div class="row">
      
    <div class="col-xl">
      <div class="card" style="border: none;">
       <div style="padding-left: 10px;">
            <img style="border: 1px solid !important;" src="img/flags/uk.png" alt="UK" width="50px" height="35px">
             &nbsp;&nbsp;&nbsp;
            <img style="border: 1px solid !important;" src="img/flags/singapore.png" alt="Singapore" width="50px" height="35px">
       </div>
      <div class="card-body">
        <h5 class="card-title">
         
            <a target="_blank" href="compare.php?str=1000.GB.SG#my_top">
                <div _ngcontent-faj-c22="" class="card"><div _ngcontent-faj-c22="" class="card-body"><div _ngcontent-faj-c22="" class="d-flex align-items-center mb-2 flags-row"><div _ngcontent-faj-c22="" class="d-inline-block mr-3 fl us"></div><div _ngcontent-faj-c22="" class="d-inline-block fl mx"></div></div><div _ngcontent-faj-c22="" class="f-14 text-greyish-blue f-w-500">Transfer money</div><div _ngcontent-faj-c22="" class="f-14 text-greyish-blue f-w-500 second-line"> from UK to Singapore from </div><div _ngcontent-faj-c22="" class="text-secondary font-weight-bold l-h-1-2 rate"><h3><?= get_current_rate(1,'GB','SG') ?></h3></div><div _ngcontent-faj-c22="" class="text-greyish-blue font-weight-bold"><span translate="no"> SGD </span> / <span translate="no"> GBP </span></div></div></div>
            </a>
            
        </h5>
      </div>
    </div>
    </div>
      
    <div class="col-xl">
      <div class="card" style="border: none;">
       <div style="padding-left: 10px;">
            <img style="border: 1px solid !important;" src="img/flags/usa.png" alt="USA" width="50px" height="35px">
             &nbsp;&nbsp;&nbsp;
            <img style="border: 1px solid !important;" src="img/flags/india.png" alt="India" width="50px" height="35px">
       </div>
      <div class="card-body">
        <h5 class="card-title">
         
            <a target="_blank" href="compare.php?str=1000.US.IN#my_top">
                <div _ngcontent-faj-c22="" class="card"><div _ngcontent-faj-c22="" class="card-body"><div _ngcontent-faj-c22="" class="d-flex align-items-center mb-2 flags-row"><div _ngcontent-faj-c22="" class="d-inline-block mr-3 fl us"></div><div _ngcontent-faj-c22="" class="d-inline-block fl mx"></div></div><div _ngcontent-faj-c22="" class="f-14 text-greyish-blue f-w-500">Transfer money</div><div _ngcontent-faj-c22="" class="f-14 text-greyish-blue f-w-500 second-line"> from USA to India from </div><div _ngcontent-faj-c22="" class="text-secondary font-weight-bold l-h-1-2 rate"><h3><?= get_current_rate(1,'US','IN') ?></h3></div><div _ngcontent-faj-c22="" class="text-greyish-blue font-weight-bold"><span translate="no"> INR </span> / <span translate="no"> USD </span></div></div></div>
            </a>
            
        </h5>
      </div>
    </div>
    </div>
      
    <div class="col-xl">
      <div class="card" style="border: none;">
       <div style="padding-left: 10px;">
            <img style="border: 1px solid !important;" src="img/flags/singapore.png" alt="Singapore" width="50px" height="35px">
             &nbsp;&nbsp;&nbsp;
            <img style="border: 1px solid !important;" src="img/flags/india.png" alt="India" width="50px" height="35px">
       </div>
      <div class="card-body">
        <h5 class="card-title">
         
            <a target="_blank" href="compare.php?str=1000.SG.IN#my_top">
                <div _ngcontent-faj-c22="" class="card"><div _ngcontent-faj-c22="" class="card-body"><div _ngcontent-faj-c22="" class="d-flex align-items-center mb-2 flags-row"><div _ngcontent-faj-c22="" class="d-inline-block mr-3 fl us"></div><div _ngcontent-faj-c22="" class="d-inline-block fl mx"></div></div><div _ngcontent-faj-c22="" class="f-14 text-greyish-blue f-w-500">Transfer money</div><div _ngcontent-faj-c22="" class="f-14 text-greyish-blue f-w-500 second-line"> from Singapore to India from</div><div _ngcontent-faj-c22="" class="text-secondary font-weight-bold l-h-1-2 rate"><h3><?= get_current_rate(1,'SG','IN') ?></h3></div><div _ngcontent-faj-c22="" class="text-greyish-blue font-weight-bold"><span translate="no"> INR </span> / <span translate="no"> SGD </span></div></div></div>
            </a>
            
        </h5>
      </div>
    </div>
    </div>
      
    <div class="col-xl">
      <div class="card" style="border: none;">
       <div style="padding-left: 10px;">
            <img style="border: 1px solid !important;" src="img/flags/usa.png" alt="USA" width="50px" height="35px">
             &nbsp;&nbsp;&nbsp;
            <img style="border: 1px solid !important;" src="img/flags/singapore.png" alt="Singapore" width="50px" height="35px">
       </div>
      <div class="card-body">
        <h5 class="card-title">
         
            <a target="_blank" href="compare.php?str=1000.US.SG#my_top">
                <div _ngcontent-faj-c22="" class="card"><div _ngcontent-faj-c22="" class="card-body"><div _ngcontent-faj-c22="" class="d-flex align-items-center mb-2 flags-row"><div _ngcontent-faj-c22="" class="d-inline-block mr-3 fl us"></div><div _ngcontent-faj-c22="" class="d-inline-block fl mx"></div></div><div _ngcontent-faj-c22="" class="f-14 text-greyish-blue f-w-500">Transfer money</div><div _ngcontent-faj-c22="" class="f-14 text-greyish-blue f-w-500 second-line"> from USA to Singapore from </div><div _ngcontent-faj-c22="" class="text-secondary font-weight-bold l-h-1-2 rate"><h3><?= get_current_rate(1,'US','SG') ?></h3></div><div _ngcontent-faj-c22="" class="text-greyish-blue font-weight-bold"><span translate="no"> SGD </span> / <span translate="no"> USD </span></div></div></div>
            </a>
            
        </h5>
      </div>
    </div>
    </div>
      
  </div>
</div>


    
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            <img src="img/about.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
            <h3>CT24 helps Individuals and Companies access best Forex rates.</h3>
            <p class="fst-italic">
              Compare rates across numerous money transfer providers with a single click.
            </p>
            
          </div>
        </div>

      </div>
    </section>

<br><br>

<div class="container-fluid">
  <div class="row">
      
    <div class="col-xl">
      <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
      <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"/>
      <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"/>
    </svg>
        
      <h3>Save Time and Money</h3>  
        
       <p>Search and compare money transfer rates from various banks, money transfer operators and companies to provide you accurate information in one spot.</p> 
        
    </div>
      
    <div class="col-xl">
      
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
          <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
        </svg>
        <h3>Exchange Rate Alerts</h3>  
        
       <p>Create custom rate alerts to get precise rate information on the go. You choose when (day and time) and how (email) to get alerted.</p> 
    </div>
      
    <div class="col-xl">
      
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
        </svg>
        
        <h3>Stay updated anywhere</h3>  
        
       <p>CT24 is multichannel with web and mobile access. Access our site and stay updated with latest rates at home, work or on the go.</p> 
    </div>
    <!--  
    <div class="col-xl">
        
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
          <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
        </svg>
        
      <h3>Ratings and Reviews</h3>  
        
       <p>Community based reviews of money transfer operators. Share your valuable experience with others and benefits from the experiences of others.</p> 
    </div>
    -->  
  </div>
</div>

<br><br>    
<h1 align="center">Some of our price providers</h1>
<br><br>
<div class="row">
    
    <div class="col-md-2"><a target="_blank" href="https://wise.com/"><img src="img/providers/wise.png" alt="logo" width="150px"></a></div>
    
	    
    <div class="col-md-2"><a target="_blank" href="https://aspire.link/money24"><img src="img/providers/aspire-bank.png" alt="logo" width="150px"></a></div>
    
    <div class="col-md-2"><a target="_blank" href="https://www.instarem.com/"><img src="img/providers/instarem.png" alt="logo" width="200px"></a></div>
    
    <div class="col-md-2"><a target="_blank" href="https://www.moneygram.com/mgo/us/en/"><img src="img/providers/moneygram.png" alt="logo" width="150px"></a></div>
    
    <div class="col-md-2"><a target="_blank" href="https://www.sfcu.org/"><img src="img/providers/stanford-fcu.png" alt="logo" width="150px"></a></div>
    
    <div class="col-md-2"><a target="_blank" href="https://www.ofx.com/"><img src="img/providers/ofx.png" alt="logo" width="150px"></a></div>
    
    
</div>

<div class="row">
	<div class="col-md-2"><a target="_blank" href="https://www.fortu.com/"><img src="img/providers/fortu.png" alt="logo" width="150px"></a></div>
    
    <div class="col-md-2"><a target="_blank" href="https://onjuno.com/"><img src="img/providers/onjuno.png" alt="logo" width="150px"></a></div>
    
        
    <div class="col-md-2"><a target="_blank" href="https://www.xoom.com/"><img src="img/providers/xoom.png" alt="logo" width="150px"></a></div>
    
    <div class="col-md-2"><a target="_blank" href="https://www.remitly.com"><img src="img/providers/remitly.png" alt="logo" width="150px"></a></div>
    
    <div class="col-md-2"><a target="_blank" href="https://www.westernunion.comhttps://www.westernunion.com"><img src="img/providers/western-union.png" alt="logo" width="150px"></a></div>
    
    <div class="col-md-2"><a target="_blank" href="https://www.xe.com"><img src="img/providers/xe.png" alt="logo" width="150px"></a></div>
   
    
</div>

<br><br>

<div class="container-fluid">
  <div class="row">
      
    <div class="col-xl">
              
      <h2>Americas</h2> 
        
 
      <a target="_blank" href="compare.php?str=1000.US.SG#my_top">Send Money from USA to Singapore</a>  
      <br><br> 
        
      <a target="_blank" href="compare.php?str=1000.US.IN#my_top">Send Money from USA to India</a>  
      <br><br>  
        
      <a target="_blank" href="compare.php?str=1000.US.MX#my_top">Send Money from USA to Mexico</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.US.CN#my_top">Send Money from USA to China</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.CA.IN#my_top">Send Money from Canada to India</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.US.BD#my_top">Send Money from USA to Bangladesh</a>  
      <br><br>  
        
    </div>
      
    <div class="col-xl">
      
        
        <h2>Europe</h2> 
        
        
      <a target="_blank" href="compare.php?str=1000.GB.SG#my_top">Send Money from UK to Singapore</a>  
      <br><br> 
        
      <a target="_blank" href="compare.php?str=1000.GB.IN#my_top">Send Money from UK to India</a>  
      <br><br>  
        
      <a target="_blank" href="compare.php?str=1000.GB.NG#my_top">Send Money from UK to Nigeria</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.GB.GH#my_top">Send Money from UK to Ghana</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.GB.PK#my_top">Send Money from UK to Pakistan</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.GB.CN#my_top">Send Money from UK to China</a>  
      <br><br>
        
    </div>
      
    <div class="col-xl">
      
                
        <h2>Asia Pacific</h2>
        
        
      <a target="_blank" href="compare.php?str=1000.AU.SG#my_top">Send Money from Australia to Singapore</a>  
      <br><br> 
        
      <a target="_blank" href="compare.php?str=1000.AU.IN#my_top">Send Money from Australia to India</a>  
      <br><br>  
        
      <a target="_blank" href="compare.php?str=1000.AU.PH#my_top">Send Money from Australia to Philippines</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.NZ.IN#my_top">Send Money from New Zealand to India</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.SG.IN#my_top">Send Money from Singapore to India</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.HK.IN#my_top">Send Money from Hong Kong to India</a>  
      <br><br>
        
    </div>
      
    <div class="col-xl">
        
                
      <h2>Middle East</h2> 
        
      <a target="_blank" href="compare.php?str=1000.TR.SG#my_top">Send Money from Turkey to Singapore</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.TR.IN#my_top">Send Money from Turkey to India</a>  
      <br><br>  
        
      <a target="_blank" href="compare.php?str=1000.TR.PK#my_top">Send Money from Turkey to Pakistan</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.TR.AR#my_top">Send Money from Turkey to Argentina</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.TR.AU#my_top">Send Money from Turkey to Australia</a>  
      <br><br>
        
      <a target="_blank" href="compare.php?str=1000.TR.BD#my_top">Send Money from Turkey to Bangladesh</a>  
      <br><br>
            
    </div>
      
  </div>
</div>

<br><br>    
<h1 align="center">Frequently Asked Questions</h1>
<br><br>

<div id="accordion" class="container">
  
    <div class="card">
    <div class="card-header" id="heading1">
    
        <button class="btn collapsed" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
          <h4>What is CT24?</h4>
        </button>
      
    </div>

    <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        CT24 Is an online platform helping you compare remittance rate for sending money from one country to another.
      </div>
    </div>
  </div>
 
 <div class="card">
    <div class="card-header" id="heading2">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
          <h4>Can I send money using CT24?</h4>
        </button>
      
    </div>
    <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        No; CT24 is not a money transfer service. CT24 helps you search, track and be notified of the best remit exchange rates, and helps you make the best remit decisions to get maximum return out of your hard earned money.
      </div>
    </div>
  </div>
 
 <div class="card">
    <div class="card-header" id="heading3">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
          <h4>How do I use CT24?</h4>
        </button>
      
    </div>
    <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        You just need to register and search for best rate provider. CT24 shows you the best rate available among our extensive network of partners. Once you know the best rate provider, you can access their website through the link available in CT24.
      </div>
    </div>
  </div>
 
 <div class="card">
    <div class="card-header" id="heading4">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
          <h4>Can I use CT24 without registering?</h4>
        </button>
      
    </div>
    <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        Yes. You can use the basic feature of search in CT24 without registering.
      </div>
    </div>
  </div>
    
  <div class="card">
    <div class="card-header" id="heading5">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
          <h4>Can I use blog section?</h4>
        </button>
      
    </div>
    <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        Yes. All users can read published blogs. All registered users can publish blogs.
      </div>
    </div>
  </div>
    
  <div class="card">
    <div class="card-header" id="heading6">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
          <h4>How do I set Alerts?</h4>
        </button>
      
    </div>
    <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        You can set alerts by clicking on the Alert tab. Here, you will be able to set alerts for any specific currency pair so that we can keep track for you and inform you by email when your required alert rate is triggered.
      </div>
    </div>
  </div>
    
    
    
    <br><br>
    
    <div align="center"><button class="btn btn-success" onclick="window.location.href='about.php'">See all questions</button></div>
    
</div>


<br><br>    
<h1 align="center">What Our Clients Say</h1>
<br><br>

<div class="container-fluid">
  <div class="row my_comment">
      
    <div class="col-xl">
      
        "The Best Remittance Service provider in the market. I have been using many ways to send money but CT24 is the best in providing the best rate and immediate remittance to the recipient. A wide range of choices helps me choose the best option depending on when I need to send. Very happy with this service that impacts the bottom line directly!"
        <br>
        Waheed Rajpoot<br>
        North West, Singapore
<br><br>
        
    </div>
      
    <div class="col-xl">
      
      "I have been using CT24 for more than a year and till now it has been a very smooth experience. I have observed that they offer more competitive rates than most of the other providers. I also find the daily rate alert useful as it helps time money transfers better. Their customer service response has been prompt too."
        <br>
      John<br>
      Washington, United States
 <br><br>
        
    </div>
      
    <div class="col-xl">
      
      "I live abroad & also have my connection back to India by sending money to my family. Simple and easy sign up process, my account got approved in few seconds and I was able to utilize the service right away. Thanks for providing a wonderful customer experience."
        <br>
      Ekra Bismi<br>
      Pune, India
<br><br>
        
    </div>
 
  </div>
</div>

<br><br>
<br><br>

<div class="bg-secondary page-header">
<br><br>
    
    
    <div class="container">
      <div class="row">
        <div class="col-xl">
          <div class="text-primary"><a href="index.php" class="text-white"><h4>Currency Transfer</h4></a></div>
        </div>
        <div class="col-xl text-white">
          <h4>Company</h4><br><br>
            <a class="text-white" href="currency_converter.php?str=1.US.SG">Currency Converter</a><br><br><br><br>
            <a class="text-white" href="about.php">About Us</a><br><br><br><br>
            <a class="text-white" href="about.php">Contact Us</a><br><br>
        </div>
        <div class="col-xl text-white">
          <h4>Help</h4><br><br>
            <a class="text-white" href="about.php">Faqs</a><br><br><br><br>
            <a class="text-white" href="terms.php">Terms of Use</a><br><br>
        </div>
        <div class="col-xl text-white">
          <h4>Connect</h4><br><br>
            <a class="text-white" href="blog">Blog</a><br><br><br><br>
            <a class="text-white" href="alert.php">Alert</a><br><br><br>
            
            <a target="_blank" class="text-white" href="https://m.facebook.com/profile.php?id=100082851206201">
                
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                </svg>
            
            </a>
            &nbsp;&nbsp;&nbsp;
            <a target="_blank" class="text-white" href="https://twitter.com/CurrencyTfr24">
                
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                  <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                </svg>
            
            </a>  
            
            &nbsp;&nbsp;&nbsp;
            <a target="_blank" class="text-white" href="https://www.instagram.com/p/CeakKKKlE6N/?utm_source=ig_web_copy_link">
                
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                </svg>
            
            </a>
            
            <br><br>
            
        </div>  
      </div>
    </div>    
    
<br><br>    
</div>

<?php
include("pages/footer.php");
?>