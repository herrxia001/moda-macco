<?php 
/************************************************************************************
	File:		ainvoice.php
	Purpose:	invoice
************************************************************************************/
// Start session; If session expired, load the login page.
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

// Include files
include_once 'resource.php';
include_once 'db_functions.php';
include_once 'db_invoice.php';

// Init variables
$thisResource = new myResource($_SESSION['uLanguage']);	
$myId = "";
$myCompany= dbQueryCompany();
$backPhp = 'a_ordmgt.php';
$myArts = dbQueryArticles();
$myInvTypes = dbQueryTypes();

// Start a new order
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(isset($_GET['back']))
	{
		$backPhp = $_GET['back'].'.php';
	}
	if (isset($_GET['country']))
	{
		$country = $_GET['country'];
	}
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>	
	<title>EUIMS - Invoice</title>
</head>
<style>
.dropdown-menu{
    max-height: 300px;
    overflow-y: scroll;
}
</style>
<body>	
<?php include 'include/a_nav.php' ?>
<?php include "include/modalSelTime.php" ?>
<?php include "include/modalCustSearch.php" ?>
	<form action="" method="post">
	<div class="container">		
<!-- order data header -->			
	<div class="row"> 
		<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-8" align="left">
            <button type="button" class="btn btn-outline-secondary" id="selTime" onclick="selectTime()"><?php echo $thisResource->mdstRdToday ?></button>
            <input type="text" class="form-control ml-2" style="max-width: 150px;" name="country" id="country" value="<?= $country ?>" readonly>
            <div class="dropdown dropleft">
					<button type="button" class="btn btn-secondary dropdown-toggle ml-2" data-toggle="dropdown" aria-expanded="false">更改国家</button>
					<ul class="dropdown-menu" style="">
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Austria')">Austria</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Belgien')">Belgien</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Czechia')">Czechia</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Denmark')">Denmark</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Deutschland')">Deutschland</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Finland')">Finland</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('France')">France</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Italy')">Italy</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Luxemburg')">Luxemburg</a></li>						
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Nederland')">Nederland</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Schweiz')">Schweiz</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Spain')">Spain</a></li>
					</ul>
				</div>

				<button type="button" class="ml-1 btn btn-outline-secondary" id="btnSelCust" style="width:200px" onclick="selCust()"></button>
				<button type="button" class="ml-1 btn btn-secondary" id="btnAllCust" onclick="allCust()"><span class='fa fa-users'><span></button>
				<button type="button" class="mx-1 btn btn-secondary" id="btnFilter" onclick="showFilter()"><span class='fa fa-bars'></button>

		</div>
        
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-4" align="right">
			<button type="button" class="ml-1 btn btn-secondary" id="btnExport" onclick="exportFile()"><span class='fa fa-floppy-o'></span></button>
			<button type="button" class="ml-1 btn btn-secondary" id="btnPrint" onclick="printFile()"><span class='fa fa-print'></span></button>
			<button type="button" class="btn btn-secondary" id="btnClose" onclick="closeOrder()">关闭</button>	
		</div>
	</div>
<!-- order items -->
	<div class="row"> 
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
			<table id="myTable" data-toggle="table"
				data-single-select="true" data-click-to-select="true" data-unique-id="id" data-height="440">
				<thead>
					<tr>
					<th class="p-1" data-field="id" data-visible="false">#</th>
					<th class="p-1" data-field="idx_image" data-width="15" data-width-unit="%" data-halign="center" data-align="left">照片</th>
					<th class="p-1" data-field="idx_code" data-width="20" data-width-unit="%" data-halign="center" data-align="left">货号</th>
					<th class="p-1" data-field="idx_name" data-width="25" data-width-unit="%" data-halign="center" data-align="left">名称</th>
					<th class="p-1" data-field="idx_count" data-width="10" data-width-unit="%" data-halign="center" data-align="right">件数</th>
					<th class="p-1" data-field="idx_price" data-width="10" data-width-unit="%" data-halign="center" data-align="right">售价</th>
					<th class="p-1" data-field="idx_subtotal" data-width="10" data-width-unit data-halign="center" data-align="right">小计</th>					
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
<!-- buttons -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-3" align = "left">
			<b>总件数:&nbsp;</b><label id="sumCount" style="color:blue">0</label>
			<b>&nbsp;&nbsp;总金额:&nbsp;</b><label id="sumPrice" style="color:blue">0.00</label>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-2" align = "center">
			<b>&nbsp;&nbsp;费用:&nbsp;</b><label id="sumFees" style="color:blue">0.00</label>
		</div>
        <div class="p-1 col-12 col-sm-12 col-md-12 col-lg-2" align = "center">
			<b>&nbsp;&nbsp;税前金额:&nbsp;</b><label id="sumTotal" style="color:blue">0.00</label>
		</div>
        <div class="p-1 col-12 col-sm-12 col-md-12 col-lg-5" align = "right">						
			<b>&nbsp;&nbsp;MwSt(</b><label id="sumTaxRate" style="color:blue">0.00</label><b>%)</b>
			<label id="sumTax" style="color:blue">0.00</label>
			<b>&nbsp;&nbsp;完税金额:&nbsp;</b><label id="sumNet" style="color:blue">0.00</label>
		</div>
	</div>	




	</div> <!-- end of container -->
	</form>	<!-- end of form -->

	<!-- Modal: modalFilter -->
