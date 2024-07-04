<?php
/*
	File:		postInvoiceAdd.php
	Purpose:	Create new invoice
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if (isset($_POST['order']) && isset($_POST['orderitems']))
{
	$order = json_decode($_POST['order'], true);
	$orderitems = json_decode($_POST['orderitems'], true);
	
	$result = dbCreateInvoiceFromOrder($order, $orderitems);
	
	if ($result)
		echo json_encode("OK");
	else
		echo json_encode("NO");
}
else
	echo json_encode("NO");

?>
