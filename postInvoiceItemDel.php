<?php
/*
	File:		postInvoiceItemDel.php
	Purpose:	Delete a_in_item from database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_POST['orderitem']))
{
	$orderitem = json_decode($_POST['orderitem'],true);
	$result = dbDelInvoiceItemOne($orderitem);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
