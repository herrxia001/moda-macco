<?php
/* 	
	File:		getVariant.php
	Purpose: 	Query variant by i_id
	Return: 	Variant.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['i_id']))
{
	$result = dbQueryVariant($_GET['i_id']);
	if($result > 0)
		echo json_encode($result);
	else
		echo json_encode("NO");		
}
else
	echo json_encode("NO");

?>
