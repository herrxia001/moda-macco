<?php
/*
	File:		postVariantAdd.php
	Purpose:	Add a new variant
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if (isset($_POST['variant']))
{	
	$v = json_decode($_POST['variant'], true);
	$result = dbAddVariant($v);

	if ($result > 0)
		echo json_encode($result);
	else
		echo json_encode("NO");
}
else
	echo json_encode("NO");

?>
