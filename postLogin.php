<?php
/*
	File:		postLogin.php
	Purpose:	Login
*/

session_start();

include_once 'db_functions.php';

if(isset($_POST['user']) && isset($_POST['password']))
{
	$user = json_decode($_POST['user'], true);
	$password = json_decode($_POST['password'], true);
	$tabID = json_decode($_POST['tabID'], true);
	$result = dbLogin($user, $password, $tabID);

	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
