<?php
/********************************************************************************
	File:		order_merge.php

*********************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

$backPhp = 'order_mgt.php';

if(isset($_GET['back'])) {
	$backPhp = $_GET['back'].'.php';
}
if (isset($_GET['k_id'])) {
	$myId = $_GET['k_id'];
	$myCustomer = dbQueryCustomerById($myId);
	
} else {	
	return;
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>MODAS - Order Merge</title>
</head>
<style>
body {
 padding-top: 0rem;
}
</style>

<body>
	<?php include "include/modalSelTime.php" ?>
	<?php include "include/modalOrderItems.php" ?>
	
	<div class="container">
		
<!-- buttons -->
		<div class="row">
			<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey">
				<a class="btn" href=<?php echo $backPhp ?> role="button"><span style="color:white" class='fa fa-arrow-left'></span></a>
			</div>
			<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-4" style="background-color: DarkSlateGrey" align="center">
				<label class="mt-2" style="color: white; font-weight: bold"><?php echo $thisResource->comOrderMerge ?></span></label>
			</div>
			<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey" align="right">
			</div>
		</div>
		<div class="row">
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-4">
				<button type="button" class="btn btn-outline-secondary" id="selTime" onclick="selectTime()">
					<?php echo $thisResource->mdstRdThisMonth ?></button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-4" align="right">
				<button type="button" class="ml-1 btn btn-primary" id="btnMerge" onclick="startMerge()"><?php echo $thisResource->comMergePreview ?></button>
			</div>
		</div>
<!-- summary -->
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8" style="border:1px solid lightgray;" align="center">
				<a><?php echo $thisResource->comMerge.$thisResource->comTotalRecord ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumRecord"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalQuantity ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumCount"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalGross ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumPrice"></a>
			</div>
		</div>
<!-- Search result table -->
		<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
		<table id="table" class="table-sm" data-toggle="table" data-click-to-select="true" data-unique-id="id">
			<thead class="thead-light">
				<tr>
				<th class="p-1" data-field="id" data-width="0" data-width-unit="%" data-visible="false"></th>
				<th data-field="idx_state" data-checkbox="true"></th>
				<th class="p-1" data-field="idx_time" data-width="35" data-width-unit="%" data-halign="center" data-sortable="true">
					<?php echo $thisResource->comTime ?></th>			
				<th class="p-1" data-field="idx_count" data-width="30" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true">
					<?php echo $thisResource->comQuantity ?></th>
				<th class="p-1" data-field="idx_total" data-width="30" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true">
					<?php echo $thisResource->comValue ?></th>			
				</tr>
			</thead>
			<tbody>
			<!-- load table by JS -->
			</tbody>
		</table>
		</div>
		</div>
		
	</div> <!-- End of container -->

<!-- Modal for order merge -->
<div class="modal fade" id="modalMerge" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

		<div class="modal-body">
<!-- top menu -->		
		<div class="row">
			<div class="p-1 col-6">
				<a><?php echo $thisResource->comQuantity ?>: </a><a id="mSumCount"></a>
				<a><?php echo $thisResource->comTotal ?>: </a><a id="mSumValue"></a>
			</div>
			<div class="p-1 col-6" align="right">
				<button type="button" class="btn btn-outline" onclick="mCancel()"><span class='fa fa-times'></span></button>
			</div>
		</div>
		<div class="row">
			<hr class="modalSepLine">
		</div>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<table id="mTable" data-toggle="table">
					<thead>
						<tr>
						<th data-field="idx_image" data-width="10" data-width-unit="%"></th>
						<th data-field="idx_code" data-sortable="true" data-width="30" data-width-unit="%"><?php echo $thisResource->comProductNo ?></th>
						<th data-field="idx_count" data-sortable="true" data-width="30" data-width-unit="%"><?php echo $thisResource->comQuantity ?></th>
						<th data-field="idx_price" data-sortable="true" data-width="30" data-width-unit="%"><?php echo $thisResource->comPrice ?></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
<!-- bottom menu -->
		<div class="row">
			<hr class="modalSepLine">
		</div>
		<div class="row">
			<div class="col p-1" align="right">				
				<button type="button" class="btn btn-outline-secondary" onclick="mCancel()" ><?php echo $thisResource->comBack ?></button>
				<button type="button" class="btn btn-primary" onclick="mMerge()" ><?php echo $thisResource->comMerge ?></button>
			</div>
		</div>
		
		</div>
		</div>
	</div>
</div> <!-- End of Modal for order merge -->


</body>

<script src="js/ajax.js"></script>
<script src="js/modalSelTime.js?2022-0408-1050"></script>
<script src="js/modalOrderItems.js?2022-0409-1343"></script>

<script>
/*****************************************************************************
	PHP VARIABLES
*****************************************************************************/
var myRes = <?php echo json_encode($thisResource) ?>;
var myId = <?php echo json_encode($myId) ?>;
var myCustomer = <?php echo json_encode($myCustomer) ?>;

