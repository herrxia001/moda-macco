<?php
include_once '../database.php';


if(!isset($_POST['db']) || !isset($_POST['c_id'])){
	echo json_encode("NO");
	return;
}

$db = $_POST['db'];
$thisDb = new myDatabase($db);

$apc_id = $_POST['apc_id'];
$c_id = $_POST['c_id'];

$amount = 10;
if($_POST['amount'] != "") $amount = $_POST['amount'];
$paged = 1;
if($_POST['paged'] > 1) $paged = $_POST['paged'];

$sqlQuery = "SELECT * FROM orders WHERE k_id = '".$c_id."'";
$result = $thisDb->dbQuery($sqlQuery);
$maxpaged = (ceil)(count($result) / $amount);

if($paged > $maxpaged) $paged = $maxpaged;

$sqlQuery = "SELECT * FROM orders WHERE k_id = '".$c_id."' ORDER BY date DESC LIMIT ".$amount." OFFSET ".($paged - 1);  
$result = $thisDb->dbQuery($sqlQuery);

$erg['maxpaged'] = $maxpaged;
$erg['order'] = $result;

echo json_encode($erg);

$thisDb->dbClose();

?>
