<?php
/************************************************************************************
	File:		postUnitAdd.php
	Purpose:	Add a new record to the table 'units'. 
	Return:		OK (if success) or NO (if fails)
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['units']))
{
	$result = dbAddUnits($_POST['units']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
