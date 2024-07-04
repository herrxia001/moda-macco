<?php
/* 	
	File:		delOrderWithoutInvoice.php
	Purpose: 	Delete Orders without Invoice
	Return: 	orders.
*/
session_start();
include_once '../database.php';
function delOrdersWithoutInvoice($o_id){
	$thisDb = new myDatabase($_SESSION['uDb']);

    $sql = "INSERT INTO orders_archiv SELECT * FROM orders WHERE o_id = '".$o_id."'";
	$thisDb->dbUpdate($sql);
	$sql = "INSERT INTO order_items_archiv SELECT * FROM order_items WHERE o_id = '".$o_id."'";
	$thisDb->dbUpdate($sql);
	$sql = "INSERT INTO order_variant_archiv SELECT * FROM order_variant WHERE o_id = '".$o_id."'";
	$thisDb->dbUpdate($sql);

	$sql = "DELETE FROM orders WHERE o_id = '".$o_id."'";
	$thisDb->dbUpdate($sql);

	$thisDb->dbClose();
	
}

if(!$_SESSION['uId'])
    echo json_encode("NO");
else{
    delOrdersWithoutInvoice($_GET['o_id']);
    echo json_encode("YES");
}
?>