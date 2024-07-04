<?php

include_once 'database.php';

if(!isset($_POST['c_id']) || !isset($_POST['apc_id']))
{
	echo "-1";
	return;
}

$db = "general";
$cId = $_POST['c_id'];
$apcId = $_POST['apc_id'];

$thisDb = new myDatabase($db);
$sqlUpdate = "UPDATE comp_apc SET status='1' WHERE c_id='".$cId."' AND apc_id='".$apcId."'";
$result = $thisDb->dbUpdate($sqlUpdate);	
$thisDb->dbClose();

if (!$result)
{
	echo "-2";
}
else 
{
	echo "0";
}

?>
