<?php
/* 
	File:		getSupsByColumn.php
	Purpose:	Search supplier by column
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if (isset($_GET['col']) && isset($_GET['val']))
{
	$sups = dbQuerySupsByColumn($_GET['col'], $_GET['val']);
	if($sups <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($sups);
}
else
	echo json_encode("NO");
?>
