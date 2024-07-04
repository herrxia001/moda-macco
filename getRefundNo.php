<?php
/* 	
	File:		getRefundNo.php
	Purpose: 	Query refund_no
	Return: 	refund_no
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

$refundNo = dbGetRefundNo($_GET['rf_id'], 1);	
if($refundNo <= 0)
	echo json_encode("NO");
else
	echo json_encode($refundNo);

?>
