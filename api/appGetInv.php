<?php

include_once '../database.php';

if (!isset($_GET['db']))
	echo "-1";
else
{
	$thisDb = new myDatabase($_GET['db']);
	$i_id = $_GET['i_id'];



	$sqlQuery = "SELECT pro.*, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
	FROM app_products AS pro, inventory AS invs, app_types AS types 
	WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.state != 1 AND pro.i_id = ".$i_id;
	$result_1 = $thisDb->dbQuery($sqlQuery);

	$erg['result'] = $result_1;

	$sqlQuery = "SELECT iv_id, variant,m_no FROM inv_variant WHERE i_id = '".$i_id."'";
	$result_2 = $thisDb->dbQuery($sqlQuery);

	$erg['variant'] = $result_2;

	$sqlQuery = "SELECT * FROM app_images WHERE i_id='".$i_id."' ORDER BY api_id ASC"; 
	$result = $thisDb->dbQuery($sqlQuery);
	$erg['img'] = $result;
	
	if($result_1 < 0)
		echo "-2";
	else		
		echo json_encode($erg);
}

?>
