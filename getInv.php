<?php
/* 	
	File:		getInv.php
	Purpose: 	Query inventory by i_id. Used by JS through AJAX.
	Return: 	Always single inventory record back.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if($_GET['id'])
{
	$inv = dbQueryInventory($_GET['id']);
	if($inv <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($inv);	
}
else
	echo json_encode("NO");


?>
