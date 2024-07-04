<?php
/* 	
	File:		getArts.php
	Purpose: 	Query all articles.
	Return: 	All articles.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

$inv = dbQueryArticles();
if($inv < 0)
	echo json_encode("NO");
else		
	echo json_encode($inv);

?>
