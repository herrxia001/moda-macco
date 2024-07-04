<?php
/************************************************************************ 	
	File:		getInvoiceVoidByNo.php

************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_GET['invoice_no']) && isset($_GET['year'])) {
	$myInvoice = dbQueryInvoiceVoidByNo($_GET['invoice_no'], $_GET['year']);	
	if($myInvoice <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myInvoice);
} else {		
	echo json_encode("NO");	
}

?>
