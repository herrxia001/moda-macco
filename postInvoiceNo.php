<?php
/*
	File:		postInvoiceNo.php
	Purpose:	Update invoice_no.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_POST['invoice_no']) && isset($_POST['r_id']))
{
	$rId = json_decode($_POST['r_id'], true);
	$invoiceNo = json_decode($_POST['invoice_no'], true);
	$result = dbUpdateInvoiceNo($rId, $invoiceNo);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
