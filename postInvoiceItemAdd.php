<?php
/*
	File:		postInvoiceItemAdd.php
	Purpose:	Add new a_in_item to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_POST['orderitem']))
{
	$orderitem = json_decode($_POST['orderitem'], true);
	$result = dbAddInvoiceItemOne($orderitem);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
