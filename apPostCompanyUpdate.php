<?php

include_once 'database.php';

if(!isset($_POST['apc_id']) || !isset($_POST['app_company']))
{
	echo "-1";
	return;
}

$db = "general";
$apc_id = $_POST['apc_id'];
$company = json_decode($_POST['app_company'], true);
	
$thisDb = new myDatabase($db);
$type = 0;
if ($company['type'] == NULL || $company['type'] == "")
	$type = 0;
else
	$type = intval($company['type']);
$sqlUpdate = "UPDATE app_company SET ". 
			"apc_name='".$company['apc_name'].
			"', type=".$type.
			", areacode='".$company['areacode'].
			"', country='".$company['country'].
			"', address='".$company['address'].
			"', address1='".$company['address1'].
			"', post='".$company['post'].
			"', city='".$company['city'].
			"', contact='".$company['contact'].
			"', taxno='".$company['taxno'].
			"', email='".$company['email'].
			"', cell='".$company['cell'].
			"', whatsapp='".$company['whatsapp'].
			"', memo='".$company['memo'].
			"', tel='".$company['tel'].
			"' WHERE apc_id='".$apc_id."'";
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
