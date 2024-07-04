<?php
include_once '../database.php';


if(!isset($_POST['db']) || !isset($_POST['taxno']) || !isset($_POST['plz'])){
	echo json_encode("NO");
	return;
}

$db = $_POST['db'];
$taxno = $_POST['taxno'];
$plz = $_POST['plz'];
	
$thisDb = new myDatabase($db);

$sqlQuery = "SELECT * FROM app_company WHERE taxno = '".$taxno."' AND post = '".$plz."'";

$result = $thisDb->dbQuery($sqlQuery);
if($result < 0)
    echo json_encode(-1);
else		
    echo json_encode($result);
$thisDb->dbClose();
?>
