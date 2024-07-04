<?php
/* 	
	File:		getInvoiceByOrder.php
	Purpose: 	Query invoice by o_id
	Return: 	invoice
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['o_id']))
{
	$myInvoice = dbQueryInvoiceByOrder($_GET['o_id']);	
	if($myInvoice <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myInvoice);
}
else		
	echo json_encode("NO");	

?>
