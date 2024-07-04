<?php
/* 	
	File:		getSalesReportByTypeCount.php
	Purpose: 	Sales report from database
	Return: 	Report
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$mySalesReport = dbGetReportByType();

if($mySalesReport <= 0)
	echo json_encode("NO");
else		
	echo json_encode($mySalesReport);	

?>
