<?php
/* 	
	File:		getHist.php
	Purpose: 	Query history by i_id. Used by JS through AJAX.
	Return: 	Records from table 'history'.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if($_GET['id'])
{
	$log = dbQueryInvLog($_GET['id']);
	if($log <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($log);	
}
else
	echo json_encode("NO");


?>
