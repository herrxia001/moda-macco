<?php
include_once '../db_functions.php';
$erg = array();
$token = $_GET['token'];
$thisDb = new myDatabase($root_db);

$sqlQuery = "SELECT * FROM users WHERE printToken='".$token."' AND printToken != '' AND printToken IS NOT NULL";
$userData = $thisDb->dbQuery($sqlQuery);
if(!$userData <= 0){
    $uDb = $userData[0]['u_db']; 

    $thisDb = new myDatabase($uDb);
    $sql = "SELECT * FROM print LIMIT 10";
    $printData = $thisDb->dbQuery($sql);
    foreach($printData AS $data){
        $element = array();
        $element['printerName'] = $data['printerName'];
        $element['paperWidth'] = $data['paperWidth'];
        $element['paperHeight'] = $data['paperHeight'];
        $element['codeWidth'] = $data['codeWidth'];
        $element['codeHeight'] = $data['codeHeight'];
        $element['fontSize'] = $data['fontSize'];

        $element['label'] = $data['label'];
        $element['label_2'] = $data['label_2'];
        $element['code'] = $data['code'];
        $element['amount'] = $data['amount'];

        $element['token'] = $token;
        $element['id'] = $data['id'];
        $element['callback'] = $domain."api/delprint.php";
    
        array_push($erg, $element);
    }
}

echo json_encode($erg);?>