<?php
/************************************************************************************
	File:		logout.php
	Purpose:	logout
************************************************************************************/
session_start();

include_once 'db_functions.php';

$_SESSION['uId'] = '';
$_SESSION['cId'] = '';
$_SESSION['uName'] = '';
$_SESSION['uDb'] = '';
$_SESSION['uLanguage'] = '';	
	
header("Location:index.php");
		
?>
