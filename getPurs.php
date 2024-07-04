<?php
/* 	
	File:		getPurs.php
	Purpose: 	Query all purchases (filter by date)
	Return: 	purchases.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['timefrom']) && isset($_GET['timeto'])) {
	$timeFrom = $_GET['timefrom'];
	$timeTo = $_GET['timeto'];
} else {
	$timeFrom = NULL;
	$timeTo = NULL;
}
if (isset($_GET['s_id'])) {
	$sId = $_GET['s_id'];
} else {
	$sId = NULL;
}
if (isset($_GET['i_code'])) {
	$iCode = $_GET['i_code'];
} else {
	$iCode = NULL;
}

$myPurs = dbQueryPurs($timeFrom, $timeTo, $sId, $iCode);

if($myPurs <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myPurs);	

?>
