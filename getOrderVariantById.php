<?php
/* 	
	File:		getOrderVariantById.php
	Purpose: 	Query all order_variant by o_id.
	Return: 	order_variant.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['o_id']))
{
	$myOrderVariant = dbQueryOrderVariantById($_GET['o_id']);	
	if(	$myOrderVariant <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myOrderVariant);		
}
else
	echo json_encode("NO");

?>
