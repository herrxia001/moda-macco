<?php
/************************************************************************
	File:		postOrderUpdate.php
	Purpose:	Update order to database.
************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['order'])) {
	$order = json_decode($_POST['order'], true);
	$result = dbUpdateOrder($order);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
} else {
	echo json_encode("NO");
}

?>
