<?php
/* 	
	File:		getSalesReport.php
	Purpose: 	Sales report from database
	Return: 	Report
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['timefrom']) && isset($_GET['timeto']))
	$mySalesReport = dbGetSalesReport($_GET['timefrom'], $_GET['timeto']);
else
	echo json_encode("NO");
if($mySalesReport <= 0)
	echo json_encode("NO");
else		
	echo json_encode($mySalesReport);	

?>
