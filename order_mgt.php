<?php
/********************************************************************************
	File:		order_mgt.php
	Purpose:	order management	
*********************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

// Init variables
$myCustomers = dbQueryAllCustomers();
$myUsers = dbQueryAllUsers();
$active[3] = "active";
?>

<!doctype html>
<html lang="zh">
<head>
    <?php include 'include/header.php' ?>
	<title>MODAS - Order Management</title>
</head>

<body>
	<?php include 'include/nav.php' ?>
	<?php include "include/modalSelTime.php" ?>
	<?php include "include/modalCustSrchNew.php" ?>
	
	<div class="container">
		
<!-- buttons -->
		<div class="row">
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4">
				<button type="button" class="btn btn-outline-secondary" id="selTime" onclick="selectTime()">
					<?php echo $thisResource->mdTimeRdDay ?></button>
				<button type="button" class="ml-1 btn btn-outline-secondary" id="btnSelCust" onclick="selCust()"><span class='fa fa-user'></span></button>
				<button type="button" class="ml-1 btn btn-outline-secondary" id="btnAllCust" onclick="allCust()"><span class='fa fa-users'></span></button>
			</div>
<?php if ($_SESSION['uRole'] == 0) { ?>	
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-2" align="left">
				<div class="dropdown">
				<button type="button" class="btn btn-outline-secondary dropdown-toggle" id="userOption" data-toggle="dropdown" style="width:130px">
					<?php echo $thisResource->comUserAll ?></button>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#" onclick="filterUser(this)"><?php echo $thisResource->comUserAll ?></a>
						<?php for($i=0; $i<count($myUsers); $i++) {
						echo '<a class="dropdown-item" href="#" onclick="filterUser(this)">'.$myUsers[$i]['u_name'].'</a>';
						} ?> 
					</div>
				</div>
			</div>
<?php } ?>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-2" align="right">
				<button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
					<?php echo $thisResource->comOptions ?></button>
				<div class="dropdown-menu">
					<div class="dropdown-item" href="#" onclick="mergeOrder()"><?php echo $thisResource->comOrderMerge ?></div>
				</div>
				<button type="button" class="ml-1 btn btn-primary" onclick="newOrder()"><span class='fa fa-plus'></span></button>
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
		
	</div> <!-- End of container -->

</body>

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?202108130959"></script>
<script src="js/modalSelTime.js?202106011052"></script>
<script src="js/modalCustSearch.js?202109090946"></script>

<script>
/*****************************************************************************
	PHP VARIABLES
*****************************************************************************/
var myDb = <?php echo json_encode($_SESSION['uDb']) ?>;
var myRes = <?php echo json_encode($thisResource) ?>;
var myUserId = <?php echo json_encode($_SESSION['uId']) ?>;
var myRole = <?php echo json_encode($_SESSION['uRole']) ?>;
var myUsers = <?php echo json_encode($myUsers) ?>;
var customers = <?php echo json_encode($myCustomers) ?>;

/*****************************************************************************
	LOCAL VARIABLES
*****************************************************************************/
var orders = new Array(), orderCount = 0;
var $table = $("#table");
var link = "getOrders.php";
var countTotal = 0, priceTotal = 0, profitTotal = 0, recordTotal;
var sortCol = "date", sortOp = 1;
var selectUser = "";
var myCustomer = null;
var custOption = 0;

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

