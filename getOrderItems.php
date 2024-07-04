<?php
/* 	
	File:		getOrderItems.php
	Purpose: 	Query all order_items by a list of ids.
	Return: 	order_items.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if($_GET['o_id'])
{
	$idList = json_decode($_GET['o_id']);
	if(count($idList) <= 0)
		echo json_encode("NO");
	else
	{
		$myOrderItems = array();
		for($i=0; $i<count($idList); $i++)
			$myOrderItems[$i] = dbQueryOrderItems($idList[$i]);	
		
		echo json_encode($myOrderItems);
	}		
}
else
	echo json_encode("NO");

?>
