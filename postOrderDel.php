<?php
/********************************************************************************
	File:		postOrderDel.php
	Purpose:	remove one order and order_items	
*********************************************************************************/ 

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['order']))
{
	$order = json_decode($_POST['order'], true);
	if(isset($_POST['orderitems']))
		$orderitems = json_decode($_POST['orderitems'], true);
	else
		$orderitems = NULL;
	if(isset($_POST['ordervariants']))
		$ordervariants = json_decode($_POST['ordervariants'], true);
	else
		$ordervariants = NULL;	
	$result = dbDelOrder($order, $orderitems, $ordervariants);

	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
