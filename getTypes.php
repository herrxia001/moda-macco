<?php
/*
	File:		getTypes.php	
	Purpose:	return all product types from server
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$types = dbQueryTypes();
if($types <= 0)
	echo json_encode("NO");
else		
	echo json_encode($types);

?>
