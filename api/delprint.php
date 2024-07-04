<?php
include_once '../db_functions.php';
$erg = array();
$erg['st'] = -1;
$erg['msg'] = "删除失败";

$token = $_GET['token'];
$id = $_GET['id'];
$thisDb = new myDatabase($root_db);

if($id != "" && $token != ""){
    $sqlQuery = "SELECT * FROM users WHERE printToken='".$token."' AND printToken != '' AND printToken IS NOT NULL";
    $userData = $thisDb->dbQuery($sqlQuery);
    if(!$userData <= 0){
        $uDb = $userData[0]['u_db']; 

        $thisDb = new myDatabase($uDb);
        $sql = "DELETE FROM print WHERE id IN (".$id.")";
        $thisDb->dbQuery($sql);

        $erg['st'] = 1;
        $erg['msg'] = "删除成功";
    }
}

echo json_encode($erg);?>