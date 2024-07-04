<?php

include_once '../database.php';

if (!isset($_GET['db']))
	echo "-1";
else
{
	$thisDb = new myDatabase($_GET['db']);
    $cat = $_GET['cat'];
    $where = "";
    if($cat != ""){
        $where = " AND pro.ap_t_id = ".$cat;
    }

    $amount = 9;
    if($_GET['amount'] != "") $amount = $_GET['amount'];
    $paged = 1;
    if($_GET['paged'] > 1) $paged = $_GET['paged'];
	$sqlQuery = "SELECT pro.*, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
				FROM app_products AS pro, inventory AS invs, app_types AS types 
				WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.state != 1 ".$where."
				ORDER BY pro.time_created DESC";  
	$result = $thisDb->dbQuery($sqlQuery);

    $maxpaged = (ceil)(count($result) / $amount);
    if($paged > $maxpaged) $paged = $maxpaged;

    $sqlQuery = "SELECT pro.*,invs.m_no, invs.i_code, invs.price, invs.count, invs.cost, invs.path, invs.color, types.t_name 
				FROM app_products AS pro, inventory AS invs, app_types AS types 
				WHERE invs.i_id=pro.i_id AND types.ap_t_id=pro.ap_t_id AND pro.state != 1 ".$where."
				ORDER BY pro.time_created DESC LIMIT ".$amount." OFFSET ".($paged - 1);  
	$result = $thisDb->dbQuery($sqlQuery);


    $erg['maxpaged'] = $maxpaged;
    $erg['article'] = $result;

    echo json_encode($erg);
}

?>
