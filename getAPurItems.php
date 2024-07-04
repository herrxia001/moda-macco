<?php
/* 	
	File:		getAPurItems.php
	Purpose: 	Query a_pur_items by f_id.
	Return: 	a_pur_items.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['f_id']))
{
	$myPurItems = dbQueryAPurItems($_GET['f_id']);	
	if(	$myPurItems <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myPurItems);		
}
else
	echo json_encode("NO");

?>
