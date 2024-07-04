<?php
/* 	
	File:		getRefunds.php
	Purpose: 	Query all refunds (filter by date)
	Return: 	refunds.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_GET['timefrom']) && isset($_GET['timeto']))
{
	$myRefunds = dbQueryRefunds($_GET['timefrom'], $_GET['timeto']);
}
else
	$myRefunds = dbQueryRefunds(NULL, NULL);
	
if($myRefunds <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myRefunds);	

?>
