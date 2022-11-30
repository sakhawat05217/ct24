<?php
include("pages/header.php");

$ip = get_ip_link(get_client_ip());
$server = $_SERVER['HTTP_HOST'];
$ip_data = get_ip_data();
$user_name = 'Guest';

if(isset($_SESSION['ct_myuser']))
{
    $user_name = get_user_link($_SESSION['ct_myuser']);
    
    $info = "$user_name is in the about us page now. $ip_data, $ip";
}
else
{
   $info = "$user_name is in the about us page now. $ip_data, $ip"; 
}

save_log('About Us',$server, $info);

?>

<div class="bg-secondary page-header">
    <div class="container">
        <h1 class="m-0" align="center">
       	 <div class="text-primary">About Us</div>
        </h1>
    </div>
</div>
<br><br>
<div class="container" align="center">
        <p>Our mission is to bring Transparency and Speed to your financial transactions.</p>
        <p>CT24 helps you achieve cost-effective remittance through our extensive network of partners.</p>
        <p>Singapore is a top centre for Forex trading. CT24’s vision is to bring that expertise to users around the world.</p>
    
     <h3>Contact Us</h3>
            <p>
            business@ct-24.com  
            </p>
            
            <p>
             CT24 is powered by Money24 (registered in Singapore) 
            </p>
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
    
  
 
</div>

<br><br>

<h1 align="center">Custom Alerts</h1>
<br><br>

<div id="accordion" class="container">
  
    <div class="card">
    <div class="card-header" id="heading8">
    
        <button class="btn collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="true" aria-controls="collapse8">
          <h4>What are CT24 custom alerts?</h4>
        </button>
      
    </div>

    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        Custom alerts are notifications that CT24 sends to notify you of the best remit exchange rates.
      </div>
    </div>
  </div>
 
 <div class="card">
    <div class="card-header" id="heading9">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
          <h4>What is the advantage of using CT24 custom alerts?</h4>
        </button>
      
    </div>
    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        By using CT24 custom alerts, you do not have to monitor remit exchange rates manually. Based upon your configured alerts, CT24 will notify you about the best remit exchange rates. In this manner, CT24 does the work of searching and comparing remit exchange rates for you instead of you manually checking rates every day.
      </div>
    </div>
  </div>
 
 <div class="card">
    <div class="card-header" id="heading10">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
          <h4>What type of alert notifications does CT24 support?</h4>
        </button>
      
    </div>
    <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        Currently, CT24 supports email notifications to notify you about your configured custom alerts.
      </div>
    </div>
  </div>
 
  
</div>
<!--
<br><br>

<h1 align="center">Ratings and Reviews</h1>
<br><br>

<div id="accordion" class="container">
  
    <div class="card">
    <div class="card-header" id="heading12">
    
        <button class="btn collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="true" aria-controls="collapse12">
          <h4>What are CT24 ratings and reviews?</h4>
        </button>
      
    </div>

    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        CT24 allows users to rate and review Service Providers and Money Transfer Operators to create a social and community experience. This allows CT24 users to benefit from the experiences of others, and help the community benefit from their own experience using various remit Service Providers.
      </div>
    </div>
  </div>
 
     
 
 
 <div class="card">
    <div class="card-header" id="heading15">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
          <h4>What rating levels does CT24 support?</h4>
        </button>
      
    </div>
    <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        CT24 supports the following rating levels:<br>
        - Angry<br>
        - Dislike<br>
        - Neutral<br>
        - Like<br>
        - Love<br>

      </div>
    </div>
  </div>
    
  <div class="card">
    <div class="card-header" id="heading16">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
          <h4>What other types of information can I provide as part of my review?</h4>
        </button>
      
    </div>
    <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        In addition to rating the Service Provider on various rating types, you can provide one additional piece of information:<br>
        - comments - free form text<br>
      </div>
    </div>
  </div>
    
  <div class="card">
    <div class="card-header" id="heading17">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
          <h4>Are there any guidelines while writing reviews?</h4>
        </button>
      
    </div>
    <div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        CT24 wants you to write your reviews freely and openly so the community can truly benefit from your experience. That said, your review will need to comply with the following guidelines - no profanity or foul language, relevant to provider and money transfer experience, and complying with general levels of polite and professional language. Rule of thumb - think of how other remitters like yourself can benefit the most from your review.
      </div>
    </div>
  </div>
    
  <div class="card">
    <div class="card-header" id="heading18">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
          <h4>Does my review get published instantaneously?</h4>
        </button>
      
    </div>
    <div id="collapse18" class="collapse" aria-labelledby="heading18" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        No; All submitted reviews will go through an approval process and are checked against our aforementioned review guidelines. Your review may be edited for grammar and punctuation, and will be posted within a few business days. Should we decide that your review fails to comply with our review guidelines, we may choose to not approve your review for publication. All decisions made by our team in this regard will be final.
      </div>
    </div>
  </div> 
    

</div>


-->
<br><br>

<h1 align="center">Privacy and Security</h1>
<br><br>

<div id="accordion" class="container">
  
    <div class="card">
    <div class="card-header" id="heading22">
    
        <button class="btn collapsed" data-toggle="collapse" data-target="#collapse22" aria-expanded="true" aria-controls="collapse22">
          <h4>What data does CT24 gather from me?</h4>
        </button>
      
    </div>

    <div id="collapse22" class="collapse" aria-labelledby="heading22" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        When registering for CT24 services, as appropriate, you may be asked to enter your name and e-mail address. You may, however, also use some CT24 services anonymously.
      </div>
    </div>
  </div>
 
  
 <div class="card">
    <div class="card-header" id="heading24">
    
        <button class="btn  collapsed" data-toggle="collapse" data-target="#collapse24" aria-expanded="false" aria-controls="collapse24">
          <h4>Does CT24 share my information with third parties?</h4>
        </button>
      
    </div>
    <div id="collapse24" class="collapse" aria-labelledby="heading24" data-parent="#accordion">
      <div class="card-body my_card_body" CT24>
        CT24 does not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our services, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our service policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.
      </div>
    </div>
  </div>
   
 
</div>

<br><br>
<?php
include("pages/footer.php");
?>