// Display summary
function displaySum(){
	document.getElementById("sumRecord").innerText = recordTotal;
	document.getElementById("sumCount").innerText = countTotal;
	document.getElementById("sumPrice").innerText = priceTotal.toFixed(2);
	document.getElementById("sumProfit").innerText = profitTotal.toFixed(2);
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
		var s_total_sum = parseFloat(orders[i]['price_sum'])*(1-parseFloat(orders[i]['discount_rate'])/100);
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
		if (orders[i]['total_sum'] == "" || orders[i]['total_sum'] == "0.00")
			continue;
		if (myCustomer != null && orders[i]['k_id'] != myCustomer['k_id'])
			continue;
		if (myRole == "1" && orders[i]['u_id'] != myUserId)
			continue;
		if (myRole == "0" && selectUser != "" && orders[i]['u_id'] != selectUser)
			continue;
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
	// maintain previous scroll position
	var pos = localStorage.getItem("order_mgt_scrolltop");
	document.documentElement.scrollTop = pos;
	localStorage.setItem("order_mgt_scrolltop", 0)
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

function afterSearch(result){
	orders = result;
	orderCount = orders.length;
	loadTable();
}

function displayNo(result) {
	orders = null;
	orderCount = 0;
	$table.bootstrapTable('removeAll');
	recordTotal = 0;
	countTotal = 0;
	priceTotal = 0;
	profitTotal = 0;
	displaySum();
}

function searchOrders(){
	var timeResult = mdstGetValue();
	var link = "getOrders.php?";
	if (timeResult != "")
		link += timeResult;
	getRequest(link, afterSearch, displayNo);
}

$(document).ready(function(){
	// Display Title
	document.getElementById("myTitle").innerHTML = myRes['comOrder'];	
	// Get options
	var timeChecked = localStorage.getItem("order_mgt_timecheck");
	if (timeChecked == null)
		mdstSetChecked("timeToday");
	else
		mdstSetChecked(timeChecked);
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	myCustomer = JSON.parse(localStorage.getItem("order_mgt_customer"));
	sortCol = localStorage.getItem("order_mgt_sortcol"); 
	sortOp = localStorage.getItem("order_mgt_sortop");
	if (sortCol == null)
		sortCol = "date";
	if (sortOp == null)
		sortOp = 1;
	// Search by default
	searchOrders();
 });

// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

// Click a row to view product
$('#table').on('click-row.bs.table', function (e, row, $element) {
	// save the current scroll position
	var pos =  document.documentElement.scrollTop;
	localStorage.setItem("order_mgt_scrolltop", pos);
	// view order
	var url = "order_new.php?back=order_mgt&o_id="+row.id;
	window.location.assign(url);
});

// Sort
$('#table').on('sort.bs.table', function (e, name, order) {
	switch(name) {
		case "idx_time": sortCol = 'date';  break;
		case "idx_user": sortCol = 'k_name';  break;
		case "idx_count": sortCol = 's_count_sum';  break;
		case "idx_total": sortCol = 's_total_sum';  break;
		case "idx_profit": sortCol = 'profit_rate';  break;
		default: sortCol = "date"; 
	}
	if (order == "asc")
		sortOp = 0;
	else
		sortOp = 1;
	localStorage.setItem("order_mgt_sortcol", sortCol);
	localStorage.setItem("order_mgt_sortop", sortOp); 
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
	localStorage.setItem("order_mgt_timecheck", timeChecked);
	
	searchOrders();
}

// New order
function newOrder() {
	var url = "order_new.php?back=order_mgt";
	window.location.assign(url);
}

// Customer
function selCust() {
	custOption = 0;
	mksInit(2);
	$modalCustSearch.modal();	
}
// modalCustSearch
function mksDoneNext(customer) {
	if (custOption == 1) {
		startMerge(customer);
	} else {
		myCustomer = customer;
		localStorage.setItem("order_mgt_customer", JSON.stringify(myCustomer));
		loadTable();
	}
	
}

// All customers
function allCust() {
	myCustomer = null;
	localStorage.setItem("order_mgt_customer", null);
	loadTable();
}
// Select user
function filterUser(e) {
	var user = $(e).text();
	document.getElementById("userOption").innerText = user;
	
	if (user == myRes['comUserAll'])
		selectUser = "";
	else {
		for (var i=0; i<myUsers.length; i++) {
			if (myUsers[i]['u_name'] == user) {
				selectUser = myUsers[i]['u_id'];
				break;
			}
		}
	}
	loadTable();
}

/*****************************************************************************
	MERGE ORDER
*****************************************************************************/
function mergeOrder() {
	custOption = 1;
	mksInit(2);
	$modalCustSearch.modal();
}

function startMerge(customer) {
	if (customer == null || customer['k_id'] == "0")
		return;
	var kId = customer['k_id'];
	var url = "order_merge.php?back=order_mgt&k_id="+kId;
	window.location.assign(url);
}

</script>

</html>
