<?php
/************************************************************************************
	File:		postAppTypeDelete.php
	Purpose:	Delete record from table 'app_types'. 
	Return:		OK/NO
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['t_id']))
{
	$result = dbAppTypeDelete($_POST['t_id']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
