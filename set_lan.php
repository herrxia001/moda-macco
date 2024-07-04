<?php
/************************************************************************************
	File:		set_lan.php
	Purpose:	set language
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

if($_GET['lan'])
{	
	$lan = $_GET['lan'];
	if ($lan == "en")
		$_SESSION['uLanguage'] = "en";
	else if ($lan == "de")
		$_SESSION['uLanguage'] = "de";
	else if ($lan == "it")
		$_SESSION['uLanguage'] = "it";
	else
		$_SESSION['uLanguage'] = "cn";
	header("Location:home.php");	
}

?>
