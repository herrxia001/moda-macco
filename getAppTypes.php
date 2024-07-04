<?php
/********************************************************************
	File:		getAppTypes.php	
	Purpose:	return all APP types
********************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$types = dbAppTypesQuery();
if($types <= 0)
	echo json_encode("NO");
else		
	echo json_encode($types);

?>
