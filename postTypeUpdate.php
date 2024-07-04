<?php
/*
	File:		postTypeUpdate.php
	Purpose:	Update record to the table 'types'. 
	Return:		OK/NO
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['t_id']) and isset($_POST['t_name']))
{
	$result = dbUpdateType($_POST['t_id'], $_POST['t_name']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
