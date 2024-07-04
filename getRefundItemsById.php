<?php
/* 	
	File:		getRefundItemsById.php
	Purpose: 	Query all a_rf_items by rf_id.
	Return: 	a_rf_items.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_GET['rf_id']))
{
	$myRfItems = dbQueryRefundItems($_GET['rf_id']);	
	if(	$myRfItems <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myRfItems);		
}
else
	echo json_encode("NO");

?>