<div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<b class="modal-title" id="mdfTitle">选项</b>
		</div>
		<div class="modal-body">

<!-- Types -->
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text">类别</span></div>
				<div class="dropdown">
				<button type="button" class="p-1 ml-1 btn btn-outline-secondary dropdown-toggle" id="t_name" data-toggle="dropdown" style="width:220px">
					全部类别</button>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#" onclick="filterType(this)">全部类别</a>
						<a class="dropdown-item" href="#" onclick="filterType(this)">未知类别</a>
						<?php for($i=0; $i<count($myInvTypes); $i++) 
							echo "<a class='dropdown-item' href='#' onclick='filterType(this)'>".$myInvTypes[$i]['t_name']."</a>";
						?>
					</div>
				</div>
			</div>
		</div>

		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-success" id="btnClearFilter" onclick="clearFilter()">选择全部</button>
			<button type="button" class="btn btn-primary" id="btnDoneFilter" onclick="doneFilter()"><span class='fa fa-check'></button>
		</div>
	</div>
	</div>
</div>


<script src="js/sysfunc.js?01201058"></script>
<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?202109131930"></script>	
<script src="js/modalSelTime.js?202106211441"></script>
<script src="js/modalCustSearch.js?202109090946"></script>
<script src="js/aOptions.js?2022-0914-1022"></script>

<script>
var customers, myCustomer = null;
var country;
var myCustomer = new Object();
var company = <?php echo json_encode($myCompany) ?>;
var $table = $("#myTable");

// Data
var orders = [], orderItems = [];
var itemCount = 0, itemIdCount = 0;
var thisItem = {};
var myArts;
var a_types = <?php echo json_encode($myInvTypes) ?>;


var fType = "";


/************************************************************************************
	FILTER
************************************************************************************/

$modalFilter = $('#modalFilter');
function showFilter() {
	$modalFilter.modal();
}

function doneFilter(){
	$modalFilter.modal("toggle");
	if (fType == "")
		document.getElementById("btnFilter").style.border = "none";
	else
		document.getElementById("btnFilter").style.border = "2px solid red";
	searchOrders();
}
function clearFilter() {
	$modalFilter.modal("toggle");
	var y = "全部类别";
	document.getElementById("t_name").innerHTML = y; 
	fType = "";
	document.getElementById("btnFilter").style.border = "none";
	searchOrders();
}
// Filter by types
function filterType(e) {
	var x = $(e).text();
	document.getElementById("t_name").innerHTML = x;
	fType = getTypeIdByName(x);	
}

function getTypeIdByName(name) {
	if (name == "全部类别")
		return "";
	if (name == "")
		return "0";
	
	for (var i=0; i<a_types.length; i++) {
		if (a_types[i]['t_name'] == name) {
			return a_types[i]['t_id'];
			break;
		}
	}
	
	return "";
}

 // Done modalCust
function mkSaveCust(customer) {
	loadCusts();
}
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
	return "未知客户";
}

function getCustById(kid) {
	for (var i=0; i<customers.length; i++) {
		if (customers[i]['k_id'] == kid)
			return customers[i];
	}	
	return null;
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
	
	searchOrders();
}

// Options
initAOptions();
var opPrintOnePage = false;

 // Init variables
country = "<?php echo $country ?>";

$(document).ready(function(){
	// Load all articles
	loadArts();

	// Search by default
	document.getElementById("btnSelCust").innerText = "全部客户";
	loadCusts();
})


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
	document.getElementById("btnSelCust").innerText = "全部客户";
	searchOrders();
}

