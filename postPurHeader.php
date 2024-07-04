<?php
/*
	File:		postPurHeader.php
	Purpose:	Update purchase header to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['pur']))
{
	$pur = json_decode($_POST['pur'], true);
	
	$result = dbHeaderPurchase($pur);
		
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
