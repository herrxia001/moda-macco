<?php
/************************************************************************************
	File:		postSupAdd.php
	Purpose:	Add supplier to database. 
	Return:		New s_id or NO (if fails)
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['sup']))
{
	$sup = json_decode($_POST['sup'], true);
	$result = dbAddSupplier($sup);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode($result);
}
else
	echo json_encode("NO");

?>
