<?php
/************************************************************************************
	apPostUserUpdate.php
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$company = json_decode($_POST['company'], true);
$result = dbAppUsersUpdate($_POST['apc_id'], $company);
if($result <= 0)
	echo json_encode("NO");
else		
	echo json_encode("OK");

?>
