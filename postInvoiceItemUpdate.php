<?php
/*
	File:		postInvoiceItemUpdate.php
	Purpose:	Update a_in_item to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_POST['orderitem']))
{
	if (isset($_POST['option']))
		$option = $_POST['option'];
	else
	{
		echo json_encode("NO");
		return;
	}

	$orderitem = json_decode($_POST['orderitem'], true); 
	$result = dbUpdateInvoiceItemOne($orderitem, $option);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
