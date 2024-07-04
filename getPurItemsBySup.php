<?php
/* 	
	File:		getPurItemsBySup.php
	Purpose: 	Query all purchase items by supplier
	Return: 	purchases.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['s_id']) && isset($_GET['timefrom']) && isset($_GET['timeto']))
{
	$myPurs = dbQueryPurItems($_GET['timefrom'], $_GET['timeto'], $_GET['s_id']);
	if($myPurs <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($myPurs);	
}
else
	echo json_encode("NO");

?>