function changeCountry(cty){
    country = cty;
    $("#country").val(country);
    searchOrders();
}
function searchOrders(){

    $table.bootstrapTable('removeAll');

    document.getElementById("sumCount").innerHTML = 0;
    document.getElementById("sumPrice").innerHTML = "0.00";
    document.getElementById("sumFees").innerHTML = "0.00";
    document.getElementById("sumTotal").innerHTML = "0.00";
    document.getElementById("sumTaxRate").innerHTML = "0.00";
    document.getElementById("sumTax").innerHTML = "0.00";
    document.getElementById("sumNet").innerHTML = "0.00";

	//myCustomer && fType //
	var search_kid = "";
	if (myCustomer !== null) {
		search_kid = myCustomer['k_id'];
	}
	if(typeof search_kid == "undefined") search_kid = "";

    var timeResult = mdstGetValue();
    var link = "getInvoiceByCountryDate.php?";
    link += timeResult;
    link += "&country="+country+"&kid="+search_kid+"&fType="+fType;
	console.log(link);
	getRequest(link, loadOrder, loadError);
}

// Load articles for new items
function loadArtsYes(result) {
	myArts = result; 
}
function loadArts() {
	getRequest("getArts.php", loadArtsYes, null);
}

// Load Order
function loadError(result) {
//	alert("读取发票过程中出现错误");
    /*$table.bootstrapTable({   
        formatNoMatches: function () {
            return "未找到商品";
        }
    });*/
}
function loadOrder(result) { 
	orders = result;
    console.log(result);
    
    for(var i = 0; i<orders.length; i++){
        var order = orders[i];
        var rId = order['r_id'];
        getRequest("getInvoiceItemsById.php?r_id="+rId, loadOrderItems, loadError);
    }
    displaySum();
}



// Load Order Items after getRequest
function loadOrderItems(result) {
	orderItems = result;
	itemCount = orderItems.length;
	itemIdCount = itemCount;

	var rows = [];
	var imgSrc, imgStr, code, name, countStr, subtotal;
	for (var i=0; i<itemCount; i++) {
		orderItems[i]['id'] = i;
		if (orderItems[i]['i_id'] != "0") {
			imgSrc = orderItems[i]['path']+"/"+orderItems[i]['i_id']+"_"+orderItems[i]['m_no']+"_s.jpg";
			imgStr = "<img width='40' height='60' style='border:1px dotted; object-fit: cover' src='"+imgSrc+"' >";
			code = orderItems[i]['i_code'];
			name = orderItems[i]['i_name'];
		} else {
			imgStr = "";
			code = orderItems[i]['ai_code'];
			name = orderItems[i]['a_name'];
		}
		if (orderItems[i]['unit'] == "1") {
			countStr = orderItems[i]['count'];
			orderItems[i]['real_count'] = orderItems[i]['count'];
		} else {
			countStr = orderItems[i]['count']+" (x"+orderItems[i]['unit']+")";
			orderItems[i]['real_count'] = parseInt(orderItems[i]['count'])*parseInt(orderItems[i]['unit']);
		}
		subtotal = parseInt(orderItems[i]['real_count'])*parseFloat(orderItems[i]['price']);
		orderItems[i]['subtotal'] = subtotal.toFixed(2);
		rows.push({
			id: orderItems[i]['id'],
			idx_image: imgStr,
			idx_code: code,
			idx_name: name,
			idx_count: countStr,
			idx_price: orderItems[i]['price'],
			idx_subtotal: orderItems[i]['subtotal']
		});		
	}
	$table.bootstrapTable('append', rows);
}

