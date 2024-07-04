<?php

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

// Include files
include 'resource.php';
include_once 'db_functions.php';

$myCompany= dbQueryCompany();

// Init variables
$thisResource = new myResource($_SESSION['uLanguage']);

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>INVOICE LIST</title>
</head>
<style>
body {
 padding-top: 0.5rem;
}
</style>
<body>
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
				<button type="button" class="ml-1 btn btn-secondary" id="btnAllCust" onclick="allCust()"><span class='fa fa-users'><span></button>
				<button type="button" class="ml-1 btn btn-primary" id="btnNewCust" onclick="newCust()"><span class='fa fa-user-plus'><span></button>				
			</div>	
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4" align="right">
				<button type="button" class="btn btn-outline-secondary dropdown-toggle"  id="btnInYear" data-toggle="dropdown">2022</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#" onclick="selInYear(this)">2022</a>
							<a class="dropdown-item" href="#" onclick="selInYear(this)">2021</a>
						</div>
				<input type="text" class="ml-1 form-control" name="invoice_no" id="invoice_no">
				<button type="button" class="ml-1 btn btn-secondary" id="btnSrchNo" onclick="searchInvoice()"><span class='fa fa-search'></span></button>
				<button type="button" class="ml-1 btn btn-secondary" id="btnExport" onclick="exportFile()"><span class='fa fa-floppy-o'></span></button>
				<button type="button" class="ml-1 btn btn-secondary" id="btnPrint" onclick="printFile()"><span class='fa fa-print'></span></button>
			</div>
		</div>	
<!-- Search result table -->
		<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
		<table id="table" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true" data-height="480">
			<thead class="thead-light">
				<tr>
				<th class="p-1" data-field="id" data-width="" data-width-unit="%" data-visible="false"></th>
				<th class="p-1" data-field="idx_no" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true">Invoice No.</th>	
				<th class="p-1" data-field="idx_date" data-width="20" data-width-unit="%" data-align="center" data-sortable="true">Invoice Date</th>
				<th class="p-1" data-field="idx_cust" data-width="30" data-width-unit="%" data-sortable="true" >Customer</th>	
				<th class="p-1" data-field="idx_count" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true">Quantity</th>
				<th class="p-1" data-field="idx_total" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true">Gross Total</th>
				<th class="p-1" data-field="idx_tax" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true">MwSt.</th>
				<th class="p-1" data-field="idx_net" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true">Net Total</th>
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
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-4" align="left">
				<div class="dropdown">
					<button type="button" id="btnPay" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Payment Methods</button>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#" onclick="selPay(this)">All</a>
						<a class="dropdown-item" href="#" onclick="selPay(this)">Bar</a>
						<a class="dropdown-item" href="#" onclick="selPay(this)">Karte</a>
						<a class="dropdown-item" href="#" onclick="selPay(this)">Überweisung</a>
						<a class="dropdown-item" href="#" onclick="selPay(this)">Scheck</a>
						<a class="dropdown-item" href="#" onclick="selPay(this)">Nachnahme</a>
						<a class="dropdown-item" href="#" onclick="selPay(this)">PayPal</a>
						<a class="dropdown-item" href="#" onclick="selPay(this)">Vorkasse</a>
					</div>
				</div>
			</div>
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8" align="right">
				<a>Invoice:&nbsp;&nbsp;</a><a style="color:blue" id="itemCount"></a>
				<a>&nbsp;&nbsp;Quantity:&nbsp;&nbsp;</a><a style="color:blue" id="sumCount"></a>
				<a>&nbsp;&nbsp;Gross Total:&nbsp;&nbsp;</a><a style="color:blue" id="sumPrice"></a>
				<a>&nbsp;&nbsp;MwSt.:&nbsp;&nbsp;</a><a style="color:blue" id="sumTax"></a>
				<a>&nbsp;&nbsp;Net Total:&nbsp;&nbsp;</a><a style="color:blue" id="sumNet"></a>
			</div>
		</div>
		
