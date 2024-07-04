<?php
/*
	File:		postPurVariantAdd.php
	Purpose:	Add new pur_variant to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['purvariant']))
{
	$purvariant = json_decode($_POST['purvariant'], true);
	$result = dbAddPurVariant($purvariant);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
