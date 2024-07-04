<?php
/* 	
	File:		getArtPurs.php
	Purpose: 	Query all purchases of articles (filter by date)
	Return: 	purchases
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

$myPurs = dbQueryArtPurs($_GET['timefrom'], $_GET['timeto'], $_GET['option']);
if($myPurs <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myPurs);	

?>
