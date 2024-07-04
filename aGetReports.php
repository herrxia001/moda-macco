<?php
/****************************************************************************************************
	File:		aGetReports.php

****************************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'db_invoice.php';

if(!isset($_GET['timefrom']) || !isset($_GET['timeto'])){
	echo json_encode("NO");
	return;
}

$timeFrom = $_GET['timefrom'];
$timeTo = $_GET['timeto'];

$arts = dbRptQueryArts();
if ($arts <= 0) {
	echo json_encode("NO");
	return;
}
$data['arts'] = $arts;

$sales = dbRptQuerySales($timeFrom, $timeTo);
if ($sales <= 0)
	$data['sales'] = 0;
else
	$data['sales'] = $sales;

$purs = dbRptQueryPurs($timeFrom, $timeTo);
if ($purs <= 0)
	$data['purs'] = 0;
else
	$data['purs'] = $purs;

$refunds = dbRptQueryRefunds($timeFrom, $timeTo);
if ($refunds <= 0)
	$data['refunds'] = 0;
else
	$data['refunds'] = $refunds;
	
echo json_encode($data);	

?>
