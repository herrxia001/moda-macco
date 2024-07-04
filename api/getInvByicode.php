<?php
/* 	
	File:		getInvById.php
	Purpose: 	Query inventory by id.
	Return: 	inventory.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once '../db_functions.php';

function getInvById($i_code)
{
	$thisDb = new myDatabase($_SESSION['uDb']);
	$sqlQuery = "SELECT * FROM inventory WHERE i_code = '".$i_code."'";   
	$thisQuery = $thisDb->dbQuery($sqlQuery);

	return $thisQuery;
}

$inv = getInvById($_GET['i_code']);
if($inv < 0)
	echo json_encode("NO");
else		
	echo json_encode($inv);

?>