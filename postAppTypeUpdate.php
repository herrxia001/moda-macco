<?php
/************************************************************************************
	File:		postAppTypeUpdate.php
	Purpose:	Update record to the table 'app_types'. 
	Return:		OK/NO
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['t_id']) and isset($_POST['t_name']))
{
	$result = dbAppTypeUpdate($_POST['t_id'], $_POST['t_name']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
