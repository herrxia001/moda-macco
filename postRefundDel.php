<?php
/*
	File:		postRefundDel.php
	Purpose:	remove one a_refund
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_POST['order'])) {
	$order = json_decode($_POST['order'], true);
	if(isset($_POST['orderitems'])) {
		$orderitems = json_decode($_POST['orderitems'], true);
		$result = dbDelRefund($order, $orderitems);
	} else
		$result = dbDelRefund($order, NULL);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
} else
	echo json_encode("NO");

?>
