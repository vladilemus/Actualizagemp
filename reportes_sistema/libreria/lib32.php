<?php 
function getEdad($fec_nac){
$aFecha = explode( '-', $fec_nac);
return floor(( (date("Y") - $aFecha[0] ) * 372 + ( date("m") - $aFecha[1] ) * 31 + Date("d" ) - $aFecha[2] )/372) ;
}
function format_num_p($num){
	return number_format(($num*1), 2)." %";
}
function format_num($num){
	return number_format(($num*1), 0);
}
function format_num2d($num){
	return number_format(($num*1), 2);
}
//function formatDiv($data,$label,$idrow,$classDiv){
//return "<div id=\"id_div" . $idrow . "\" class=\"".$classDiv."\"><div style='font-weight:bold;font-variant:small-caps'>".$label.":</div>".$data."</div>";
//}


function getConsulta($numConsul){
$strRet="1ra vez";
if (($numConsul*1)<>1)
	$strRet=  $numConsul." subsecuente";
return $strRet;	
}
function getYesNo($numYesNo){
$strRet="NO";
if ($numYesNo==1)
	$strRet="SI";
return $strRet;	
}

function getDescript($value,$optValues,$optDescript){
$strRet=" ";
foreach ($optValues as $count_isel => $isel)
	if (trim($isel)==trim($value))
		return $optDescript[$count_isel];
return $strRet;	
}


?>