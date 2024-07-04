<?php
/* 	
	File:		getInvoiceVoid.php
	Purpose: 	Query all void invoices (filter by date)
	Return: 	invoices.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['timefrom']) && isset($_GET['timeto']))
{
	if (isset($_GET['k_id']))
		$myInvoices = dbQueryInvoiceVoid($_GET['timefrom'], $_GET['timeto'], $_GET['k_id']);
	else
		$myInvoices = dbQueryInvoiceVoid($_GET['timefrom'], $_GET['timeto'], NULL);
}
else
	$myInvoices = dbQueryInvoiceVoid(NULL, NULL, NULL);
if($myInvoices <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myInvoices);	

?>
