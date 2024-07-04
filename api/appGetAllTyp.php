<?php

include_once '../database.php';

if (!isset($_GET['db']))
	echo "-1";
else
{
	$thisDb = new myDatabase($_GET['db']);
    $sqlQuery = "SELECT * FROM app_types WHERE ap_t_id IN (SELECT ap_t_id FROM app_products WHERE state != 1) ORDER BY t_name";
	$result = $thisDb->dbQuery($sqlQuery);
    $erg['typ'] = $result;

    $sqlQuery = "SELECT pro.ap_t_id, pro.sum, typ.t_name FROM (SELECT ap_t_id, COUNT(i_id) AS sum FROM app_products WHERE state != 1 GROUP BY ap_t_id) pro, app_types typ WHERE pro.ap_t_id = typ.ap_t_id ORDER BY sum DESC";
	$result = $thisDb->dbQuery($sqlQuery);
    foreach($result AS $index => $element){
        $sqlQuery = "SELECT pro.*, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
				FROM app_products AS pro, inventory AS invs, app_types AS types 
				WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.state != 1 AND pro.ap_t_id = ".$element['ap_t_id']."
				ORDER BY pro.time_created DESC LIMIT 50"; 
        $result_2 = $thisDb->dbQuery($sqlQuery);

		foreach($result_2 AS $i => $element){
			$sqlQuery = "SELECT * FROM inv_variant WHERE i_id = '".$element['i_id']."'";
			$result_3 = $thisDb->dbQuery($sqlQuery);
			$result_2[$i]['variant'] = $result_3;
		}
        $result[$index]['artikel'] = $result_2;
    }

    /*$sqlQuery = "SELECT pro.*, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
				FROM app_products AS pro, inventory AS invs, app_types AS types 
				WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.state != 1
				ORDER BY pro.time_created DESC";  */


    $erg['top'] = $result;

	$sqlQuery = "SELECT pro.*, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
				FROM app_products AS pro, inventory AS invs, app_types AS types 
				WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.state != 1 
				ORDER BY pro.time_created DESC LIMIT 50"; 
	$result_2 = $thisDb->dbQuery($sqlQuery);

	foreach($result_2 AS $i => $element){
		$sqlQuery = "SELECT * FROM inv_variant WHERE i_id = '".$element['i_id']."'";
		$result_3 = $thisDb->dbQuery($sqlQuery);
		$result_2[$i]['variant'] = $result_3;
	}

	$erg['all'] = $result_2;
	
	if($result < 0)
		echo "-2";
	else		
		echo json_encode($erg);
}

?>
