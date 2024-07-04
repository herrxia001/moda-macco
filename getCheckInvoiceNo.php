<?php
/*
	File: 		getCheckInvoiceNo.php
	Purpose:	Check if invoice_no OK to use
	Return:		true/false
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['invoice_no']) && isset($_GET['year']))
{
	$result = dbCheckInvoiceNo($_GET['invoice_no'], $_GET['year']);
	if(!$result)
		echo json_encode("NO");
	else		
		echo json_encode($result);
}
else
	echo json_encode("NO");

?>
