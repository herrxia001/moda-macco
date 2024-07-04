<?php
/************************************************************************************
	File:		a_refmgt.php
	Purpose:	Refund list
	
	2021-07-22: created
	2021-09-04: added new refund
************************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

// Include files
if ($_SESSION['uLanguage'] == "cn")
	include_once 'resource_cn.php';
else
	include_once 'resource_en.php';
include_once 'db_functions.php';

$myCompany = dbQueryCompany();

// Init variables
$thisResource = new myResource();

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>REFUND LIST</title>
</head>
<body>
	<?php include 'include/a_nav.php' ?>
	<?php include "include/modalSelTime.php" ?>
	<?php include "include/modalCust.php" ?>
	<?php include "include/modalCustSearch.php" ?>
	
	<div class="container">	
<!-- buttons -->
		<div class="row">
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-2">
				<button type="button" class="btn btn-outline-secondary" id="selTime" onclick="selectTime()" style="width:200px">
					<?php echo $thisResource->mdstRdToday ?></button>				
			</div>
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-6" align="right">
				<button type="button" class="btn btn-outline-secondary" id="btnSelCust" style="width:200px" onclick="selCust()"></button>
				<button type="button" class="ml-1 btn btn-secondary" id="btnAllCust" onclick="allCust()"><span class='fa fa-users'></span></button>			
			</div>	
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4" align="right">	
				<input type="text" class="form-control" name="refund_no" id="refund_no">
				<button type="button" class="ml-1 btn btn-secondary" id="btnSrchNo" onclick="searchRefund()"><span class='fa fa-search'></button>
				<button type="button" class="ml-3 btn btn-secondary" id="btnOptions" onclick="showOptions()"><span class='fa fa-bars'></button>
				<button type="button" class="ml-1 btn btn-secondary" id="btnExport" onclick="exportFile()"><span class='fa fa-floppy-o'></button>
				<button type="button" class="ml-1 btn btn-secondary" id="btnPrint" onclick="printFile()"><span class='fa fa-print'></button>
				<button type="button" class="ml-1 btn btn-primary" id="btnNew" onclick="newRefund()"><span class="fa fa-plus"></span></button>
			</div>
		</div>	
<!-- Search result table -->
		<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
		<table id="table" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true" data-height="480">
			<thead class="thead-light">
				<tr>
				<th class="p-1" data-field="id" data-visible="false"></th>
				<th class="p-1" data-field="idx_refundno" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comRefundNo ?></th>
				<th class="p-1" data-field="idx_invoiceno" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comInvoiceNo ?></th>	
				<th class="p-1" data-field="idx_date" data-width="20" data-width-unit="%" data-align="center" data-sortable="true"><?php echo $thisResource->comRefundTime ?></th>
				<th class="p-1" data-field="idx_cust" data-width="25" data-width-unit="%" data-sortable="true" ><?php echo $thisResource->comCustomer ?></th>	
				<th class="p-1" data-field="idx_count" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comQuantity ?></th>
				<th class="p-1" data-field="idx_total" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comTotalGross ?></th>
				<th class="p-1" data-field="idx_tax" data-width="5" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true">MwSt</th>
				<th class="p-1" data-field="idx_net" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comTotalNet ?></th>
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
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12" align="right">
				<a><?php echo $thisResource->comTotalRecord ?>&nbsp;&nbsp;</a><a style="color:blue" id="itemCount"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalQuantity ?>&nbsp;&nbsp;</a><a style="color:blue" id="sumCount"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalGross ?>&nbsp;&nbsp;</a><a style="color:blue" id="sumPrice"></a>
				<a>&nbsp;&nbsp;MwSt&nbsp;&nbsp;</a><a style="color:blue" id="sumTax"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalNet ?>&nbsp;&nbsp;</a><a style="color:blue" id="sumNet"></a>
			</div>
		</div>
		
<!-- Modal: Options -->
<div class="modal fade" id="modalOptions" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="mdopTitle"><?php echo $thisResource->comOptions ?></h5>
		</div>
		<div class="modal-body">
			<div class="input-group p-1">
				<a><?php echo $thisResource->comFileExport ?></a>
			</div>
			<div class="input-group p-1">
				<label id="rd1"><input type="radio" class="mx-1" id="radio1" name="exportOp" value="exportOp1" checked><?php echo $thisResource->opDecimalNormal ?></label>
				<label id="rd2" class="ml-5"><input type="radio" class="mx-1" id="radio2" name="exportOp" value="exportOp2"><?php echo $thisResource->opDecimalComma ?></label>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class='fa fa-times'></button>
			<button type="button" class="btn btn-primary" id="mdopBtnOk" onclick="doneOptions()"><span class='fa fa-check'></button>
		</div>
		</div>
	</div>
</div> <!-- End of Options -->

	</div> <!-- End of container -->

</body>

<script src="js/sysfunc.js?v1"></script>
<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?01201037"></script>
<script src="js/modalSelTime.js?202106211441"></script>
<script src="js/modalCustSearch.js?202109090946"></script>
<script src="js/modalCust.js?202107042339"></script>

<script>
var company = <?php echo json_encode($myCompany) ?>;
var myRes = <?php echo json_encode($thisResource) ?>;
var orders = new Array(), orderCount = 0;
var $table = $("#table");
var sortCol = "date", sortOp = 1;
var countTotal = 0, priceTotal = 0, taxTotal = 0, netTotal = 0;
var customers, myCustomer = null;

// Load options
function loadOptions() {
	var timeChecked = localStorage.getItem("a_refmgt_timecheck");
	if (timeChecked == null)
		mdstSetChecked("timeToday");
	else
		mdstSetChecked(timeChecked);
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	
	myCustomer = JSON.parse(localStorage.getItem("a_refmgt_customer"));
	if (myCustomer == null)
		document.getElementById("btnSelCust").innerText = myRes['comCustomerAll'];
	else
		document.getElementById("btnSelCust").innerText = myCustomer['k_name'];
		
	sortCol = localStorage.getItem("a_refmgt_sortcol"); 
	sortOp = localStorage.getItem("a_refmgt_sortop");
	if (sortCol == null)
		sortCol = "date";
	if (sortOp == null)
		sortOp = 1;
}
// Init screen
$(document).ready(function(){
	document.getElementById("myTitle").innerText = myRes['comListRefund'];
	loadOptions();
	searchOrders();
 });
// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});
// Init table
$table.bootstrapTable({   
	formatNoMatches: function () {
         return myRes['sysMsgNoRecord'];
    }
});
// Search refunds
function searchOrders(){
	countTotal = 0;
	priceTotal = 0;
	taxTotal = 0;
	netTotal = 0;
	var timeResult = mdstGetValue();
	var link = "getRefunds.php?";
	link += timeResult;
	getRequest(link, afterSearch, displayNo);
}
function afterSearch(result){
	orders = result;
	orderCount = orders.length;
	loadTable();
}
function displayNo(result) {	
	orders = [];
	orderCount = 0;
	$table.bootstrapTable('removeAll');
	displaySum();
}
// Display summary
function displaySum(){
	document.getElementById("itemCount").innerText = orders.length;
	document.getElementById("sumCount").innerText = countTotal;
	document.getElementById("sumPrice").innerText = priceTotal.toFixed(2);
	document.getElementById("sumTax").innerText = taxTotal.toFixed(2);
	document.getElementById("sumNet").innerText = netTotal.toFixed(2);
}

function loadTable(){	
	if (orderCount <= 0) {
		displaySum();
		return;
	}
	$table.bootstrapTable('removeAll');
	var rows = [];
	for(var i=0; i<orderCount; i++){
		if (myCustomer != null &&  myCustomer['k_id'] != "" && orders[i]['k_id'] != myCustomer['k_id'])
			continue;
		var tax = parseFloat(orders[i]['total_sum'])*parseFloat(orders[i]['tax_rate'])/100;
		orders[i]['tax'] = tax.toFixed(2);
		rows.push({
			id: orders[i]['rf_id'],
			idx_refundno: orders[i]['refund_no'],
			idx_invoiceno: orders[i]['invoice_no'],
			idx_date: orders[i]['date'].substring(0,10),
			idx_cust: orders[i]['k_name'],
			idx_count: orders[i]['count_sum'],
			idx_total: orders[i]['total_sum'],
			idx_tax: orders[i]['tax'],
			idx_net: orders[i]['net']
		});
		countTotal += parseInt(orders[i]['count_sum']);
		priceTotal += parseFloat(orders[i]['total_sum']);
		taxTotal += tax;
		netTotal += parseFloat(orders[i]['net']);
	}
	$table.bootstrapTable('append', rows);	
	displaySum();
}   
/****************************************************************************************************
	VIEW
****************************************************************************************************/
$('#table').on('click-row.bs.table', function (e, row, $element) {
	var url = "a_refund.php?back=a_refmgt&rf_id="+row.id;
	window.location.assign(url);
});
/****************************************************************************************************
	New
****************************************************************************************************/
function newRefundYes(result) {
	var url = "a_refund.php?back=a_refmgt&rf_id="+result;
	window.location.assign(url);
}
function newRefundNo(result) {
	alert(myRes['msgErrDatabase']);
}
function newRefund() {
	getRequest("getRefundNew.php", newRefundYes, newRefundNo);
}
/****************************************************************************************************
	SORT
****************************************************************************************************/
$('#table').on('sort.bs.table', function (e, name, order) {
	switch(name) {
		case "id": sortCol = 'r_id';  break;
		case "idx_no": sortCol = 'invoice_no';  break;
		case "idx_cust": sortCol = 'k_name';  break;
		case "idx_count": sortCol = 'count_sum';  break;
		case "idx_total": sortCol = 'total_sum';  break;
		case "idx_tax": sortCol = 'tax';  break;
		case "idx_net": sortCol = 'net';  break;
		default: sortCol = "date"; 
	}
	if (order == "asc")
		sortOp = 0;
	else
		sortOp = 1;
	localStorage.setItem("a_refmgt_sortcol", sortCol);
	localStorage.setItem("a_refmgt_sortop", sortOp); 
});
/****************************************************************************************************
	TIME
****************************************************************************************************/
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
	localStorage.setItem("a_refmgt_timecheck", timeChecked);
	
	searchOrders();
}
/****************************************************************************************************
	CUSTOMER
****************************************************************************************************/
// Show Customer
function selCust() {
	mksInit(2);
	$modalCustSearch.modal();	
}
// modalCustSearch
function mksDoneNext(customer) {
	myCustomer = customer;
	document.getElementById("btnSelCust").innerText = myCustomer['k_name'];	
	localStorage.setItem("a_refmgt_customer", JSON.stringify(myCustomer));	
	loadTable();
}
// All customers
function allCust() {
	myCustomer = null;
	document.getElementById("btnSelCust").innerText = myRes['comCustomerAll'];
	localStorage.setItem("a_refmgt_customer", null);
	searchOrders();
}
/****************************************************************************************************
	Search Refund
****************************************************************************************************/
function searchRefund() {
	var refundNo = document.getElementById("refund_no").value;
	if (refundNo == "")
		return;
	getRequest("getRefundByNo.php?refund_no="+refundNo, searchRefundYes, searchRefundNo);
}
function searchRefundYes(result) {
	var url = "a_refund.php?back=a_refmgt&rf_id="+result['rf_id'];
	window.location.assign(url);
}
function searchRefundNo(result) {
	alert(myRes['sysMsgNoRecord']);
	document.getElementById("rf_id").focus();
}
/****************************************************************************************************
	Options
****************************************************************************************************/
var $modalOptions = $("#modalOptions");
var opExport = 0;
function showOptions() {
	$modalOptions.modal();	
}
function doneOptions() {
	var radios = document.getElementsByName('exportOp');
	if (radios[0].checked)
		opExport = 0;
	if (radios[1].checked)
		opExport = 1;
	$modalOptions.modal("toggle");
}
/****************************************************************************************************
	Export
****************************************************************************************************/
function convertNumber(number) {
	var newshu = number.replace(".",";");
	return newshu;
}
function exportFile() {
	var output = "Gutschrift Nr.,Datum,Steuergrundlage,MwSt,Gesamtbetrag,Firma\n";
	for (var i=0; i<orderCount; i++) {
		var tax = parseFloat(orders[i]['total_sum'])*parseFloat(orders[i]['tax_rate'])/100;
		output += '"'+orders[i]['rf_id']+'",';
		output += '"'+convertDate(orders[i]['date'].substring(0,10))+'",';
		if (opExport == 1) {
			output += '"'+convertNumber(orders[i]['total_sum'])+'",';
			output += '"'+convertNumber(tax.toFixed(2))+'",';
			output += '"'+convertNumber(orders[i]['net'])+'",';
		} else {
			output += '"'+orders[i]['total_sum']+'",';
			output += '"'+tax.toFixed(2)+'",';
			output += '"'+orders[i]['net']+'",';
		}		
		output += '"'+orders[i]['k_name']+'"\n';
	}
	
	var a = document.createElement("a");
	var file = new Blob([output], {type: 'text/plain'});
	a.href = URL.createObjectURL(file);
	a.download = "Rechnung-Kunden-"+currentDate(1)+".csv";
	document.body.appendChild(a);
    a.click();window.URL.revokeObjectURL(file);
    a.remove();
}
/****************************************************************************************************
	PRINT
****************************************************************************************************/
function printFile() { 	
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
	output += '<a style="font-size:12px">Vom&nbsp;'+convertDate(timeRange['timefrom'])+'&nbsp;bis&nbsp;'+convertDate(timeRange['timeto'])+'&nbsp;Rechnungsliste (Kunden)</a><br>';
	output += '</td>';
	output += '</tr></table>';
	// Articles
	output += '<table width="100%" cellpadding="2" cellspacing="0" style="border:1px solid;"><thead>';
	output += '<tr style="font-size:12px;">';
	output += '<th align="center" style="border-left:1px solid;">Rechnung Nr.</th>';
	output += '<th align="center" style="border-left:1px solid;">Datum<br>Rechnung</th>';
	output += '<th align="left" style="border-left:1px solid;">Steuergrundlage</th>';
	output += '<th align="left" style="border-left:1px solid;">MwSt</th>';
	output += '<th align="left" style="border-left:1px solid;">Gesamtbetrag</th>';
	output += '<th align="left" style="border-left:1px solid;">Firma</th>';
	output += '</tr></thead><tbody>';
	for (var i=0; i<orderCount; i++) {
		var tax = parseFloat(orders[i]['total_sum'])*parseFloat(orders[i]['tax_rate'])/100;
		output += '<tr style="font-size:12px;">';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+orders[i]['rf_id']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+convertDate(orders[i]['date'].substring(0,10))+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+orders[i]['total_sum']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+tax.toFixed(2)+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+orders[i]['net']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+orders[i]['k_name']+'</td>';
		output += '</tr>';
	}
	output += '<tr style="font-size:12px;">';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" colspan="2">Gesamtsumme&nbsp;</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+priceTotal.toFixed(2)+'</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+taxTotal.toFixed(2)+'</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+netTotal.toFixed(2)+'</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;"></td>';

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
