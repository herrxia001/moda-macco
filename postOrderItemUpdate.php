<?php
/*
	File:		postOrderItemUpdate.php
	Purpose:	Update order item to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['orderitem']))
{
	if (isset($_POST['option']))
		$option = $_POST['option'];
	else
	{
		echo json_encode("NO");
		return;
	}

	$orderitem = json_decode($_POST['orderitem']);
	$result = dbUpdateOrderItemOne($orderitem, $option);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
