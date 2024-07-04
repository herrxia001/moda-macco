<?php
/* 	
	File:		getInvs.php
	Purpose: 	Query all inventories.
	Return: 	All inventories.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once '../db_functions.php';

function dbGetAllInventoriesDiscount()
{
	$thisDb = new myDatabase($_SESSION['uDb']);
	$sqlQuery = "SELECT * FROM inventory WHERE discount IS NOT NULL AND discount != '0.00' ORDER BY i_code ASC";   
	$thisQuery = $thisDb->dbQuery($sqlQuery);

	return $thisQuery;
}

$inv = dbGetAllInventoriesDiscount();
if($inv < 0)
	echo json_encode("NO");
else		
	echo json_encode($inv);

?>