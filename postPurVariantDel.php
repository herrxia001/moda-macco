<?php
/*
	File:		postPurVariantDel.php
	Purpose:	Delete pur_variant from database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['purvariant']))
{
	$purvariant = json_decode($_POST['purvariant'], true);
	$result = dbDeletePurVariant($purvariant);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
