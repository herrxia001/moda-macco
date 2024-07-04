<?php
/********************************************************************************
	File:		postPurDel.php
	Purpose:	remove one pur and purr_items	
*********************************************************************************/ 

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['pur']))
{
	$pur = json_decode($_POST['pur'], true);
	if(isset($_POST['puritems']))
		$puritems = json_decode($_POST['puritems'], true);
	else
		$puritems = NULL;
	if(isset($_POST['purvariants']))
		$purvariants = json_decode($_POST['purvariants'], true);
	else
		$purvariants = NULL;	
	$result = dbDelPur($pur, $puritems, $purvariants);

	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
