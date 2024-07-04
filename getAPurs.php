<?php
/* 	
	File:		getAPurs.php
	Purpose: 	Query all purchases from a_purs
	Return: 	invoices.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['timefrom']) && isset($_GET['timeto']))
{
	if (isset($_GET['s_id']))
		$myInvoices = dbQueryPurInvoices($_GET['timefrom'], $_GET['timeto'], $_GET['s_id']);
	else
		$myInvoices = dbQueryPurInvoices($_GET['timefrom'], $_GET['timeto'], NULL);
}
else
	$myInvoices = dbQueryPurInvoices(NULL, NULL, NULL);
if($myInvoices <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myInvoices);	

?>
