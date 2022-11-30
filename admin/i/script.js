var xmlhttp;
xmlhttp=GetXmlHttpObject();

if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
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


function ViewStateChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("info").innerHTML=xmlhttp.responseText;
  }
}

function SaveStateChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("div_info").innerHTML=xmlhttp.responseText;
  }
}

function save_info(connection, table_name)
{
	var id = document.getElementById("title").value;
	var title = document.getElementById("new_title").value;
	var info = document.getElementById("info").value;
	
	var url="save_info.php";
	url=url+"?id="+id;
	url=url+"&table_name="+table_name;
	url=url+"&connection="+connection;
	url=url+"&title="+title;
	url=url+"&info="+info;
	
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=SaveStateChanged;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null); 
}

function view_info(connection, table_name, id)
{
	var title = document.getElementById("hidden_title_"+id).value;
	document.getElementById("new_title").value=title; 
	var url="get_info.php";
	url=url+"?id="+id;
	url=url+"&table_name="+table_name;
	url=url+"&connection="+connection;
	
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=ViewStateChanged;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null); 
}
