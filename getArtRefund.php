<?php
/* 	
	File:		getArtRefund.php
	Purpose: 	Query all refunds of articles (filter by date)
	Return: 	refunds.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

$myRefunds = dbQueryArtRefund($_GET['timefrom'], $_GET['timeto'], $_GET['option']);
if($myRefunds <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myRefunds);	

?>
