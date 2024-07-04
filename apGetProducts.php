<?php
/************************************************************************************
	apGetProducts.php
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$products = dbAppProductsQuery();
if($products < 0)
	echo json_encode("NO");
else		
	echo json_encode($products);

?>
