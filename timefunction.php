<?php
//RESTITUISCE UNA DATA FORMATTATA NEL FORMATO aaaammgg, $data è LA DATA DA FORMATTARE NEL FORMATO gg*mm*aaaa
function outputdataformat($data){

	$data=trim($data);
	//se non passa nulla ritono nulla!
	if($data==null or $data=="")
		return "NULL";
	
    $gg=substr($data, 0, 2);
    $mm=substr($data, 3, 2);
    //$aa=substr($data, 6, 4);
	if(strlen($data)==10)
		$aa=substr($data, 6, 4);
	else
		$aa=substr($data, 6, 2);
    $dataformat="$aa/$mm/$gg";
    return $dataformat;
}
//RESTITUISCE UNA DATA FORMATTATA NEL FORMATO gg/mm/aaaa, $data è LA DATA DA FORMATTARE NEL FORMATO aaaammgg
function inputdataformat($data){
	if($data=="")
		return "";
    $aa=substr($data, 0, 4);
    $mm=substr($data, 5, 2);
    $gg=substr($data, 8, 2);
    $datareformat="$gg"."/"."$mm"."/"."$aa";
    return $datareformat;
}

function outputdataTIMEformat($data){
	
	$data=trim($data);
	//se non passa nulla ritono nulla!
	if($data==null or $data=="")
		return "";
	
    $gg=substr($data, 0, 2);
    $mm=substr($data, 3, 2);
    //$aa=substr($data, 6, 4);
	if(strlen($data)==19)
	{
		$aa=substr($data, 6, 4);
		$dataformat="$aa/$mm/$gg ".substr($data, 11, 8);
	}
	else
	{
		$aa=substr($data, 6, 2);
		$dataformat="$aa/$mm/$gg ".substr($data, 9, 8);
	}
    return $dataformat;
}
function inputdataTIMEformat($data){
    $aa=substr($data, 0, 4);
    $mm=substr($data, 5, 2);
    $gg=substr($data, 8, 2);
    $datareformat="$gg"."/"."$mm"."/"."$aa ".substr($data, 11, 8);
    return $datareformat;
}

function datediff($partenza, $fine)
{
	$tipo = 1;
	$arr_partenza = explode("/", $partenza);
	$partenza_gg = $arr_partenza[0];
	$partenza_mm = $arr_partenza[1];
	$partenza_aa = $arr_partenza[2];
	$arr_fine = explode("/", $fine);
	$fine_gg = $arr_fine[0];
	$fine_mm = $arr_fine[1];
	$fine_aa = $arr_fine[2];
	$date_diff = mktime(12, 0, 0, $fine_mm, $fine_gg, $fine_aa) - mktime(12, 0, 0, $partenza_mm, $partenza_gg, $partenza_aa);
	$date_diff  = floor(($date_diff / 60 / 60 / 24) / $tipo);
	return $date_diff;
}
?>