<?php
/*
	File:		getCusts.php
	Purpose:	Query all customers
	Return:		All customers
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$custs = dbQueryAllCustomers();
if($custs <= 0)
	echo json_encode("NO");
else		
	echo json_encode($custs);

?>
