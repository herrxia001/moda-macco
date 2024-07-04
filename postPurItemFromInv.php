<?php
/*
	File:		postPurItemFromInv.php
	Purpose:	After creating a new product, add new pur_item to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['puritem'])) {
	$puritem = json_decode($_POST['puritem']);
	$result = dbAddPurItemOne($puritem);
	dbUpdatePurSum($puritem);

	if (isset($_POST['purvariant'])) {
		$purvariant = json_decode($_POST['purvariant'], true);
		$result = dbAddPurVariantFromInv($purvariant);
	}
	
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else {
	echo json_encode("NO");
}

?>
