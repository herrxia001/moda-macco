<?php
/************************************************************************************
	apGetRptProducts.php
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$myProducts = dbAppRptGetProducts($_GET['timefrom'], $_GET['timeto']);
if($myProducts <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myProducts);	

?>
