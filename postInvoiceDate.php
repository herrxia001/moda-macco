<?php
/*
	File:		postInvoiceDate.php
	Purpose:	Update invoice date.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(isset($_POST['date']) && isset($_POST['r_id']))
{
	$rId = json_decode($_POST['r_id'], true);
	$date = json_decode($_POST['date'], true);
	$lieferdate = json_decode($_POST['lieferdatum'], true);
	$result = dbUpdateInvoiceDate($rId, $date, $lieferdate); 
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
