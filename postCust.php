<?php
/*
	File:		postCust.php
	Purpose:	Add or update customer to database.
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['cust']))
{
	$cust = json_decode($_POST['cust'], true);
	if ($cust['k_id'] == '')
		$result = dbAddCustomer($cust);
	else
		$result = dbUpdateCustomer($cust['k_id'], $cust);
		
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode($result);
}
else
	echo json_encode("NO");

?>
