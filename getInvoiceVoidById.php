<?php
/****************************************************************************************************	
	File:		getInvoiceVoidById.php

****************************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['r_id'])) {
	$myInvoice = dbQueryInvoiceVoidById($_GET['r_id']);	
	if($myInvoice <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myInvoice);
} else {		 
	echo json_encode("NO");	
}

?>
