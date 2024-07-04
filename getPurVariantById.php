<?php
/* 	
	File:		getPurVariantById.php
	Purpose: 	Query all pur_variant by p_id.
	Return: 	pur_variant.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['p_id']))
{
	$myPurVariant = dbQueryPurVariantById($_GET['p_id']);	
	if(	$myPurVariant <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myPurVariant);		
}
else
	echo json_encode("NO");

?>
