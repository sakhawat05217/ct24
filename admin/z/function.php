<?php

function ConvertSize($size)
{

	$times = 0;
	$comma = '.';
	while ($size>1024)
	{
		$times++;
		$size = $size/1024;
	}
	$size2 = floor($size);
	$rest = $size - $size2;
	$rest = $rest * 100;
	$decimal = floor($rest);
	
	$addsize = $decimal;
	if ($decimal<10) {$addsize .= '0';};
	
	if ($times == 0){$addsize=$size2;} else
	 {$addsize=$size2.$comma.substr($addsize,0,2);}
	
	switch ($times) {
	  case 0 : $mega = ' bytes'; break;
	  case 1 : $mega = ' KB'; break;
	  case 2 : $mega = ' MB'; break;
	  case 3 : $mega = ' GB'; break;
	  case 4 : $mega = ' TB'; break;}
	
	$addsize .= $mega;
	
	return $addsize;
}
?>
