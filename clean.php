<?php
/************************************************************************************
	File:		clean.php
	Purpose:	clean data
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");
include 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();
$myCustomers = dbQueryAllCustomers();

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - clean</title>
</head>
<style>
body {
 padding-top: 0rem;
}
.loader {
  position: fixed;
  left: 30%;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 80px;
  height: 80px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<body>
<?php include "include/modalDel.php" ?>
<?php include "include/modalSelTime.php" ?>

    <div class="container">

	<div class="row mb-2">
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey">
			<a class="btn" href="settings.php" role="button"><span style="color:white" class='fa fa-arrow-left'></span></a>
		</div>
		<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-4"  style="background-color: DarkSlateGrey" align="center"> 
			<a style="color: white; font-weight: bold">订单清理</a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey" align="right">
		</div>
	</div>
	
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-7">
			<button type="button" class="btn btn-outline-secondary" id="selTime" onclick="selectTime()">
				<?php echo $thisResource->mdTimeRdDay ?></button>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-1" align="right">
			<button id="clear_btn" type="button" class="mx-1 btn btn-primary" onclick="check()">清除</button>
		</div>
	</div>
	
	<!-- summary -->
	<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8" style="border:1px solid lightgray;" align="center">
				<a><?php echo $thisResource->comTotalRecord ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumRecord"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalQuantity ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumCount"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalGross ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumPrice"></a>
<?php if ($_SESSION['uRole'] == 0) { ?>	
				<a>&nbsp;&nbsp;<?php echo $thisResource->comProfit ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumProfit"></a>
<?php } ?>
			</div>
		</div>
<!-- Search result table -->
<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
		<table id="table" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">
			<thead class="thead-light">
				<tr>
				<th class="p-1" data-field="id" data-width="0" data-width-unit="%" data-visible="false"><?php echo $thisResource->comOrderNo ?></th>
				<th class="p-1" data-field="idx_time" data-width="20" data-width-unit="%" data-halign="center" data-sortable="true"><?php echo $thisResource->comTime ?></th>
				<th class="p-1" data-field="idx_user" data-width="30" data-width-unit="%" data-halign="center" data-sortable="true"><?php echo $thisResource->comCustomer ?></th>				
				<th class="p-1" data-field="idx_count" data-width="15" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comQuantity ?></th>
				<th class="p-1" data-field="idx_total" data-width="20" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comValue ?></th>
<?php if ($_SESSION['uRole'] == 0) { ?>				
				<th class="p-1" data-field="idx_profit" data-width="15" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comProfit ?>%</th>
<?php } ?>				
				</tr>
			</thead>
			<tbody>
			<!-- load table by JS -->
			</tbody>
		</table>
		</div>
		</div>




	</div>

	<script src="js/ajax.js"></script>
	<script src="js/modalDel.js"></script>
	<script src="js/modalSelTime.js?<?= rand() ?>"></script>
<script>
var orders = new Array(), orderCount = 0;
var $table = $("#table");
var countTotal = 0, priceTotal = 0, profitTotal = 0, recordTotal;
var sortCol = "date", sortOp = 1;
var customers = <?php echo json_encode($myCustomers) ?>;
var myRes = <?php echo json_encode($thisResource) ?>;

function getCustNameById(kid) {
	for (var i=0; i<customers.length; i++) {
		if (customers[i]['k_id'] == kid)
			return customers[i]['k_name'];
	}
	
	return myRes['comCustomerUnknown'];
}

$table.bootstrapTable({   
	formatNoMatches: function () {
         return myRes['sysMsgNoRecord'];
    }
});

$(document).ready(function(){	
	// Get options
	var timeChecked = localStorage.getItem("order_clean_timecheck");
	if (timeChecked == null)
		mdstSetChecked("timeToday");
	else
		mdstSetChecked(timeChecked);
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	searchOrders();
});

	// Show time selection (modalTime)
function selectTime(){
	$modalSelTime.modal();
}

// Finish time selection (modalTime)
function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
	 
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	// save time option
	var timeChecked = mdstGetChecked();
	localStorage.setItem("order_clean_timecheck", timeChecked);
	searchOrders();
}
function searchOrders(){
	$("#clear_btn").show();
	$table.find("tbody").html('<div class="loader" id="loader"></div>');
	var timeResult = mdstGetValue();
	var link = "api/getOrdersNoInvoice.php?";
	//var link = "getOrders.php?";
	if (timeResult != "")
		link += timeResult;
	getRequest(link, afterSearch, displayNo);
}
function afterSearch(result){
	orders = result;
	orderCount = orders.length;
	$table.find("tbody").html('');
	loadTable();
}

function displayNo(result) {
	$table.find("tbody").html('');
	orders = null;
	orderCount = 0;
	$table.bootstrapTable('removeAll');
	recordTotal = 0;
	countTotal = 0;
	priceTotal = 0;
	profitTotal = 0;
	displaySum();
}

function loadTable(){
	recordTotal = 0;
	countTotal = 0;
	priceTotal = 0;
	profitTotal = 0;
	if (orderCount <= 0) {
		displaySum();
		return;
	}

	for(var i=0; i<orderCount; i++){
		orders[i]['k_name'] = getCustNameById(orders[i]['k_id']);
		var s_total_sum = parseFloat(orders[i]['s_price_sum'])*(1-parseFloat(orders[i]['discount_rate'])/100);
		orders[i]['s_total_sum'] = s_total_sum.toFixed(2);
		var profit = s_total_sum- parseFloat(orders[i]['s_cost_sum']);
		orders[i]['profit'] = profit;
		var rate = 100*profit/s_total_sum;
		orders[i]['profit_rate'] = rate.toFixed(2);
	}
	orders.sort(sortTable(sortCol, sortOp));
	$table.bootstrapTable('removeAll');	
	var rows = [];
	var timeStr = "";
	for(var i=0; i<orderCount; i++){
		if (parseInt(orders[i]['status']) >= 10)
			timeStr = "<a style='background-color:lightgreen'>"+orders[i]['date'].substring(5,16)+"</a>";
		else
			timeStr = "<a>"+orders[i]['date'].substring(5,16)+"</a>";
		rows.push({
			id: orders[i]['o_id'],
			idx_time: timeStr,
			idx_user: orders[i]['k_name'].substring(0,20),
			idx_count: orders[i]['s_count_sum'],
			idx_total: orders[i]['s_total_sum'],
			idx_profit: orders[i]['profit_rate']+"%"
		});
		countTotal += parseInt(orders[i]['s_count_sum']);
		priceTotal += parseFloat(orders[i]['s_total_sum']);
		profitTotal += parseFloat(orders[i]['profit']);
		recordTotal++;
	}
	$table.bootstrapTable('append', rows);	
	displaySum();
}
function sortTable(key, option){
    return function(a, b){ 
		var x = a[key]; var y = b[key];
		if (key == "date") {
			var x1 = a[key].substring(0,10); var x2 = a[key].substring(11,19); x = x1+"T"+x2; x = new Date(x); 
			var y1 = b[key].substring(0,10); var y2 = b[key].substring(11,19); y = y1+"T"+y2; y = new Date(y);
		}
		if (key == "s_count_sum") {
			x= parseInt(x); y = parseInt(y);
		}
		if (key == "s_total_sum") {
			x= parseFloat(x); y = parseFloat(y);
		}
		if (key == "profit_rate") {
			x= parseFloat(x); y = parseFloat(y);
		}
		if(option == 1){
			return ((x < y) ? 1 : ((x > y) ? -1 : 0));
		}
		else {
			return ((x < y) ? -1 : ((x > y) ? 1 : 0));
		}  
    }    
} 

// Display summary
function displaySum(){
	document.getElementById("sumRecord").innerText = recordTotal;
	document.getElementById("sumCount").innerText = countTotal;
	document.getElementById("sumPrice").innerText = priceTotal.toFixed(2);
	document.getElementById("sumProfit").innerText = profitTotal.toFixed(2);
}

var index = 0;

 function check(){
	if (!confirm("确定删除所有的没开发票的订单")) {
		return false;
	}
	index = 0;
	$("#clear_btn").hide();
	showDelModal(delCleanOrder);
	return false;
 }

 function delCleanOrder(){
	var link = "api/delOrderWithoutInvoice.php?o_id="+orders[index].o_id;
	console.log(link);
	getRequest(link, afterDel, displayNoDel);
 }
function afterDel(){
	$table.find("tr[data-index='"+index+"']").addClass('bg-primary').remove();
	index++;
	if(index < orders.length) delCleanOrder();
	else searchOrders();
}
function displayNoDel(){}
</script>

</body>
</html>
