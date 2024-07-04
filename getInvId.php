<?php
/* 
getInvId.php

AJAX: get new inventory ID
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$id = dbGetInvId();
if($id <= 0)
	echo json_encode("0");
else		
	echo json_encode($id);

?>
