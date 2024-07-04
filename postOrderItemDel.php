<?php
/*
	File:		postOrderItemDel.php
	Purpose:	Delete order item from database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['orderitem']))
{
	$orderitem = json_decode($_POST['orderitem']);
	$result = dbDelOrderItemOne($orderitem);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
