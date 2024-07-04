<?php
/*
	File:		postInvAddCount.php
	Purpose: 	add count and redo the cost to the inventory
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['id']))
{
	$result = dbInvAddCount($_POST['id'], $_POST['count'], $_POST['cost']);
	
	echo json_encode($result);
}
else
	echo json_encode("NO");

?>
