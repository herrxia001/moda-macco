<?php
include_once '../database.php';


if(!isset($_POST['db']) || !isset($_POST['o_id']) || !isset($_POST['c_id'])){
	echo json_encode("NO");
	return;
}else{

    $erg = [];

    $db = $_POST['db'];
    $thisDb = new myDatabase($db);

    $o_id = $_POST['o_id'];
    $c_id = $_POST['c_id'];

    $sql = "SELECT oi.* FROM order_items oi, orders o WHERE oi.o_id = '".$o_id."' AND oi.o_id = o.o_id AND o.k_id = '".$c_id."'";

    $result = $thisDb->dbQuery($sql);
    foreach($result AS $element){
        $sqlQuery = "SELECT pro.*, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
        FROM app_products AS pro, inventory AS invs, app_types AS types 
        WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.i_id = ".$element['i_id'];
        $result_1 = $thisDb->dbQuery($sqlQuery);
        $erg[$element['i_id']]['info'] = $result_1;
        if($erg[$element['i_id']]['amount'] == "") $erg[$element['i_id']]['amount'] = $element['count'];
        else $erg[$element['i_id']]['amount'] += $element['count'];
        $erg[$element['i_id']]['price'] = $element['price'];


        $sql = "SELECT iv_id FROM order_variant WHERE o_id = '".$o_id."' AND i_id = '".$element['i_id']."'";
        $result_1 = $thisDb->dbQuery($sql);
        if($result_1 < 0){
            $sqlQuery = "SELECT iv_id, variant,m_no FROM inv_variant WHERE i_id = '".$element['i_id']."' LIMIT 1";
        }else{
            $sqlQuery = "SELECT iv_id, variant,m_no FROM inv_variant WHERE iv_id = '".$result_1[0]['iv_id']."'";
            $result_2 = $thisDb->dbQuery($sqlQuery);
            $erg[$element['i_id']]['variant'] = $result_2;
        }

        //$result_2 = $thisDb->dbQuery($sqlQuery);
        //$erg[$element['i_id']]['variant'] = $result_2;


        $sqlQuery = "SELECT * FROM app_images WHERE i_id='".$element['i_id']."' ORDER BY api_id ASC"; 
        $result = $thisDb->dbQuery($sqlQuery);
        $erg[$element['i_id']]['img'] = $result;


    }

    echo json_encode($erg);
}