<?php
/************************************************************************************
	File:		postVariantsAdd.php
	Purpose:	Add a new record to the table 'variants'. 
	Return:		OK (if success) or NO (if fails)
	
	2021-03-01: created file
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['variant']))
{
	$result = dbAddVariants($_POST['variant']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
