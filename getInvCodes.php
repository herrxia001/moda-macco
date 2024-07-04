<?php
/* 	
	File:		getInvCodes.php
	Purpose: 	Query all i_code from 'inventory'
	Return: 	All inventories.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$invs = dbQueryAllInvCodes();
if($invs < 0)
	echo json_encode("NO");
else		
	echo json_encode($invs);

?>
