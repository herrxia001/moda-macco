<?php
/* 	
	File:		getInvoiceNo.php
	Purpose: 	Query invoice_no
	Return: 	invoice_no
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

$invoiceNo = dbGetInvoiceNo($_GET['r_id']);	
if($invoiceNo <= 0)
	echo json_encode("NO");
else
	echo json_encode($invoiceNo);

?>
