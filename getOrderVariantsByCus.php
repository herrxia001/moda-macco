<?php
/***************************************************************************** 	
	File:		getOrderVariantsByCus.php

*****************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(!isset($_GET['k_id'])){
	echo json_encode("NO");
	return;
}

$myVariants = dbQueryCustOrderVariants($_GET['k_id']);
if($myVariants <= 0) {
	echo json_encode("NO");
	return;
}	

echo json_encode($myVariants);	


?>