/*****************************************************************************
	LOCAL VARIABLES
*****************************************************************************/
var orders = new Array(), orderItems = new Array(), orderVariants = new Array();
var $table = $("#table");
var countTotal = 0, priceTotal = 0, recordTotal = 0;
var checkedClick = false, uncheckedClick = false;
var mergeOrder = {}, mergeOrderItems = [], mergeOrderVariants = [];
var oldOrders = [];
// merge
var $modalMerge = $("#modalMerge");
var $tableMerge = $("#mTable");
/*****************************************************************************
	INIT
*****************************************************************************/
$(document).ready(function(){
	document.getElementById("btnMerge").disabled = true;
	mdstSetChecked("timeThisMonth");
	fTime = mdstGetValue(1); 
	searchOrders();
 });
 
// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

$table.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});

/*****************************************************************************
	LOAD
*****************************************************************************/
function searchOrders(){
	getRequest("getOrderByCus.php?k_id="+myId, searchYes, searchNo);
	getRequest("getOrderItemsByCus.php?k_id="+myId, searchItemsYes, searchItemsNo);
	getRequest("getOrderVariantsByCus.php?k_id="+myId, searchVariantsYes, searchVariantsNo);
}

function searchYes(result){ 
	orders = result;
	loadTable();
}

function searchNo(result){ 
	orders = new Array();
	loadTable();
}

function searchItemsYes(result){ 
	orderItems = result;
}

function searchItemsNo(result){ 
	orderItems = new Array();
}

function searchVariantsYes(result){ 
	orderVariants = result;
}

function searchVariantsNo(result){ 
	orderVariants = new Array();
}

function loadTable(){
	var rows = [];
	var timeStr = "";
	for(var i=0; i<orders.length; i++){ 
		if (orders[i]['date'].substr(0,10) < fTime['timefrom'] || orders[i]['date'].substr(0,10) > fTime['timeto'])
			continue;
		if (parseInt(orders[i]['status']) >= 10)
			timeStr = "<a style='background-color:lightgreen'>"+orders[i]['date'].substring(0,10)+"</a>";
		else
			timeStr = "<a>"+orders[i]['date'].substring(0,10)+"</a>";
		rows.push({
			id: orders[i]['o_id'],
			idx_time: timeStr,
			idx_count: orders[i]['count_sum'],
			idx_total: orders[i]['total_sum']
		});
	}
	$table.bootstrapTable('removeAll');	
	$table.bootstrapTable('append', rows);	
	displaySum();
}

/*****************************************************************************
	SELECTION
*****************************************************************************/
$table.on('check.bs.table', function (e, row, $element) { 
	if (checkedClick) {
		checkedClick = false;
		return;
	}
	if (uncheckedClick) {
		$table.bootstrapTable('uncheck', $element.data('index')); 
		return;
	}
	selectOrders();	
});

$table.on('uncheck.bs.table', function (e, row, $element) { 
	if (uncheckedClick) {
		uncheckedClick = false;
		return;
	}
	if (checkedClick) {
		$table.bootstrapTable('check', $element.data('index')); 
		return;
	}
	selectOrders();	
});

$table.on('check-all.bs.table uncheck-all.bs.table', function () { 
	selectOrders();	
});

