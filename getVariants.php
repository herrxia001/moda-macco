<?php
/* 	
	File:		getVariants.php
	Purpose: 	Query all variants
	Return: 	Variants.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$variants = dbQueryVariants();
if($variants <= 0)
	echo json_encode("NO");
else		
	echo json_encode($variants);

?>
