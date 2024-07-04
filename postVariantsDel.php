<?php
/************************************************************************************
	File:		postVariantsDel.php
	Purpose:	Delete record from table 'variants'. 
	Return:		OK (if success) or NO (if fails)
	
	2021-03-01: created file
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['id']))
{
	$result = dbDelVariants($_POST['id']);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
