<?php
/*
	File:		postUpdateTableCol.php
	Purpose:	Update one table column.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_functions.php';

if(isset($_POST['table']) && isset($_POST['col']) && isset($_POST['value']) && isset($_POST['col1']) && isset($_POST['value1']))
{
	$result = dbUpdateTableCol($_POST['table'], $_POST['col'], $_POST['value'], $_POST['col1'], $_POST['value1']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
