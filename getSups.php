<?php
/*
	File:		getSups.php	
	Purpose:	return all suppliers from server
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$sups = dbQueryAllSuppliers();
if($sups <= 0)
	echo json_encode("NO");
else		
	echo json_encode($sups);

?>
