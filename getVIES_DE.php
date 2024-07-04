<?php
/* 	
	File:		getVIES_DE.php
	Purpose: 	Check VAT Number via eVatR
	Return: 	eVatR return
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['ust1']) && isset($_GET['ust2']))
{
	$link = "https://evatr.bff-online.de/evatrRPC?UstId_1=".$_GET['ust1']."&UstId_2=".$_GET['ust2'];
	$link = $link."&Firmenname=&Ort=&PLZ=&Strasse=";
writeLog($link);
	$result = file_get_contents($link);
writeLog($result);
	if (!$result) {
		echo "查询出错";
		return;
	}
    $code = stristr($result, "ErrorCode");
	if (!$code) {
		echo "查询出错";
		return;
	}
	$statusStr = stristr($code, "<string>");
	$status = substr($statusStr, 8, 3);
	if ($status == "200") {
		echo "税号有效";
		return;
	} else {
		echo "税号错误";
		return;
	}
}
else
	echo '输入数据有误';


?>
