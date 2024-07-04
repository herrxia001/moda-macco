<?php
/****************************************************************************************************
	File:		aGetArtHist.php

****************************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(!isset($_GET['year']) || !isset($_GET['month'])){
	echo json_encode("NO");
	return;
}

$year = $_GET['year'];
$month = $_GET['month'];

$arts = dbQueryArtHist($year, $month);
if ($arts <= 0) {
	echo json_encode("NO");
	return;
}
	
echo json_encode($arts);	

?>
