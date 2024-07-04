<?php
/* 	
	File:		getOrders.php
	Purpose: 	Query all orders (filter by date)
	Return: 	orders.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['timefrom']) && isset($_GET['timeto']))
	$myOrders = dbQueryOrders($_GET['timefrom'], $_GET['timeto']);
else
	$myOrders = dbQueryOrders(NULL, NULL);
if($myOrders <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myOrders);	

?>
