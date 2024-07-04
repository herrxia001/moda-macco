<?php
/*
	File: postAppProductUpdate.php
	Purpose: update the app_product
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['product']))
{
	$product = json_decode($_POST['product'], true);
	$result = dbAppProductUpdate($product);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
