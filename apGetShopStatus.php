<?php

include_once 'database.php';

if(!isset($_GET['apc_id']))
{
	echo "-1";
	return;
}

$db = "general";
$apcId = $_GET['apc_id'];

$thisDb = new myDatabase($db);
$sqlQuery = "SELECT * FROM comp_apc WHERE apc_id='".$apcId."'";  
$result = $thisDb->dbQuery($sqlQuery);
$thisDb->dbClose();

if (!$result)
{
	echo "-2";
}
else 
{
	echo json_encode($result);
}

?>
