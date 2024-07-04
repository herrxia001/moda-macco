<?php
/* 	
	File:		getPurById.php
	Purpose: 	Query purchase by p_id
	Return: 	purchase
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['p_id']))
{
	$myPur = dbQueryPurById($_GET['p_id']);	
	if($myPur <= 0)
		echo json_encode("NO");
	else
		echo json_encode($myPur);
}
else		
	echo json_encode("NO");	

?>