function selectOrders() {
	recordTotal = 0;
	countTotal = 0;
	priceTotal = 0.00;
	var selections = [];
	
	selections = getIdSelections();
	for(var i=0; i<selections.length; i++){
		var item = getOrderById(selections[i]);
		if (item == 0)
			continue;
		recordTotal ++;
		countTotal += parseInt(item['count_sum']);
		priceTotal += parseFloat(item['price_sum']);
	}
	displaySum();
	if (selections.length > 0)
		document.getElementById("btnMerge").disabled = false;
	else
		document.getElementById("btnMerge").disabled = true;
}

function getIdSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
		return row.id
    })
}

function rowChecked(id) {
	var selections = getIdSelections();
	for(var i=0; i<selections.length; i++){
		if (selections[i] == id)
		return true;
	}
	return false;
}

function getOrderById(id) {
	for (var i=0; i<orders.length; i++) {
		if (orders[i]['o_id'] == id)
			return orders[i];
	}
	
	return 0;
}

function getOrderItemsById(id) {
	var items = new Array();
	for (var i=0; i<orderItems.length; i++) {
		if (orderItems[i]['o_id'] == id) {
			items.push(orderItems[i]);
		}
	}
	return items;
}

function getOrderVariantsById(id) {
	var variants = new Array();
	for (var i=0; i<orderVariants.length; i++) {
		if (orderVariants[i]['o_id'] == id) {
			variants.push(orderVariants[i]);
		}
	}
	return variants;
}

function displaySum(){
	document.getElementById("sumRecord").innerText = recordTotal;
	document.getElementById("sumCount").innerText = countTotal;
	document.getElementById("sumPrice").innerText = priceTotal.toFixed(2);
}

/*****************************************************************************
	VIEW ORDER
*****************************************************************************/
$('#table').on('click-row.bs.table', function (e, row, $element) {
	if (rowChecked(row.id))
		checkedClick = true;
	else
		uncheckedClick = true;
		
	var items = getOrderItemsById(row.id);  
	mdoiShow(items);
});

/*****************************************************************************
	TIME
*****************************************************************************/
function selectTime(){
	$modalSelTime.modal();
}

function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
		
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	
	fTime = mdstGetValue(1); 
	loadTable();
}

/*****************************************************************************
	MERGE
*****************************************************************************/
function startMerge() {
	mergeOrder = new Object();
	mergeOrderItems = new Array();
	mergeOrderVariants = new Array();
	oldOrders = new Array();
	
	var selections = getIdSelections();
	var ok = false, i = 0, j = 0, k = 0;
	
	// orderItems
	for(i=0; i<selections.length; i++){
		var selItems = getOrderItemsById( selections[i]);
		for (j=0; j<selItems.length; j++) {
			ok = false;
			for (k=0; k<mergeOrderItems.length; k++) {
			if (mergeOrderItems[k]['i_id'] == selItems[j]['i_id']) {
				var count = parseInt(mergeOrderItems[k]['count']) + parseInt(selItems[j]['count']);
				mergeOrderItems[k]['count'] = count.toString();
				ok = true;
				break;
				}
			}
			if (!ok) {
				var item = new Object();
				// database
				item['o_id'] = selItems[j]['o_id'];
				item['i_id'] = selItems[j]['i_id'];
				item['count'] = selItems[j]['count'];
				item['cost'] = selItems[j]['cost'];
				item['price'] = selItems[j]['price'];
				item['unit'] = selItems[j]['unit'];
				// display
				item['i_code'] = selItems[j]['i_code'];
				item['path'] = selItems[j]['path'];
				item['m_no'] = selItems[j]['m_no'];
				mergeOrderItems.push(item);
			}
		}
	}
	
	// orderVariants
	for(i=0; i<selections.length; i++){
		var selVariants = getOrderVariantsById( selections[i]);
		for (j=0; j<selVariants.length; j++) {
			ok = false;
			for (k=0; k<mergeOrderVariants.length; k++) {
				if (selVariants[j]['iv_id'] == mergeOrderVariants[k]['iv_id']) {
					var count = parseInt(mergeOrderVariants[k]['count']) + parseInt(selVariants[j]['count']);
					mergeOrderVariants[k]['count'] = count.toString();
					ok = true;
					break;
				}
			}
			if (!ok) {
				var variant = new Object();
				// database
				variant['o_id'] = selVariants[j]['o_id'];
				variant['i_id'] = selVariants[j]['i_id'];
				variant['iv_id'] = selVariants[j]['iv_id'];
				variant['count'] = selVariants[j]['count'];
				// display
				variant['variant'] = selVariants[j]['variant'];
				variant['m_no'] = selVariants[j]['m_no'];
				mergeOrderVariants.push(variant);
			}		
		}
	}

	// order
	var countSum = 0, priceSum = 0.00, profit = 0.00;
	for (i=0; i<mergeOrderItems.length; i++) {
		countSum += parseInt(mergeOrderItems[i]['count']);
		priceSum += parseInt(mergeOrderItems[i]['count']) * parseInt(mergeOrderItems[i]['unit']) * parseFloat(mergeOrderItems[i]['price']);
		profit += parseInt(mergeOrderItems[i]['count']) * parseInt(mergeOrderItems[i]['unit']) * (parseFloat(mergeOrderItems[i]['price'])  - parseFloat(mergeOrderItems[i]['cost']));
	}
	mergeOrder['k_id'] = myId;
	mergeOrder['count_sum'] = countSum;
	mergeOrder['price_sum'] = priceSum;
	mergeOrder['total_sum'] = priceSum;
	mergeOrder['due'] = priceSum;
	mergeOrder['profit'] = profit;
	
	// old orders
	for(i=0; i<selections.length; i++){
		var order = getOrderById(selections[i]);
		var items = getOrderItemsById(selections[i]); 
		order['orderitems'] = items; 
		var variants = getOrderVariantsById(selections[i]);
		order['ordervariants'] = variants;
		oldOrders.push(order);		
	}

	showMerge();
}

