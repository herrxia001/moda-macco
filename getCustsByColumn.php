<?php
/* 
	File:		getCustsByColumn.php
	Purpose:	Search customers by column
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if (isset($_GET['col']) && isset($_GET['val']))
{
	$custs = dbQueryCustsByColumn($_GET['col'], $_GET['val']);
	if($custs <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($custs);
}
else
	echo json_encode("NO");
?>
