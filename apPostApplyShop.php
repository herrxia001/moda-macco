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
$sqlAdd = "INSERT INTO comp_apc(c_id, apc_id, status) VALUES('".$cId."','".$apcId."','1')";
$result = $thisDb->dbInsert($sqlAdd);	
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
