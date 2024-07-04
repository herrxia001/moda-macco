<?php
/*
	File:		getSupsInvs.php	
	Purpose:	return inv count and value group by sup
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$invs = dbQuerySupsInvs();
if($invs <= 0)
	echo json_encode("NO");
else		
	echo json_encode($invs);

?>