<!-- Modal: Options -->
<div class="modal fade" id="modalOptions" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="mdopTitle">Options</h5>
		</div>
		<div class="modal-body">
			<div class="input-group p-1">
				<a>Print</a>
			</div>
			<div class="input-group p-1">
				<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="printOpNoArt" value="">Do NOT print prefix 'ART' 
				</label>
				</div>
			</div>
			<hr>
			<div class="input-group p-1">
				<a>Export</a>
			</div>
			<div class="input-group p-1">
				<label id="rd1"><input type="radio" class="mx-1" id="radio1" name="exportOp" value="exportOp1" checked>. as delimiter</label>
				<label id="rd2"><input type="radio" class="mx-1" id="radio2" name="exportOp" value="exportOp2">, as delimiter</label>
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
<script src="js/autocomplete.js?202108130959"></script>
<script src="js/modalSelTime.js?202106211441"></script>
<script src="js/modalCustSearch.js?202109090946"></script>
<script src="js/modalCust.js?202108121658"></script>
<script src="js/aOptions.js?202109151712"></script>

<script>
var company = <?php echo json_encode($myCompany) ?>;
var orders = new Array(), orderCount = 0;
var $table = $("#table");
var sortCol = "date", sortOp = 1;
var countTotal = 0, priceTotal = 0, taxTotal = 0, netTotal = 0, invoiceTotal = 0;
var customers, myCustomer = null;
var payType = "pay_all";
var pays = ["pay_cash", "pay_card", "pay_bank", "pay_check", "pay_other", "pay_paypal", "pay_vorkasse"];
// search invoice year
var searchYear = "2022";

initAOptions();

// Load customers. This must be done before all search.
function getCustsBack(result) {
	customers = result;	
	searchOrders();
}
function loadCusts() {
	getRequest("getCusts.php", getCustsBack, null);
}
function getCustNameById(kid) {
	for (var i=0; i<customers.length; i++) {
		if (customers[i]['k_id'] == kid)
			return customers[i]['k_name'];
	}	
	return "Unknown";
}

$table.bootstrapTable({   
	formatNoMatches: function () {
         return "No invoice found";
    }
});

// Display summary
function displaySum(){
	document.getElementById("itemCount").innerText = invoiceTotal;
	document.getElementById("sumCount").innerText = countTotal;
	document.getElementById("sumPrice").innerText = priceTotal.toFixed(2);
	document.getElementById("sumTax").innerText = taxTotal.toFixed(2);
	document.getElementById("sumNet").innerText = netTotal.toFixed(2);
}

