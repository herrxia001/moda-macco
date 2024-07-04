<?php
/*
	File:		postInvoiceStatus.php
	Purpose:	Update invoice status.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_POST['r_id']) && isset($_POST['status']))
{
	$rId = json_decode($_POST['r_id'], true);
	$status = json_decode($_POST['status'], true);
	$result = dbUpdateInvoiceStatus($rId, $status);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
