<?php
/* 	
	File:		getRefundByNo.php
	Purpose: 	Query refund by refund_no
	Return: 	refund
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_GET['refund_no']))
{
	$myRefund = dbQueryRefundByNo($_GET['refund_no']);	
	if($myRefund <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myRefund);
}
else		
	echo json_encode("NO");	

?>
