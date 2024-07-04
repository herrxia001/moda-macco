<?php
/*
	File:		postInvoiceUpdate.php
	Purpose:	Update invoice to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_POST['order']))
{
	$order = json_decode($_POST['order'], true);
	$result = dbUpdateInvoice($order);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
