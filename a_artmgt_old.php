<?php
/************************************************************************************
	File:		a_artmgt.php
	Purpose:	INVOICE ARTICLE MANAGEMENT
	
	2021-01-05: add article stats on $timefrom
	2021-02-19: add unit support
************************************************************************************/
// Start session; If session expired, load the login page.
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

// Include files
include_once 'resource.php';
include_once 'db_functions.php';

$myCompany= dbQueryCompany();

// Init variables
$thisResource = new myResource($_SESSION['uLanguage']);

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUIMS - ARTICLES</title>
</head>

<body>
	<?php include 'include/a_nav.php' ?>
	<?php include "include/modalSelTime.php" ?>
	
	<div class="container">	
<!-- options -->
	<div class="row">
		<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-6">
			<button type="button" class="p-1 btn btn-outline-secondary" id="selTime" onclick="selectTime()"  style="width:220px">
				<?php echo $thisResource->mdstRdThisMonth ?></button>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6" align="right">			
			<button type="button" class="btn btn-secondary" id="btnExport" onclick="exportFile()"><span class='fa fa-floppy-o'></button>
			<button type="button" class="btn btn-secondary" id="btnPrint" onclick="printFile()"><span class='fa fa-print'></button>
		</div>
	</div>
<!-- Article table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
			<table id="table" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true" data-unique-id="id" data-height="480">
				<thead class="thead-light">
					<tr>
					<th class="p-1" data-field="id" data-width-unit="%" data-visible="false"></th>			
					<th class="p-1" data-field="idx_data" data-halign="center" >商品</th>
					<th class="p-1" data-field="idx_lastcount" data-halign="center" data-align="right">初始库存</th>
					<th class="p-1" data-field="idx_count" data-halign="center" data-align="right">截止库存</th>
					<th class="p-1" data-field="idx_cost" data-halign="center" data-align="right">单位成本</th>
					<th class="p-1" data-field="idx_total" data-halign="center" data-align="right">库存金额</th>
					<th class="p-1" data-field="idx_in" data-halign="center" data-align="right">进货</th>
					<th class="p-1" data-field="idx_invalue" data-halign="center" data-align="right">进货金额</th>
					<th class="p-1" data-field="idx_out" data-halign="center" data-align="right">销售</th>
					<th class="p-1" data-field="idx_outvalue" data-halign="center" data-align="right">销售金额</th>
					<th class="p-1" data-field="idx_rf" data-halign="center" data-align="right">退货</th>
					<th class="p-1" data-field="idx_rfvalue" data-halign="center" data-align="right">退货金额</th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>
	</div>
<!-- summary -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-3" align="left">
			<a>进货总件数:&nbsp;&nbsp;</a><a style="color:blue" id="sumInCount"></a>
			<a>&nbsp;&nbsp;总金额:&nbsp;&nbsp;</a><a style="color:blue" id="sumInTotal"></a>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-3" align="center">
			<a>销售总件数:&nbsp;&nbsp;</a><a style="color:blue" id="sumOutCount"></a>
			<a>&nbsp;&nbsp;总金额:&nbsp;&nbsp;</a><a style="color:blue" id="sumOutTotal"></a>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6" align="right">
			<a>初始总库存:&nbsp;&nbsp;</a><a style="color:blue" id="sumLastCount"></a>
			<a>&nbsp;&nbsp;截止总库存:&nbsp;&nbsp;</a><a style="color:blue" id="sumCount"></a>
			<a>&nbsp;&nbsp;库存总金额:&nbsp;&nbsp;</a><a style="color:blue" id="sumCost"></a>
		</div>
	</div>
	</div> <!-- End of container -->

<!-- Modal: modalArt -->
<div class="modal fade" id="modalArt" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="mdaTitle">商品库存</h5>
		</div>
		<div class="modal-body">
			<input type="text" class="form-control" name="mda_id" id="mda_id" hidden>
			<input type="text" class="form-control" name="mda_t_id" id="mda_t_id" hidden>
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<div class="input-group p-1">
						<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">货号</span></div>
						<input type="text" class="form-control" name="mda_code" id="mda_code" readonly>
					</div>
					<div class="input-group p-1">
						<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">名称</span></div>
						<input type="text" class="form-control" name="mda_name" id="mda_name" readonly>
					</div>
					<div class="input-group p-1">
						<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">库存</span></div>
						<input type="number" min="0" step="0.01" class="form-control" name="mda_count" id="mda_count">		
					</div>
					<div class="input-group p-1">
						<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">单位成本</span></div>
						<input type="number" min="0" step="0.01" class="form-control" name="mda_cost" id="mda_cost">		
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" id="mdaBtnClose" data-dismiss="modal"><span class='fa fa-times'></button>
			<button type="button" class="btn btn-primary" id="mdaBtnDone" onclick="mdaDone()"><span class='fa fa-check'></button>
		</div>
		</div>
	</div>
