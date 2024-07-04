<?php
/*
	File: postInvSale.php
	Purpose: add sales discount
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once '../db_functions.php';

function postInvSale($i_code,$discount){
    $thisDb = new myDatabase($_SESSION['uDb']);
	$sqlQuery = "UPDATE inventory SET discount = '".$discount."' WHERE i_code = '".$i_code."'";   
	$thisDb->dbQuery($sqlQuery);
	echo json_encode("OK");
}

if(isset($_POST['i_code']))
{
	$i_code = $_POST['i_code'];
    $discount = $_POST['discount'];
	postInvSale($i_code,$discount);
}
else
	echo json_encode("NO");

?>