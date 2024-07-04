<?php
/*
	File:		postOrderVariantDel.php
	Purpose:	Delete order_variant from database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['ordervariant']))
{
	$ordervariant = json_decode($_POST['ordervariant'], true);
	$result = dbDeleteOrderVariant($ordervariant);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
