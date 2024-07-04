<?php
/* 	
	File:		getSalesReportPurById.php
	Purpose: 	Sales report purchase by i_id
	Return: 	Report
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['id']) && isset($_GET['timefrom']) && isset($_GET['timeto']))
{
	$mySalesReport = dbGetPurReportById($_GET['id'], $_GET['timefrom'], $_GET['timeto']);
	if($mySalesReport <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($mySalesReport);	
}
else
	echo json_encode("NO");


?>