</div> <!-- end of modalArt -->

</body>

<script src="js/sysfunc.js?v2"></script>
<script src="js/ajax.js"></script>
<script src="js/autocomplete.js"></script>
<script src="js/modalSelTime.js?v1"></script>

<script>

var company = <?php echo json_encode($myCompany) ?>;
var $table = $("#table");
var fSup = "";
// Modal
var $modalArt = $("#modalArt");
// Load data
var invs, arts, sales, sales1, sales2, purs, purs1, purs2, refunds, rf1, rf2;
var countTotal = 0, costTotal = 0;
var sumOutCount = 0, sumOutTotal = 0, sumInCount = 0, sumInTotal = 0;
var sumRfCount = 0, sumRfTotal = 0;
var lastCountTotal = 0;
var fTime, timeNow = currentDate(2);

$(document).ready(function(){
	document.getElementById("myTitle").innerText = "库存列表";
	// Load table
	mdstSetChecked("timeThisMonth");
	fTime = mdstGetValue(1);
	searchArts();	
});

$table.bootstrapTable({   
	formatNoMatches: function () {
         return "没有找到符合条件的数据";
    }
});

function searchArtsYes(result) {
	arts = result;
	invs = new Array();
	for (var i=0; i<arts.length; i++) {
		var inv = new Object();
		inv['a_id'] = arts[i]['a_id'];
		inv['a_code'] = arts[i]['a_code'];
		inv['a_name'] = arts[i]['a_name'];
		inv['count'] = arts[i]['count'];
		inv['cost'] = arts[i]['cost'];
		invs[i] = inv;
	}
	loadPurs1();
}
function searchArtsNo(result) {
	arts = null;
	invs = null;
	displaySum();
	alert("系统连接出现问题, 请稍后再试");
}

function searchArts() {
	getRequest("getArts.php", searchArtsYes, searchArtsNo);
}

function displaySum(){
	document.getElementById("sumLastCount").innerText = lastCountTotal;
	document.getElementById("sumCount").innerText = countTotal;
	document.getElementById("sumCost").innerText = costTotal.toFixed(2);
	
	document.getElementById("sumOutCount").innerText = sumOutCount;	
	document.getElementById("sumOutTotal").innerText = sumOutTotal.toFixed(2);	
	
	document.getElementById("sumInCount").innerText = sumInCount;	
	document.getElementById("sumInTotal").innerText = sumInTotal.toFixed(2);
}

var loadRefundBack = 0;
function loadTable() {
	loadRefundBack = 0;
	
	var timestr = "timefrom="+fTime['timefrom']+"&timeto="+timeNow+"&option=0";
	var link = "getArtRefund.php?"+timestr;
	getRequest(link, loadRfYes1, loadRfNo1);
	
	var timestr = "timefrom="+fTime['timeto']+"&timeto="+timeNow+"&option=1";
	var link = "getArtRefund.php?"+timestr;
	getRequest(link, loadRfYes2, loadRfNo2);
}

function loadRfYes1(result) {
	rf1 = result;
	loadRefundBack++;
	if (loadRefundBack == 2)
		loadRefunds();
}

function loadRfNo1(result) {
	rf1 = 0;
	loadRefundBack++;
	if (loadRefundBack == 2)
		loadRefunds();
}

function loadRfYes2(result) {
	rf2 = result;
	loadRefundBack++;
	if (loadRefundBack == 2)
		loadRefunds();
}

function loadRfNo2(result) {
	rf2 = 0;
	loadRefundBack++;
	if (loadRefundBack == 2)
		loadRefunds();
}

