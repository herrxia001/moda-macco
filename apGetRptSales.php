<?php
/************************************************************************************
	apGetRptSales.php
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$mySales = dbAppRptGetSales($_GET['timefrom'], $_GET['timeto']);
if($mySales <= 0)
	echo json_encode("NO");
else		
	echo json_encode($mySales);	

?>
