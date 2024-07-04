<?php
/*
	File:		postRefundItemAdd.php
	Purpose:	Add new to a_rf_items.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_POST['orderitem']))
{
	$orderitem = json_decode($_POST['orderitem'], true);
	$result = dbAddRefundItemOne($orderitem);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
