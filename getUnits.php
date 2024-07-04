<?php
/************************************************************************************
	File:		getUnits.php
	Purpose:	AJAX - query all units
	Return:		all units from table 'units'
	
	2021-02-14: created file
************************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$units = dbQueryUnits();
if($units <= 0)
	echo json_encode("NO");
else		
	echo json_encode($units);

?>
