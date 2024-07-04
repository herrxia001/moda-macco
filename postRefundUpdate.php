<?php
/*
	File:		postRefundUpdate.php
	Purpose:	Update a_refund.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_POST['order']))
{
	$order = json_decode($_POST['order'], true);
	$result = dbUpdateRefund($order);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
