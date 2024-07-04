<?php
include_once '../db_functions.php';
$erg = array();
$erg['st'] = -1;
$erg['msg'] = "用户名密码错误";
$erg['token'] = "";
$username = $_GET['username'];
$pwd = $_GET['pwd'];
$token = $_GET['token'];

$thisDb = new myDatabase($root_db);
if($token == ""){
    $sqlQuery = "SELECT * FROM users WHERE u_name='".strtolower($username)."'";
    $userData = $thisDb->dbQuery($sqlQuery);
    if(password_verify($pwd, $userData[0]['u_password'])){
        if($userData[0]['printToken'] == ""){
            $token = uniqid();
            $sqlQuery = "UPDATE users SET printToken = '".$token."' WHERE u_id = '".$userData[0]['u_id']."'";
            $thisDb->dbQuery($sqlQuery);
        }else $token = $userData[0]['printToken'];
        $erg['st'] = 1;
        $erg['msg'] = "登入成功";
        $erg['token'] = $token;
    }
}else{
    $sqlQuery = "SELECT * FROM users WHERE printToken='".$token."'";
    $userData = $thisDb->dbQuery($sqlQuery);
    if(!$userData <= 0){
        $erg['st'] = 1;
        $erg['msg'] = "登入成功";
        $erg['token'] = $token;
    }
}
echo json_encode($erg); ?>