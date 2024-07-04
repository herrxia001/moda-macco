<?php
/************************************************************************
	APP: Get order status
************************************************************************/
include_once 'database.php';

if(!isset($_GET['k_id']) || !isset($_GET['db'])) {
	echo "-1";
	return;
}

$db = $_GET['db'];
$kId = $_GET['k_id'];

$thisDb = new myDatabase($db);
$sqlQuery = "SELECT o_id, status FROM orders WHERE k_id='".$kId."'";  
$result = $thisDb->dbQuery($sqlQuery);
$thisDb->dbClose();

if (!$result) {
	echo "-2";
} else  {
	echo json_encode($result);
}

?>
