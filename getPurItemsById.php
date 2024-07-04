<?php
/* 	
	File:		getPurItemsById.php
	Purpose: 	Query all pur_items by p_id.
	Return: 	pur_items.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['p_id']))
{
	$myPurItems = dbQueryPurItemsById($_GET['p_id']);	
	if(	$myPurItems <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myPurItems);		
}
else
	echo json_encode("NO");

?>
