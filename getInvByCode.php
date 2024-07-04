<?php
/* 	
	File:		getInvByCode.php
	Purpose: 	Query inventory by i_code. Used by JS through AJAX.
	Return: 	May return multi inventory records.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if($_GET['code'])
{
	$inv = dbQueryInvByCode($_GET['code']);
	if($inv <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($inv);
}
else
	echo json_encode("NO");


?>
