<?php
/*
	File:		postVariantDelete.php
	Purpose:	Delete variant
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if (isset($_POST['variant']))
{	
	$v = json_decode($_POST['variant'], true);
	$result = dbDeleteVariant($v);
	if ($result)
		echo json_encode("OK");
	else
		echo json_encode("NO");
}
else
	echo json_encode("NO");

?>
