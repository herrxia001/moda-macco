<?php
/* 	
	File:		getSalesReportByTypeInvoice.php
	Purpose: 	Sales report from database
	Return: 	Report
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

$country = "";
if(isset($_GET['country'])) $country = $_GET['country'];

if(isset($_GET['timefrom']) && isset($_GET['timeto']))
	$mySalesReport = dbGetSalesReportByTypeInvoice($_GET['timefrom'], $_GET['timeto'],$country);
else
	echo json_encode("NO");
if($mySalesReport <= 0)
	echo json_encode("NO");
else		
	echo json_encode($mySalesReport);	

?>
