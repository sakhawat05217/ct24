function rmdir_me(filename,basedir)
{
		
	yn = confirm('Are you sure you want to delete the folder "'+ filename +'"?');
	if(yn)
	 {
		 //alert(id);

		window.location.href="?rmdir_me=1&rmdir_file="+filename+"&basedir="+basedir;
		 
	 }
}


function chmod_me(filename,basedir)
{
		
	var new_mod = prompt("Please enter the new chmod: ",'1777'); 
	if(new_mod>=0)
	 {
		 //alert(id);

		window.location.href="?chmod_me=1&new_mod="+new_mod+"&rename_file="+filename+"&basedir="+basedir;
		 
	 }
}

function delete_me(filename,basedir)
{
		
	yn = confirm('Are you sure you want to delete the file "'+ filename +'"?');
	
	if(yn)
	 {
		 //alert(id);

		window.location.href="?del=1&delete_file="+filename+"&basedir="+basedir;
		 
	 }
}

function rename_file(filename,basedir)
{
		
	var new_name = prompt("Please enter the new name: ",filename); 
	if(new_name)
	 {
		 //alert(id);

		window.location.href="?rename=1&new="+new_name+"&rename_file="+filename+"&basedir="+basedir;
		 
	 }
}

function copy_file(filename,basedir)
{
		
	var new_location = prompt("Please enter the new location: ",basedir); 
	if(new_location)
	 {
		 //alert(id);

		window.location.href="?copy_file=1&new_loc="+new_location+"&file_name="+filename+"&basedir="+basedir;
		 
	 }
}