function loadRefunds() { 
	refunds = new Array();
	sumRfCount = 0;
	sumRfTotal = 0.00;
	
	for (var i=0; i<rf1.length; i++) {
		var rf = new Object();
		rf['a_id'] = rf1[i]['a_id'];
		rf['count'] = rf1[i]['count'];
		rf['total'] = rf1[i]['total'];
		refunds[i] = rf;
		sumRfCount += parseInt(refunds[i]['count']);
		sumRfTotal += parseFloat(refunds[i]['total']);
	}
	
	for (var i=0; i<rf1.length; i++) {
		for (var j=0; j<rf2.length; j++) {
			if (rf1[i]['a_id'] == rf2[j]['a_id']) {								
				var count = parseInt(rf1[i]['count']) - parseInt(rf2[j]['count']);
				refunds[i]['count'] = count.toString();
				var total = parseFloat(rf1[i]['total']) - parseFloat(rf2[j]['total']);
				refunds[i]['total'] = total.toFixed(2);				
				sumRfCount = sumOutCount - parseInt(rf2[j]['count']);
				sumRfTotal = sumOutTotal - parseFloat(rf2[j]['total']);
			}
		}
	}

	loadTableFinal();	
}

function loadTableFinal(){
	$table.bootstrapTable('removeAll');
	lastCountTotal = 0;
	countTotal = 0;
	costTotal = 0;

	var count = 0, last_count = 0;
	var rows = [];
	for(var i=0; i<invs.length; i++){
		// Last Count
		invs[i]['last_count'] = invs[i]['count'];
		if (purs1 != null && purs1.length > 0) {
			for (var j=0; j<purs1.length; j++) {
				if (invs[i]['a_id'] == purs1[j]['a_id']) {
					last_count = parseInt(invs[i]['count']) - parseInt(purs1[j]['count']);		
					invs[i]['last_count'] = last_count.toString();					
				}
			}
		}
		if (sales1 != null && sales1.length > 0) {
			for (var j=0; j<sales1.length; j++) {
				if (invs[i]['a_id'] == sales1[j]['a_id']) {
					last_count = parseInt(invs[i]['last_count']) + parseInt(sales1[j]['count']);		
					invs[i]['last_count'] = last_count.toString();					
				}
			}
		}
		if (rf1 != null && rf1.length > 0) {
			for (var j=0; j<rf1.length; j++) {
				if (invs[i]['a_id'] == rf1[j]['a_id']) {
					last_count = parseInt(invs[i]['last_count']) - parseInt(rf1[j]['count']);		
					invs[i]['last_count'] = last_count.toString();					
				}
			}
		}
		// Count
		if (purs2 != null && purs2.length > 0) {
			for (var j=0; j<purs2.length; j++) {
				if (invs[i]['a_id'] == purs2[j]['a_id']) {
					count = parseInt(invs[i]['count']) - parseInt(purs2[j]['count']);		
					invs[i]['count'] = count.toString();
				}
			}
		}
		if (sales2 != null && sales2.length > 0) {
			for (var j=0; j<sales2.length; j++) {
				if (invs[i]['a_id'] == sales2[j]['a_id']) {
					count = parseInt(invs[i]['count']) + parseInt(sales2[j]['count']);		
					invs[i]['count'] = count.toString();
				}
			}
		}
		if (rf2 != null && rf2.length > 0) {
			for (var j=0; j<rf2.length; j++) {
				if (invs[i]['a_id'] == rf2[j]['a_id']) {
					count = parseInt(invs[i]['count']) - parseInt(rf2[j]['count']);		
					invs[i]['count'] = count.toString();
				}
			}
		}
		// Purs
		invs[i]['in'] = "0";
		invs[i]['invalue'] = "0.00";
		if (purs != null && purs.length > 0) {
			for (var j=0; j<purs.length; j++) {
				if (invs[i]['a_id'] == purs[j]['a_id']) {		
					invs[i]['in'] = purs[j]['count'];
					invs[i]['invalue'] = purs[j]['total'];
				}
			}
		}
		// Sales
		invs[i]['out'] = "0";
		invs[i]['outvalue'] = "0.00";
		if (sales != null && sales.length > 0) {
			for (var j=0; j<sales.length; j++) {
				if (invs[i]['a_id'] == sales[j]['a_id']) {		
					invs[i]['out'] = sales[j]['count'];
					invs[i]['outvalue'] = sales[j]['total'];
				}
			}
		}
		// Refunds
		invs[i]['rf'] = "0";
		invs[i]['rfvalue'] = "0.00";
		if (refunds != null && refunds.length > 0) {
			for (var j=0; j<refunds.length; j++) {
				if (invs[i]['a_id'] == refunds[j]['a_id']) {		
					invs[i]['rf'] = refunds[j]['count'];
					invs[i]['rfvalue'] = refunds[j]['total'];
				}
			}
		}
		
		var subTotal = parseFloat(invs[i]['cost'])*parseInt(invs[i]['count']);
		rows.push({
			id: 			invs[i]['a_id'],
			idx_data: 		invs[i]['a_name'],
			idx_lastcount: 	invs[i]['last_count'],
			idx_count: 		invs[i]['count'],
			idx_cost: 		invs[i]['cost'],
			idx_total: 		subTotal.toFixed(2),
			idx_in:			invs[i]['in'],
			idx_invalue:	invs[i]['invalue'],
			idx_out:		invs[i]['out'],
			idx_outvalue:	parseFloat(invs[i]['outvalue']).toFixed(2),
			idx_rf:			invs[i]['rf'],
			idx_rfvalue:	parseFloat(invs[i]['rfvalue']).toFixed(2)
		});
		lastCountTotal += parseInt(invs[i]['last_count']);
		countTotal += parseInt(invs[i]['count']);
		costTotal += parseFloat(subTotal);
	}
	$table.bootstrapTable('append', rows);	
	displaySum();	
}

