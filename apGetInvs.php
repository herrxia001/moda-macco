<?php

include_once 'database.php';

if (!isset($_GET['db']))
	echo "-1";
else
{
	$thisDb = new myDatabase($_GET['db']);
	$sqlQuery = "SELECT pro.*, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
				FROM app_products AS pro, inventory AS invs, app_types AS types 
				WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.state != 1
				ORDER BY pro.time_created DESC";  
	$result = $thisDb->dbQuery($sqlQuery);
	
	if($result < 0)
		echo "-2";
	else		
		echo json_encode($result);
}

?>
