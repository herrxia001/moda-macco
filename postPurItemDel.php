<?php
/*
	File:		postPurItemDel.php
	Purpose:	Delete pur_item from database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['puritem']))
{
	$puritem = json_decode($_POST['puritem']);
	$result = dbDelPurItemOne($puritem);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
