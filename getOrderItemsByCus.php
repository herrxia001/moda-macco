<?php
/* 	
	File:		getOrderItemsByCus.php
	Purpose: 	Query all order items by k_id.
	Return: 	orders.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['k_id']))
{
	if(isset($_GET['timefrom']) && isset($_GET['timeto']))
		$myOrders = dbQueryCustOrdersItems($_GET['k_id'], $_GET['timefrom'], $_GET['timeto']);
	else
		$myOrders = dbQueryCustOrdersItems($_GET['k_id'], NULL, NULL);
	if($myOrders <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($myOrders);	
}
else
	echo json_encode("NO");

?>
