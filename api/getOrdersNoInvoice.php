<?php
/* 	
	File:		getOrdersNoInvoice.php
	Purpose: 	Query all orders without Invoice (filter by date)
	Return: 	orders.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:../index.php");

include_once '../database.php';

function dbQueryOrdersWithoutInvoice($timefrom, $timeto)
{
	$thisDb = new myDatabase($_SESSION['uDb']);
	if ($timefrom != NULL && $timeto != NULL)
		$sqlQuery = "SELECT orders.*, SUM(items.count*items.unit) AS s_count_sum, SUM(items.count*items.unit*items.cost) AS s_cost_sum, SUM(items.count*items.unit*items.price) AS s_price_sum
			FROM orders AS orders, order_items AS items
			WHERE orders.o_id=items.o_id AND orders.date>='".$timefrom." 00:00:00' AND orders.date<='".$timeto." 23:59:59' AND orders.o_id NOT IN (SELECT o_id FROM a_invoice WHERE a_invoice.date>='".$timefrom." 00:00:00' AND a_invoice.date<='".$timeto." 23:59:59' UNION SELECT o_id FROM a_in_void WHERE a_in_void.date>='".$timefrom." 00:00:00' AND a_in_void.date<='".$timeto." 23:59:59' UNION SELECT o_id FROM a_refund WHERE a_refund.date>='".$timefrom." 00:00:00' AND a_refund.date<='".$timeto." 23:59:59')
			GROUP BY orders.o_id ORDER BY orders.date DESC";
	else
		$sqlQuery = "SELECT * FROM orders WHERE o_id NOT IN (SELECT o_id FROM a_invoice UNION SELECT o_id FROM a_in_void UNION SELECT o_id FROM a_refund))";

    $thisQuery = $thisDb->dbQuery($sqlQuery);
	$thisDb->dbClose();
	
	return $thisQuery;
}


if(isset($_GET['timefrom']) && isset($_GET['timeto']))
	$myOrders = dbQueryOrdersWithoutInvoice($_GET['timefrom'], $_GET['timeto']);
else
	$myOrders = dbQueryOrdersWithoutInvoice(NULL, NULL);
if($myOrders <= 0)
	echo json_encode("NO");
else		
	echo json_encode($myOrders);	

?>
