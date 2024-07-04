<?php
/* 	
	File:		getArtHistById.php
	Purpose: 	Query article by id.
	Return: 	May return multi articles records.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if($_GET['id'] && $_GET['year']){
	$inv = dbQueryArtHistById($_GET['id'], $_GET['year'], $_GET['month']);
	if($inv <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($inv);
} else {
	echo json_encode("NO");
}


?>
