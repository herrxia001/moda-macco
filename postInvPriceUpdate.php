<?php

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if (isset($_POST['price'])) {	
	$price = json_decode($_POST['price'], true);
	$result = dbInvPriceUpdate($_POST['i_id'], $price); 

	if ($result > 0)
		echo json_encode($result);
	else
		echo json_encode("NO");
} else {
	echo json_encode("NO");
}

?>
