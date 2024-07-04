<?php

include_once 'database.php';

if (!isset($_GET['db']) || !isset($_GET['i_id'])) {
	echo "-1";
} else {
	$thisDb = new myDatabase($_GET['db']);
	$sqlQuery = "SELECT * FROM app_images WHERE i_id='".$_GET['i_id']."' ORDER BY api_id ASC";  
	$result = $thisDb->dbQuery($sqlQuery);
	
	if($result < 0)
		echo "-2";
	else		
		echo json_encode($result);
}

?>
