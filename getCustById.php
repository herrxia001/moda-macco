<?php
/*
	File: 		getCustById.php
	Purpose:	Query customer by k_id
	Return:		Customer
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['k_id']))
{
	$cust = dbQueryCustomerById($_GET['k_id']);
	if($cust <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($cust);
}
else
	echo json_encode("NO");

?>
