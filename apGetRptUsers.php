<?php
/************************************************************************************
	apGetRptUsers.php
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$myUsers = dbAppRptGetUsers($_GET['timefrom'], $_GET['timeto']);
if($myUsers <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myUsers);	

?>
