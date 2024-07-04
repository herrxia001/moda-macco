<?php
/************************************************************************************
	getOrderPrice.php
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_GET['k_id']) && isset($_GET['i_id'])) {
	$result = dbOrderPriceQuery($_GET['k_id'], $_GET['i_id']);
	if ($result <= 0)
		echo json_encode("NO");	
	else
		echo json_encode($result);	

} else		
	echo json_encode("NO");	

?>
