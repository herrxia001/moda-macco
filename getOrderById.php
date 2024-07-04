<?php
/* 	
	File:		getOrderById.php
	Purpose: 	Query order by o_id
	Return: 	order
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['o_id']))
{
	$myOrder = dbQueryOrderById($_GET['o_id']);	
	if($myOrder <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myOrder);
}
else		
	echo json_encode("NO");	

?>
