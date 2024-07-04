<?php
/*
	File:		postAPurNew.php
	Purpose:	Create new purchase
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if (isset($_POST['pur']) && isset($_POST['puritems']))
{
	$pur = json_decode($_POST['pur'], true);
	$puritems = json_decode($_POST['puritems'], true);
	
	$result = dbCreatePurInvoice($pur, $puritems);
	
	if ($result)
		echo json_encode("OK");
	else
		echo json_encode("NO");
}
else
	echo json_encode("NO");

?>
