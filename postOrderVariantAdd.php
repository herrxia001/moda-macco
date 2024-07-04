<?php
/*
	File:		postOrderVariantAdd.php
	Purpose:	Add new order_variant to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['ordervariant']))
{
	$ordervariant = json_decode($_POST['ordervariant'], true);
	$result = dbAddOrderVariant($ordervariant);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
