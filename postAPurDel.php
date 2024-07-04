<?php
/*
	File:		postAPurDel.php
	Purpose:	Delete invoice from a_pur
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if (isset($_POST['f_id']))
{	
	$result = dbDeletePurInvoice($_POST['f_id']);
	
	if ($result)
		echo json_encode("OK");
	else
		echo json_encode("NO");
}
else
	echo json_encode("NO");

?>
