<?php
/* 	
	File:		getInvoiceNew.php
	Purpose: 	Create new invoice
	Return: 	r_id
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

$rId = dbCreateInvoice();	
if($rId <= 0)
	echo json_encode("NO");
else
	echo json_encode($rId);

?>