// Display sum
function displaySum() {	
    var sumCount = 0;
    var allsumPrice = 0;
    var allsumFees = 0;
    var allsumTotal = 0;
    var sumTaxRate = 0;
    var allsumTax = 0;
    var allsumNet = 0;
    for(var i = 0; i<orders.length; i++){
        var order = orders[i];
        var sumPrice = parseFloat(order['price_sum']);
        var sumFees = parseFloat(order['fee1']) + parseFloat(order['fee2']) + parseFloat(order['fee3']) + parseFloat(order['fee4']) + parseFloat(order['fee5']);
        var sumTotal = sumPrice - parseFloat(order['discount_rate'])/100*sumPrice + sumFees;
        var sumTax = sumTotal*parseFloat(order['tax_rate'])/100+0.0000001;
        var sumNet = sumTotal + sumTax;		
        var sumPaid = parseFloat(order['pay_cash']) + parseFloat(order['pay_card']) + parseFloat(order['pay_bank']) + 
                        parseFloat(order['pay_check']) + parseFloat(order['pay_other']) + parseFloat(order['pay_paypal']) + parseFloat(order['pay_vorkasse']);
        var sumDue = parseFloat(sumNet.toFixed(2)) - parseFloat(sumPaid.toFixed(2));
        
        order['total_sum'] = sumTotal.toFixed(2);
        order['net'] = sumNet.toFixed(2);
        order['paid_sum'] = sumPaid.toFixed(2);
        order['due'] = sumDue.toFixed(2);
        if (order['due'] == "-0.00")
            order['due'] = "0.00";
        
        sumCount += parseInt(order['count_sum']);
        allsumPrice += parseFloat(order['price_sum']);
        allsumFees += parseFloat(sumFees);
        allsumTotal += parseFloat(order['total_sum']);
        sumTaxRate = order['tax_rate'];
        allsumTax += parseFloat(sumTax);
        allsumNet += parseFloat(order['net']);
    }
    document.getElementById("sumCount").innerHTML = sumCount;
    document.getElementById("sumPrice").innerHTML = allsumPrice.toFixed(2);
    document.getElementById("sumFees").innerHTML = allsumFees.toFixed(2);
    document.getElementById("sumTotal").innerHTML = allsumTotal.toFixed(2);
    document.getElementById("sumTaxRate").innerHTML = sumTaxRate;
    document.getElementById("sumTax").innerHTML = allsumTax.toFixed(2);
    document.getElementById("sumNet").innerHTML = allsumNet.toFixed(2);
}


function exportFile() {
	var delim = ',';
	if (aOptions['exportDecimal'] == 1) delim = ';';
	var output = "Rechnung Nr."+delim+"Datum Rechnung"+delim+"Steuergrundlage"+delim+"MwSt"+delim+"Gesamtbetrag"+delim+"Firma\n";
	var inNo = "", payFlag = 0;
	for (var i=0; i<orders.length; i++) {
		//payFlag = checkPay(orders[i]);
		//if (!payFlag)
		//	continue;
		//if (payFlag == 1)
			inNo = orders[i]['invoice_no'];
		//else
		//	inNo = orders[i]['invoice_no'] + " *";
		var tax = parseFloat(orders[i]['total_sum'])*parseFloat(orders[i]['tax_rate'])/100;
		output += inNo + delim;
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
		output += getCustNameById(orders[i]['k_id'])+'\n';
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
	var inNo = "", payFlag = 0;
	for (var i=0; i<orders.length; i++) {
		//payFlag = checkPay(orders[i]);
		//if (!payFlag)
		//	continue;
		//if (payFlag == 1)
			inNo = orders[i]['invoice_no'];
		//else
		//	inNo = orders[i]['invoice_no'] + " *";
		var tax = parseFloat(orders[i]['total_sum'])*parseFloat(orders[i]['tax_rate'])/100;
		output += '<tr style="font-size:12px;">';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+inNo+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+convertDate(orders[i]['date'].substring(0,10))+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+orders[i]['total_sum']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+tax.toFixed(2)+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+'&nbsp;'+orders[i]['net']+'</td>';
		output += '<td style="padding:1px; border-left:1px solid; border-top:1px solid;">'+'&nbsp;'+getCustNameById(orders[i]['k_id'])+'</td>';
		output += '</tr>';
	}
	output += '<tr style="font-size:12px;">';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" colspan="2">Gesamtsumme&nbsp;</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+document.getElementById("sumPrice").innerHTML+'</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+document.getElementById("sumTax").innerHTML+'</td>';
	output += '<td align="right" style="padding:1px; border-left:1px solid; border-top:1px solid;" align="right">'+document.getElementById("sumTotal").innerHTML+'</td>';
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

/************************************************************************
	CLOSE INVOICE
************************************************************************/
function closeInvoice() {
	var url = "<?php echo $backPhp; ?>";
	window.location.assign(url);
}
function closeOrder() {
	//if (!notZero(order['invoice_no'])) {
	//	alert("发票没有完成. 请先保存或者打印发票, 您也可以删除当前发票");
	//	return;
	//}
	 closeInvoice();
}

</script>

</body>
</html>
