<?php
/*
	File:		postVariantUpdate.php
	Purpose:	Update variant
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if (isset($_POST['variant']))
{	
	$v = json_decode($_POST['variant'], true);
	$result = dbUpdateVariant($v);

	if ($result)
		echo json_encode("OK");
	else
		echo json_encode("NO");
}
else
	echo json_encode("NO");

?>
