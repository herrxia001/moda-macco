<?php
/* 	
	File:		getRefundNew.php
	Purpose: 	Create new refund
	Return: 	rf_id
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

$rId = dbCreateRefundNew();	
if($rId <= 0)
	echo json_encode("NO");
else
	echo json_encode($rId);

?>
