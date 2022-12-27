function my_copy_link() {
  var copyText = document.getElementById("copy_url");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied: " + copyText.value;
    
  var tooltip_two = document.getElementById("myTooltip_two");
  tooltip_two.innerHTML = "Copied: " + copyText.value;    
}

function my_copy_link_out() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
    
  var tooltip_two = document.getElementById("myTooltip_two");
  tooltip_two.innerHTML = "Copy to clipboard";    
}

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function compare_rate()
{
    var send_amount = $('#send_amount').val();
	var send_country = $('#send_country').val();
	var receive_country = $('#receive_country').val();
    var extra_param = $('#extra_param').val();
    var currentDate = new Date();
    var timestamp = currentDate.getTime();
    
    if(extra_param.localeCompare("a")==0)
        {
            window.location.href = 'compare.php?t='+timestamp +'&str='+send_amount+'.'+send_country+'.'+receive_country+'#my_top';
        }
	else
        {
            window.location.href = 'https://www-ct24-co.translate.goog/compare.php?t='+timestamp +'&str='+send_amount+'.'+send_country+'.'+receive_country+'&_x_tr_sl=en&_x_tr_tl='+extra_param+'&_x_tr_hl=en&_x_tr_pto=wapp#my_top';
        }
}

function order_active(s_type,s_order)
{
	if(s_order=='asc') $('#'+s_type+'_asc').addClass("active");
	else $('#'+s_type+'_desc').addClass("active");

}

var wd = screen.width;

if(wd<=500)
{
	$('#navbar').removeClass("navbar");
}
else
{
	$('#navbar').addClass("navbar");
}

var xmlhttp;

function save_controls(param)
{
	  
	xmlhttp=GetXmlHttpObject()
	
	if (xmlhttp==null)
	  {
		  alert ("Your browser does not support XML HTTP Request");
		  return;
	  }
	  
	var send_country = $('#send_country').val();
	var receive_country = $('#receive_country').val();
    
    $('#extra_param').val(param);
	  
	var url="pages/save_controls.php";
	url=url+"?param="+param;
	url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=goToTranslate;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
    
   
}

function goToTranslate()
{
    var param = $('#extra_param').val();
    window.location.href = 'https://www-ct24-co.translate.goog?_x_tr_sl=en&_x_tr_tl='+param+'&_x_tr_hl=en&_x_tr_pto=wapp#my_top'; 
}

function save_provider(current_user,provider_id)
{
	  
	xmlhttp=GetXmlHttpObject()
	
	if (xmlhttp==null)
	  {
		  alert ("Your browser does not support XML HTTP Request");
		  return;
	  }
	  
	var send_country = $('#send_country').val();
	var receive_country = $('#receive_country').val();
	  
	var url="pages/save_provider.php";
	url=url+"?current_user="+current_user;
	url=url+"&provider_id="+provider_id;
	url=url+"&sid="+Math.random();
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function ShowExchangeRate()
{
	var send_amount = $('#send_amount').val();
	if (send_amount.length==0)
	  {
	  	return;
	  }
	  
	xmlhttp=GetXmlHttpObject()
	
	if (xmlhttp==null)
	  {
		  alert ("Your browser does not support XML HTTP Request");
		  return;
	  }
	  
	var send_country = $('#send_country').val();
	var receive_country = $('#receive_country').val();
	  
	var url="pages/get_exchange_rates.php";
	url=url+"?send_amount="+send_amount;
	url=url+"&send_country="+send_country;
	url=url+"&receive_country="+receive_country;
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=stateChanged ;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function stateChanged()
{
	if (xmlhttp.readyState==4)
	  {
          var amount_arr = xmlhttp.responseText.split("#");
          $('#rate').html(amount_arr[0]);
          $('#receive_amount').val(amount_arr[1]);
		  
	  }
}

function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	  {
	  // code for IE7+, Firefox, Chrome, Opera, Safari
	  return new XMLHttpRequest();
	  }
	if (window.ActiveXObject)
	  {
	  // code for IE6, IE5
	  return new ActiveXObject("Microsoft.XMLHTTP");
	  }
	return null;
}

