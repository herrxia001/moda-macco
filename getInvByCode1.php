<?php
/* 	
	File:		getInvByCode1.php
	Purpose: 	Query inventory by code1 (barcode).
	Return: 	inventory
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if($_GET['code1'])
{
	$inv = dbQueryInvByCode1($_GET['code1']);
	if($inv <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($inv);
}
else
	echo json_encode("NO");


?>
