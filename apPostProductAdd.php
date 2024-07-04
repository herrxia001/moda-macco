<?php
/********************************************************************
	apPostProductAdd
********************************************************************/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['data'])) {
	$data = json_decode($_POST['data'], true);
	$images = json_decode($_POST['images'], true);
	$result = dbAppProductAdd($data, $images);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
} else {
	echo json_encode("NO");
}

?>