// Query purs (>=timefrom AND <= timeto)
function loadPursYes1(result) {
	purs1 = result;
	purs = new Array();
	for (var i=0; i<purs1.length; i++) {
		var pur = new Object();
		pur['a_id'] = purs1[i]['a_id'];
		pur['count'] = purs1[i]['count'];
		pur['total'] = purs1[i]['total'];
		purs[i] = pur;
		sumInCount += parseInt(purs[i]['count']);
		sumInTotal += parseFloat(purs[i]['total']);
	}
	loadPurs2();
}
function loadPursNo1(result) {
	purs = null, purs1 = null, purs2 = null;
	sumInCount = 0;
	sumInTotal = 0;
	loadSales1();
}
function loadPurs1() {
	sumInCount = 0;
	sumInTotal = 0;
	var timestr = "timefrom="+fTime['timefrom']+"&timeto="+timeNow+"&option=0";
	var link = "getArtPurs.php?"+timestr;
	getRequest(link, loadPursYes1, loadPursNo1);
}
// Query purs (>timeto AND <= timeNow)
function loadPursYes2(result) { 
	purs2 = result;
	for (var i=0; i<purs1.length; i++) {
		for (var j=0; j<purs2.length; j++) {
			if (purs1[i]['a_id'] == purs2[j]['a_id']) {								
				var count = parseInt(purs1[i]['count']) - parseInt(purs2[j]['count']);
				purs[i]['count'] = count.toString();
				var total = parseFloat(purs1[i]['total']) - parseFloat(purs2[j]['total']);
				purs[i]['total'] = total.toFixed(2);				
				sumInCount = sumInCount - parseInt(purs2[j]['count']);
				sumInTotal = sumInTotal - parseFloat(purs2[j]['total']);
			}
		}
	}
	loadSales1();	
}
function loadPursNo2(result) {
	purs2 = null;
	loadSales1();
}
function loadPurs2() {
	if (fTime['timeto'] == timeNow) {
		loadPursNo2();
	} else {
		var timestr = "timefrom="+fTime['timeto']+"&timeto="+timeNow+"&option=1";
		var link = "getArtPurs.php?"+timestr;
		getRequest(link, loadPursYes2, loadPursNo2);
	}
}

