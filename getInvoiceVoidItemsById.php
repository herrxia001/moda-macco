<?php
/************************************************************************ 	
	File:		getInvoiceVoidItemsById.php

************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['r_id']))
{
	$myInItems = dbQueryInvoiceVoidItems($_GET['r_id']);	
	if(	$myInItems <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myInItems);		
}
else
	echo json_encode("NO");

?>
