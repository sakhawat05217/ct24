

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

