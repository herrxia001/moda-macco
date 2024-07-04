<?php
/* 	
	File:		getOrderItemsById.php
	Purpose: 	Query all order_items by o_id.
	Return: 	order_items.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['o_id']))
{
	$myOrderItems = dbQueryOrderItems($_GET['o_id']);	
	if(	$myOrderItems <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myOrderItems);		
}
else
	echo json_encode("NO");

?>
