<?php
/*****************************************************************************
	File:		postOrderFromMerge.php

*****************************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(!isset($_POST['order']) || !isset($_POST['orderitems']) || !isset($_POST['ordervariants']) || !isset($_POST['oldorders'])) {
	echo json_encode("NO");
	return;
}

$order = json_decode($_POST['order'], true);
$orderitems = json_decode($_POST['orderitems'], true);
$ordervariants = json_decode($_POST['ordervariants'], true);
$oldorders = json_decode($_POST['oldorders'], true);

$result = dbCreaeteOrderFromMerge($order, $orderitems, $ordervariants, $oldorders);
if(!$result)
	echo json_encode("NO");
else
	echo json_encode("OK");

?>
