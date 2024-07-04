<?php
/************************************************************************************
	File:		postAppTypeAdd.php
	Purpose:	Add a new record to the table 'app_types'. 
	Return:		New app_t_id or NO (if fails)
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['t_name']))
{
	$result = dbAppTypeAdd($_POST['t_name']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode($result);
}
else
	echo json_encode("NO");

?>
