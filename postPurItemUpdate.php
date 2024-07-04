<?php
/*
	File:		postUpdateItemUpdate.php
	Purpose:	Update pur_item to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['puritem']) && isset($_POST['option']))
{
	$puritem = json_decode($_POST['puritem']);
	$result = dbUpdatePurItemOne($puritem, $_POST['option']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
