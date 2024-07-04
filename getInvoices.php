<?php
/* 	
	File:		getInvoices.php
	Purpose: 	Query all invoices (filter by date)
	Return: 	invoices.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['timefrom']) && isset($_GET['timeto']))
{
	if (isset($_GET['k_id']))
		$myInvoices = dbQueryInvoices($_GET['timefrom'], $_GET['timeto'], $_GET['k_id']);
	else
		$myInvoices = dbQueryInvoices($_GET['timefrom'], $_GET['timeto'], NULL);
}
else
	$myInvoices = dbQueryInvoices(NULL, NULL, NULL);
if($myInvoices <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myInvoices);	

?>
