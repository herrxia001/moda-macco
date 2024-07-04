<?php
include_once '../database.php';


if(!isset($_POST['db']) || !isset($_POST['warenkorb'])){
	echo json_encode("NO");
	return;
}

$erg = [];
if($_POST['warenkorb'] != "[]"){
    $db = $_POST['db'];
    $thisDb = new myDatabase($db);
    $warenkorb = json_decode($_POST['warenkorb'], true);


    for ($i=0; $i<count($warenkorb); $i++) {
        $sqlQuery = "SELECT pro.*, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
        FROM app_products AS pro, inventory AS invs, app_types AS types 
        WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.state != 1 AND pro.i_id = ".$warenkorb[$i]['i_id'];
        $result_1 = $thisDb->dbQuery($sqlQuery);
        $erg[$warenkorb[$i]['i_id']]['info'] = $result_1;

        if($warenkorb[$i]['iv_id'] != ""){
            $sqlQuery = "SELECT iv_id, variant,m_no FROM inv_variant WHERE iv_id = '".$warenkorb[$i]['iv_id']."'";
        }else{
            $sqlQuery = "SELECT iv_id, variant,m_no FROM inv_variant WHERE i_id = '".$warenkorb[$i]['i_id']."' LIMIT 1";
        }
        $result_2 = $thisDb->dbQuery($sqlQuery);
        $result_2[0]['amount'] = $warenkorb[$i]['amount'];
        $erg[$warenkorb[$i]['i_id']]['variant'][] = $result_2[0];

        $sqlQuery = "SELECT * FROM app_images WHERE i_id='".$warenkorb[$i]['i_id']."' ORDER BY api_id ASC"; 
        $result = $thisDb->dbQuery($sqlQuery);
        $erg[$warenkorb[$i]['i_id']]['img'] = $result;
        if($erg[$warenkorb[$i]['i_id']]['amount'] > 0 )
            $erg[$warenkorb[$i]['i_id']]['amount'] += $warenkorb[$i]['amount'];
        else 
            $erg[$warenkorb[$i]['i_id']]['amount'] = $warenkorb[$i]['amount'];
    }
    $thisDb->dbClose();
}
echo json_encode($erg);
?>
