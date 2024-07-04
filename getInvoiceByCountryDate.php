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
	$myInvoices = dbQueryInvoiceByCountryDate($_GET['timefrom'], $_GET['timeto'], $_GET['country'], $_GET['kid'], $_GET['fType']);
}
else
	$myInvoices = dbQueryInvoiceByCountryDate(NULL, NULL, $_GET['country'], $_GET['kid'], $_GET['fType']);
if($myInvoices <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myInvoices);	

?>
