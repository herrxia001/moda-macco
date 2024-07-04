<?php
/*
	File:		postInvoiceDel.php
	Purpose:	remove one a_invoice and a_in_items
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_POST['order']))
{
	$order = json_decode($_POST['order'], true);
	if(isset($_POST['orderitems']))
	{
		$orderitems = json_decode($_POST['orderitems'], true);
		$result = dbDelInvoice($order, $orderitems);
	}
	else
		$result = dbDelInvoice($order, NULL);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
