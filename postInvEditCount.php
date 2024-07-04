<?php
/*
	File:		postInvEditCount.php
	Purpose: 	Modify count in inventory
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['id']) &&isset($_POST['count']) && isset($_POST['cost']))
{
	$result = dbInvEditCount($_POST['id'], $_POST['count'], $_POST['cost']);
	
	echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