function loadTable(){
	countTotal = 0;
	priceTotal = 0;
	taxTotal = 0;
	netTotal = 0;
	invoiceTotal = 0;
	if (orderCount <= 0) {
		displaySum();
		return;
	}

	$table.bootstrapTable('removeAll');
	orders.sort(sortTable(sortCol, sortOp));
	var rows = [];
	for(var i=0; i<orderCount; i++){
		if (!checkPay(orders[i]))
			continue;
		orders[i]['k_name'] = getCustNameById(orders[i]['k_id']);
		var tax = parseFloat(orders[i]['total_sum'])*parseFloat(orders[i]['tax_rate'])/100;
		rows.push({
			id: orders[i]['r_id'],
			idx_no: orders[i]['invoice_no'],
			idx_date: orders[i]['date'].substring(0,10),
			idx_cust: orders[i]['k_name'],
			idx_count: orders[i]['count_sum'],
			idx_total: orders[i]['total_sum'],
			idx_tax: tax.toFixed(2),
			idx_net: orders[i]['net']
		});
		invoiceTotal++;
		countTotal += parseInt(orders[i]['count_sum']);
		priceTotal += parseFloat(orders[i]['total_sum']);
		taxTotal += tax;
		netTotal += parseFloat(orders[i]['net']);
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
		if (key == "invoice_no") {
			x= parseInt(x); y = parseInt(y);
		}
		if (key == "count_sum") {
			x= parseInt(x); y = parseInt(y);
		}
		if (key == "total_sum") {
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
	$table.bootstrapTable('removeAll');
	orderCount = 0;
	countTotal = 0;
	priceTotal = 0;
	taxTotal = 0;
	netTotal = 0;
	displaySum();
}

function searchOrders(){
	var timeResult = mdstGetValue();
	var link = "getInvoices.php?";
	link += timeResult;
	if (myCustomer != null)
		link += "&k_id="+myCustomer['k_id'];
	getRequest(link, afterSearch, displayNo);
}

$(document).ready(function(){
	document.getElementById("btnSelCust").innerText = "All Customers";
	loadCusts();
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
	var url = "aims_order.php?back=aims_list&r_id="+row.id;
	window.location.assign(url);
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
	
	searchOrders();
}

// Show Customer
function selCust() {
	mksInit(2);
	$modalCustSearch.modal();	
}

// modalCustSearch
function mksDoneNext(customer) {
	myCustomer = customer;
	var cname = "";
	if (myCustomer['k_name'].length >= 20)
		cname = myCustomer['k_name'].substr(0, 20);
	else
		cname = myCustomer['k_name'];
	document.getElementById("btnSelCust").innerText = cname;
	searchOrders();
}

// All customers
function allCust() {
	myCustomer = null;
	document.getElementById("btnSelCust").innerText = "All Customers";
	searchOrders();
}

// New customer
function newCust() {
	var customer = new Object();	
	customer['k_id'] = "";
	
	mkInit(customer);
	$modalCust.modal();	
}
// Done modalCust
function mkSaveCust(customer) {
	loadCusts();
}
/****************************************************************************************************
	Select Payment
****************************************************************************************************/
function selPay(e) {
	var type_value = $(e).text();
	document.getElementById("btnPay").innerText = type_value;
	switch (type_value) {
		case "Bar": payType = "pay_cash"; break;
		case "Karte": payType = "pay_card"; break;
		case "Überweisung": payType = "pay_bank"; break;
		case "Scheck": payType = "pay_check"; break;
		case "Nachnahme": payType = "pay_other"; break;
		case "PayPal": payType = "pay_paypal"; break;
		case "Vorkasse": payType = "pay_vorkasse"; break;
		default: payType = "pay_all";
	}
	loadTable();
}
function checkPay(order) {
	if (payType == "pay_all")
		return true;
	for (var i=0; i<pays.length; i++) {
		if (pays[i] == payType && parseFloat(order[pays[i]]) > 0) {
			return true;
			break;
		}
	}
	return false;
}

/****************************************************************************************************
	Search Invoice
****************************************************************************************************/
function searchInvoice() {
	var invoiceNo = document.getElementById("invoice_no").value;
	if (invoiceNo == "")
		return;
	getRequest("getInvoiceByNo.php?invoice_no="+invoiceNo+"&year="+searchYear, searchInvoiceYes, searchInvoiceNo);
}
function searchInvoiceYes(result) {
	var url = "aims_order.php?back=aims_list&r_id="+result['r_id'];
	window.location.assign(url);
}
function searchInvoiceNo(result) {
	alert("No Invoice found");
	document.getElementById("invoice_no").focus();
}

function selInYear(e) {
	searchYear = $(e).text();
	document.getElementById("btnInYear").innerText = searchYear;
}
/****************************************************************************************************
	Export
****************************************************************************************************/
function convertNumber(number) {
	var zhengshu = number.slice(0, number.length-3);
	var xiaoshu = number.substr(-2);
	var newzheng = zhengshu.replace(",",".");
	var newshu = "\""+newzheng+","+xiaoshu+"\"";

	return newshu;	
}

function exportFile() {
	var delim = ',';
	if (aOptions['exportDecimal'] == 1) delim = ';';
	var output = "Rechnung Nr."+delim+"Datum Rechnung"+delim+"Steuergrundlage"+delim+"MwSt"+delim+"Gesamtbetrag"+delim+"Firma\n";
	for (var i=0; i<orderCount; i++) {
		if (!checkPay(orders[i]))
			continue;
		var tax = parseFloat(orders[i]['total_sum'])*parseFloat(orders[i]['tax_rate'])/100;
		output += orders[i]['invoice_no']+delim;
		output += convertDate(orders[i]['date'].substring(0,10))+delim;
		if (aOptions['exportDecimal'] == 1) {
			output += convertNumber(orders[i]['total_sum'])+delim;
			output += convertNumber(tax.toFixed(2))+delim;
			output += convertNumber(orders[i]['net'])+delim;
		} else {
			output += orders[i]['total_sum']+delim;
			output += tax.toFixed(2)+delim;
			output += orders[i]['net']+delim;
		}		
		output += orders[i]['k_name']+'\n';
	}
	
	var a = document.createElement("a");
	var file = new Blob([output], {type: 'text/plain'});
	a.href = URL.createObjectURL(file);
	a.download = "Rechnung-Kunden-"+currentDate(1)+".csv";
	document.body.appendChild(a);
    a.click();window.URL.revokeObjectURL(file);
    a.remove();
}

/* PRINT */
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
		if (!checkPay(orders[i]))
			continue;
		var tax = parseFloat(orders[i]['total_sum'])*parseFloat(orders[i]['tax_rate'])/100;
		output += '<tr style="font-size:12px;">';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+orders[i]['invoice_no']+'</td>';
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
