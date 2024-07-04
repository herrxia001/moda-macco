<?php
/*
	File: postInvAdd.php
	Purpose: add a new record to the inventory
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['inv']))
{
	$inv = json_decode($_POST['inv'], true);
	$result = dbAddInventory($inv);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
