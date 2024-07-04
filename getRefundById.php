<?php
/* 	
	File:		getREfundById.php
	Purpose: 	Query refund by rf_id
	Return: 	refund
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_GET['rf_id']))
{
	$myRefund = dbQueryRefundById($_GET['rf_id']);	
	if($myRefund <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myRefund);
}
else		
	echo json_encode("NO");	

?>
