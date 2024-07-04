<?php
/* 	
	File:		getSalesReportBySup.php
	Purpose: 	Sales report from database - by suppliers
	Return: 	Report
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['timefrom']) && isset($_GET['timeto']))
{
	$mySalesReport = dbGetSalesReportBySup($_GET['timefrom'], $_GET['timeto']);
	if($mySalesReport <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($mySalesReport);	
}
else
	echo json_encode("NO");
?>