function showMerge(){
	var mItemsCount = 0, mItemsValue = 0;
	var imgSrc = "", imgStr = "";
	var rows = [];
	
	for (var i=0; i<mergeOrderItems.length; i++) {
		imgSrc = mergeOrderItems[i]['path']+"/"+mergeOrderItems[i]['i_id']+"_"+mergeOrderItems[i]['m_no']+"_s.jpg";
		imgStr = "<img width='60' height='60' style='object-fit: cover' src='"+imgSrc+"'";
		mergeOrderItems[i]['subtotal'] = parseInt(mergeOrderItems[i]['count']) * parseFloat(mergeOrderItems[i]['price']);
		rows.push({
			idx_image: imgStr,
			idx_code: mergeOrderItems[i]['i_code'],
			idx_count: mergeOrderItems[i]['count'],
			idx_price: mergeOrderItems[i]['price']
		});
		mItemsCount += parseInt(mergeOrderItems[i]['count']);
		mItemsValue += mergeOrderItems[i]['subtotal'];
	}
	$tableMerge.bootstrapTable('removeAll');
	$tableMerge.bootstrapTable('append', rows);
	
	document.getElementById("mSumCount").innerText = mItemsCount;
	document.getElementById("mSumValue").innerText = mItemsValue.toFixed(2);

	$modalMerge.modal();
}

function mCancel() {
	$modalMerge.modal("toggle");
}

function mMerge() {
	if (!confirm(myRes['msgMergeConfirm']))
		return;
	
	mergeDb();
}

function mergeDb() {
	var link = "postOrderFromMerge.php";
	var form = new FormData(); 
	form.append('order', JSON.stringify(mergeOrder));
	form.append('orderitems', JSON.stringify(mergeOrderItems));
	form.append('ordervariants', JSON.stringify(mergeOrderVariants));
	form.append('oldorders', JSON.stringify(oldOrders));
	postRequest(link, form, mergeDbYes, mergeDbNo);
}

function mergeDbYes(result) {
	alert(myRes['msgMergeOK']);
	$modalMerge.modal("toggle");
	var url = "order_mgt.php";
	window.location.assign(url);
}

function mergeDbNo(result) {
	alert(myRes['msgMergeError']);
	$modalMerge.modal("toggle");
}
</script>

</html>
