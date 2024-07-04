<?php
/*
	File: 		getCustNo.php
	Purpose:	get customer k_code
	Return:		k_code
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if ($_GET['prefix'])
	$k_code = dbGetCustomerCodeByPrefix($_GET['prefix']);	
else
	$k_code = dbGetCustomerCode();
if($k_code == "")
	echo json_encode("NO");
else		
	echo json_encode($k_code);

?>