// Query sales (>=timefrom AND <= timeto)
function loadSalesYes1(result) {
	sales1 = result;
	sales = new Array();
	for (var i=0; i<sales1.length; i++) {
		var sale = new Object();
		sale['a_id'] = sales1[i]['a_id'];
		sale['count'] = sales1[i]['count'];
		sale['total'] = sales1[i]['total'];
		sales[i] = sale;
		sumOutCount += parseInt(sales[i]['count']);
		sumOutTotal += parseFloat(sales[i]['total']);
	}
	loadSales2();
}
function loadSalesNo1(result) {
	sales = null, sales1 = null, sales2 = null;
	sumOutCount = 0;
	sumOutTotal = 0;
	loadTable();
}
function loadSales1() {
	sumOutCount = 0;
	sumOutTotal = 0;
	var timestr = "timefrom="+fTime['timefrom']+"&timeto="+timeNow+"&option=0";
	var link = "getArtSales.php?"+timestr;
	getRequest(link, loadSalesYes1, loadSalesNo1);
}
// Query sales (>timeto AND <= timeNow)
function loadSalesYes2(result) { 
	sales2 = result;
	for (var i=0; i<sales1.length; i++) {
		for (var j=0; j<sales2.length; j++) {
			if (sales1[i]['a_id'] == sales2[j]['a_id']) {								
				var count = parseInt(sales1[i]['count']) - parseInt(sales2[j]['count']);
				sales[i]['count'] = count.toString();
				var total = parseFloat(sales1[i]['total']) - parseFloat(sales2[j]['total']);
				sales[i]['total'] = total.toFixed(2);				
				sumOutCount = sumOutCount - parseInt(sales2[j]['count']);
				sumOutTotal = sumOutTotal - parseFloat(sales2[j]['total']);
			}
		}
	}
	loadTable();	
}
function loadSalesNo2(result) {
	sales2 = null;
	loadTable();
}
function loadSales2() {
	if (fTime['timeto'] == timeNow) {
		loadSalesNo2();
	} else {
		var timestr = "timefrom="+fTime['timeto']+"&timeto="+timeNow+"&option=1";
		var link = "getArtSales.php?"+timestr;
		getRequest(link, loadSalesYes2, loadSalesNo2);
	}
}

// Click a row to view product
$('#table').on('click-row.bs.table', function (e, row, $element) {
	showArt(row.id);
})

// Show/edit article
$modalArt.on('shown.bs.modal', function () {
	  $('#mda_count').trigger('focus');
})
function showArt(id) {
	getRequest("getArtById.php?id="+id, searchArtYes, null);
}
function searchArtYes(result) {
	var art = result[0];

	//Set values
	document.getElementById("mda_id").value = art['a_id'];
	document.getElementById("mda_t_id").value = art['t_id'];
	document.getElementById("mda_code").value = art['a_code'];
	document.getElementById("mda_name").value = art['a_name'];
	document.getElementById("mda_count").value = art['count'];
	document.getElementById("mda_cost").value = art['cost'];
	
	$modalArt.modal();
}

// Done modalArt
function postArtYes(result) {
	mdstSetChecked("timeThisMonth");
	
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	
	fTime = mdstGetValue(1);	
	searchArts();
}
function mdaDone() {
	var id = document.getElementById("mda_id").value;
	var code = document.getElementById("mda_code").value; 
	if (name == "") {
		$('#mda_code').trigger('focus');
		return;
	}
	var name = document.getElementById("mda_name").value; 
	if (name == "") {
		$('#mda_name').trigger('focus');
		return;
	}
	var count = document.getElementById("mda_count").value;
	if (!onlyDigits(count)) {
		$('#mda_count').trigger('focus');
		return;
	}
	var cost = document.getElementById("mda_cost").value;
	if (!onlyNumber(cost)) {
		$('#mda_cost').trigger('focus');
		return;
	}
	$modalArt.modal("toggle");
	
	var art = {};
	art['a_id'] = id;
	art['a_code'] = code;
	art['a_name'] = name;
	art['count'] = count;
	art['cost'] = cost;
	var form = new FormData();
	form.append('art', JSON.stringify(art));
	postRequest("postArtUpdate.php", form, postArtYes, null);	
}

// Show time selection (modalTime)
function selectTime(){
	$modalSelTime.modal();	
}

// Finish time selection (modalTime)
function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
	 
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	
	fTime = mdstGetValue(1);
	searchArts();
}

// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

// System
function onlyDigits(s) {
	if (s == "")
		return false;
	if (parseInt(s) < 0)
		return false;
	var d;
	for (var i=0; i<s.length; i++) {
		d = s[i];
		if (d < "0" || d > "9")
			return false;
	}

	return true;
}

function onlyNumber(s) {
	if (s == "")
		return false;
	if (parseFloat(s) < 0)
		return false;
	var d;
	for (var i=0; i<s.length; i++) {
		d = s[i];
		if ((d < "0" || d > "9") && d != "," && d != ".")
			return false;
	}
	
	return true;
}

