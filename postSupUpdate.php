<?php
/************************************************************************************
	File:		postSupUpdate.php
	Purpose:	update supplier to database. 
	Return:		OK (if success) or NO (if fails)
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['sup']))
{
	$sup = json_decode($_POST['sup'], true);
	$result = dbUpdateSupplier($sup['s_id'], $sup);		
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
