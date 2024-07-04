<?php
/* 	
	File:		getArtSales.php
	Purpose: 	Query all sales of articles (filter by date)
	Return: 	sales.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

$mySales = dbQueryArtSales($_GET['timefrom'], $_GET['timeto'], $_GET['option']);
if($mySales <= 0)
	echo json_encode("NO");
else		
	echo json_encode($mySales);	

?>