/* EXPORT */
function exportFile() {
	var output = "Artikel Nr.,Beschreibung,Durchschnittskosten,Menge Anfanglichen,Menge Einahmen,Menge Ausgaben,Menge Bestand,Wer Bestand\n";
	for (var i=0; i<invs.length; i++) {
		var subTotal = parseFloat(invs[i]['cost'])*parseInt(invs[i]['count']);
		output += invs[i]['a_code']+',';
		output += invs[i]['a_name']+',';
		output += invs[i]['cost']+',';
		output += invs[i]['last_count']+',';
		output += invs[i]['in']+',';
		output += invs[i]['out']+',';
		output += invs[i]['count']+',';
		output += subTotal.toFixed(2)+'\n';
	}
	
	var a = document.createElement("a");
	var file = new Blob([output], {type: 'text/plain'});
	a.href = URL.createObjectURL(file);
	a.download = "bestand"+currentDate(1)+".csv";
	document.body.appendChild(a);
    a.click();window.URL.revokeObjectURL(url);
    a.remove();
}

/* PRINT */
function printFile() { 
	var i = 0;	
	var dt = currentDate();	
	var timeRange = mdstGetValue(1);
	
	var src = "files/"+"<?php echo $_SESSION['uDb']; ?>"+"/logo.png";
	var output = '<html><head><style type="text/css" media="print">@page { size:auto; margin:0.8cm 0.8cm 0.8cm 1.5cm; }\</style></head><body>';	
	// Title
	output += '<table width="100%" cellpadding="5" cellspacing="0"><tr>';
	output += '<td align="center">';
	output += '<img height="100" style="object-fit: cover" src="'+src+'"></img>';
	output += '</td>';
	output += '<td align="left" style="border-left:1px solid; border-top:1px solid; border-right:1px solid">';
	output += '<a style="font-size:12px">Vom&nbsp;'+convertDate(timeRange['timefrom'])+'&nbsp;bis&nbsp;'+convertDate(timeRange['timeto'])+'&nbsp;Bestandssituation</a><br>';
	output += '<a style="font-size:12px">Alle Artikel</a><br>';
	output += '<a style="font-size:12px">Wert bei der Durchschnittskosten</a><br>';
	output += '</td>';
	output += '</tr></table>';
	// Articles
	output += '<table width="100%" cellpadding="2" cellspacing="0" style="border:1px solid;"><thead>';
	output += '<tr style="font-size:12px;">';
	output += '<th align="center" style="border-left:1px solid;">Artikel Nr.</th>';
	output += '<th align="center" style="border-left:1px solid;">Beschreibung</th>';
	output += '<th align="left" style="border-left:1px solid;">Durchschnitts-<br>kosten</th>';
	output += '<th align="left" style="border-left:1px solid;">Menge<br>Anfanglichen</th>';
	output += '<th align="left" style="border-left:1px solid;">Menge<br>Einahmen</th>';
	output += '<th align="left" style="border-left:1px solid;">Menge<br>Ausgaben</th>';
	output += '<th align="left" style="border-left:1px solid;">Menge<br>Bestand</th>';
	output += '<th align="left" style="border-left:1px solid;">Wert<br>Bestand</th>';
	output += '</tr></thead><tbody>';
	for (i=0; i<invs.length; i++) {
		var subTotal = parseFloat(invs[i]['cost'])*parseInt(invs[i]['count']);
		output += '<tr style="font-size:12px;">';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+invs[i]['a_code']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+invs[i]['a_name']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+invs[i]['cost']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+invs[i]['last_count']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+invs[i]['in']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+invs[i]['out']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+invs[i]['count']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+subTotal.toFixed(2)+'</td>';
		output += '</tr>';
	}
	output += '<tr style="font-size:12px;">';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" colspan="3">Total&nbsp;</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;"></td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;"></td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;"></td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+countTotal+'</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+costTotal.toFixed(2)+'</td>';
	output += '</tr>';
	output += '</tbody></table>';
	// Footer
	output += '<a style="font-size:12px">Datum:&nbsp;'+dt+'&nbsp;&nbsp;Betreiber:&nbsp;'+company['c_name']+'</a>';
	// Print
	var mywindow = window.open();
    mywindow.document.write(output);
	mywindow.document.close();
	mywindow.focus();
	if (/Android|iPhone|iPad/i.test(navigator.userAgent)) {
		mywindow.print();
		mywindow.onafterprint = function () {
			mywindow.close();
		} 
	}else {
		mywindow.onload = function () {
			mywindow.print();
			mywindow.close();
		}
	}	
}

</script>

</html>
