<?php
/************************************************************************************
	File:		a_transactions.php

************************************************************************************/
// Start session; If session expired, load the login page.
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

// Include files
include_once 'resource.php';
include_once 'db_functions.php';

// Init variables
$thisResource = new myResource($_SESSION['uLanguage']);

$myCompany= dbQueryCompany();

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUIMS - TRANSACTIONS</title>
</head>

<style>
.loader {
  position: fixed;
  left: 48%;
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
	<?php include 'include/a_nav.php' ?>
	<?php include "include/modalSelTime.php" ?>
	
	<div class="container">	
<!-- options -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6">
			<button type="button" class="p-1 btn btn-outline-secondary" id="selTime" onclick="selectTime()"  style="width:220px">
				<?php echo $thisResource->mdstRdThisMonth ?></button>
		</div>
		<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3">
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="chkShowInOut" onChange="clickShowInOut()">显示当前库存 
				</label>
			</div>
		</div>
		<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3" align="right">			
			<button type="button" class="btn btn-secondary" id="btnExport" onclick="exportFile()"><span class='fa fa-floppy-o'></button>
			<button type="button" class="btn btn-secondary" id="btnPrint" onclick="printFile()"><span class='fa fa-print'></button>
		</div>
	</div>
<!-- Article table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
			<table id="table" class="table-sm" data-toggle="table" 
				data-single-select="true" data-click-to-select="true" data-unique-id="id" data-height="480">
				<thead class="thead-light">
					<tr>
					<th class="p-1" data-field="id" data-width-unit="%" data-visible="false"></th>			
					<th class="p-1" data-field="idx_data" data-halign="center" >商品</th>
					<th class="p-1" data-field="idx_count" data-halign="center" data-align="right">当前库存</th>
					<th class="p-1" data-field="idx_total" data-halign="center" data-align="right">库存金额</th>
					<th class="p-1" data-field="idx_in" data-halign="center" data-align="right">进货</th>
					<th class="p-1" data-field="idx_invalue" data-halign="center" data-align="right">进货金额</th>
					<th class="p-1" data-field="idx_out" data-halign="center" data-align="right">销售</th>
					<th class="p-1" data-field="idx_outvalue" data-halign="center" data-align="right">销售金额</th>
					<th class="p-1" data-field="idx_rf" data-halign="center" data-align="right">退货</th>
					<th class="p-1" data-field="idx_rfvalue" data-halign="center" data-align="right">退货金额</th>
					</tr>
				</thead>
			</table>
			<div class="loader" id="loader"></div>
		</div>
	</div>
<!-- summary -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-3" align="center">
			<a>库存件数:&nbsp;&nbsp;</a><a style="color:blue" id="sumCount"></a>
			<a>&nbsp;&nbsp;总金额:&nbsp;&nbsp;</a><a style="color:blue" id="sumTotal"></a>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-3" align="center">
			<a>进货件数:&nbsp;&nbsp;</a><a style="color:blue" id="sumInCount"></a>
			<a>&nbsp;&nbsp;总金额:&nbsp;&nbsp;</a><a style="color:blue" id="sumInTotal"></a>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-3" align="center">
			<a>销售件数:&nbsp;&nbsp;</a><a style="color:blue" id="sumOutCount"></a>
			<a>&nbsp;&nbsp;总金额:&nbsp;&nbsp;</a><a style="color:blue" id="sumOutTotal"></a>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-3" align="center">
			<a>退货件数:&nbsp;&nbsp;</a><a style="color:blue" id="sumRfCount"></a>
			<a>&nbsp;&nbsp;总金额:&nbsp;&nbsp;</a><a style="color:blue" id="sumRfTotal"></a>
		</div>
	</div>
	
	</div> <!-- End of container -->

</body>

<script src="js/sysfunc.js?v2"></script>
<script src="js/ajax.js"></script>
<script src="js/autocomplete.js"></script>
<script src="js/modalSelTime.js?v1"></script>

<script>

/****************************************************************************************************
	PHP VARIABLES
****************************************************************************************************/
var company = <?php echo json_encode($myCompany) ?>;

/****************************************************************************************************
	LOCAL VARIABLES
****************************************************************************************************/
var $table = $("#table"), $table1 = $("#table1");;
var arts = [], sales = [], purs = [], refunds = [];
var countTotal = 0, costTotal = 0;
var sumOutCount = 0, sumOutTotal = 0;
var sumInCount = 0, sumInTotal = 0;
var sumRfCount = 0, sumRfTotal = 0;
var fTime;
var bShowInOut = false;

/****************************************************************************************************
	INIT"
****************************************************************************************************/
$(document).ready(function(){
	document.getElementById("myTitle").innerText = "库存明细";
	
	loadShowInOut();
	
	mdstSetChecked("timeThisMonth");
	fTime = mdstGetValue(1);
	
	getReports();
});

$table.bootstrapTable({   
	formatNoMatches: function () {
         return "没有找到符合条件的数据";
    }
});

$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

/****************************************************************************************************
	GET REPORTS
****************************************************************************************************/
function getReports() {
	var timestr = "timefrom="+fTime['timefrom']+"&timeto="+fTime['timeto'];
	var link = "aGetReports.php?"+timestr;
		
	document.getElementById("loader").style.display = "block";
	getRequest(link, getReportsYes, getReportsNo);
}

function getReportsYes(result) {
	document.getElementById("loader").style.display = "none";
	arts = result['arts']; 
	if (result['sales'] == 0)
		sales = [];
	else
		sales = result['sales'];
	if (result['purs'] == 0)
		purs = [];
	else
		purs = result['purs'];
	if (result['refunds'] == 0)
		refunds = [];
	else
		refunds = result['refunds'];
	showTable();	
}

function getReportsNo(result) {
	document.getElementById("loader").style.display = "none";
	arts = [];
	sales = [];
	purs = [];
	refunds = [];
	showTable();
}

/****************************************************************************************************
	LOAD REPORTS
****************************************************************************************************/
function showTable() {
	var subTotal = 0, countOut = 0, totalOut = 0, countIn = 0, totalIn = 0, countRf = 0, totalRf = 0;
	var ok = 0;
	var rows = [], i = 0, j = 0;

	countTotal = 0;
	costTotal = 0;
	sumOutCount = 0;
	sumOutTotal = 0;
	sumInCount = 0;
	sumInTotal = 0;
	sumRfCount = 0;
	sumRfTotal = 0;
	
	$table.bootstrapTable('removeAll');
	for(i=0; i<arts.length; i++){
		// arts
		subTotal = parseFloat(arts[i]['cost'])*parseInt(arts[i]['count']);
		arts[i]['subtotal'] = subTotal.toFixed(2);
		countTotal += parseInt(arts[i]['count']);
		costTotal += subTotal;
		
		// sales
		countOut = 0;
		totalOut = 0;
		ok = 0;
		for (j=0; j<sales.length; j++) {
			if (sales[j]['a_id'] == arts[i]['a_id']) {
				ok = 1;
				countOut = parseInt(sales[j]['count_sale']);
				totalOut = parseFloat(sales[j]['total_sale']);
				break;
			}
		}
		arts[i]['count_out'] = countOut.toString();
		arts[i]['total_out'] = totalOut.toFixed(2);
		sumOutCount += countOut;
		sumOutTotal += totalOut;
		
		// purs
		countIn = 0;
		totalIn = 0;
		ok = 0;
		for (j=0; j<purs.length; j++) {
			if (purs[j]['a_id'] == arts[i]['a_id']) {
				ok = 1;
				countIn = parseInt(purs[j]['count_pur']);
				totalIn = parseFloat(purs[j]['total_pur']);
				break;
			}
		}
		arts[i]['count_in'] = countIn.toString();
		arts[i]['total_in'] = totalIn.toFixed(2);
		sumInCount += countIn;
		sumInTotal += totalIn;
		
		// refunds
		countRf = 0;
		totalRf = 0;
		ok = 0;
		for (j=0; j<refunds.length; j++) {
			if (refunds[j]['a_id'] == arts[i]['a_id']) {
				ok = 1;
				countRf = parseInt(refunds[j]['count_rf']);
				totalRf = parseFloat(refunds[j]['total_rf']);
				break;
			}
		}
		arts[i]['count_rf'] = countRf.toString();
		arts[i]['total_rf'] = totalRf.toFixed(2);
		sumRfCount += countRf;
		sumRfTotal += totalRf;
		
		// table
		rows.push({
			id: 			arts[i]['a_id'],
			idx_data: 		arts[i]['a_name'],
			idx_count: 		arts[i]['count'],
			idx_total: 		arts[i]['subtotal'],
			idx_in:			arts[i]['count_in'],
			idx_invalue:	arts[i]['total_in'],
			idx_out:		arts[i]['count_out'],
			idx_outvalue:	arts[i]['total_out'],
			idx_rf:			arts[i]['count_rf'],
			idx_rfvalue:	arts[i]['total_rf']
		});
	}
	$table.bootstrapTable('append', rows);	
	showSum();
}

function showSum(){	
	document.getElementById("sumCount").innerText = countTotal;	
	document.getElementById("sumTotal").innerText = costTotal.toFixed(2);
	
	document.getElementById("sumOutCount").innerText = sumOutCount;	
	document.getElementById("sumOutTotal").innerText = sumOutTotal.toFixed(2);	
	
	document.getElementById("sumInCount").innerText = sumInCount;	
	document.getElementById("sumInTotal").innerText = sumInTotal.toFixed(2);
	
	document.getElementById("sumRfCount").innerText = sumRfCount;	
	document.getElementById("sumRfTotal").innerText = sumRfTotal.toFixed(2);
}

/****************************************************************************************************
	SHOW IN/OUT
****************************************************************************************************/
function loadShowInOut() {
	var bShow = localStorage.getItem("a_trans_showinout"); 
	
	if (bShow == null || bShow == "0") {
		bShowInOut = false;
	} else {
		bShowInOut = true;
	}
	
	document.getElementById("chkShowInOut").checked = bShowInOut;
	showInOut();	
}

function saveShowInOut() {
	var bShow = "0";
	
	if (!bShowInOut) {
		bShow = "0";
	} else {
		bShow = "1";
	}
	
	localStorage.setItem("a_trans_showinout", bShow);	
	showInOut();
}

function clickShowInOut() {
	bShowInOut = !bShowInOut;
	saveShowInOut();	
}

function showInOut() {
	if (!bShowInOut) {
		$table.bootstrapTable('hideColumn', 'idx_count');
		$table.bootstrapTable('hideColumn', 'idx_total');
	} else {
		$table.bootstrapTable('showColumn', 'idx_count');
		$table.bootstrapTable('showColumn', 'idx_total');
	}	
}

/****************************************************************************************************
	TIME
****************************************************************************************************/
function selectTime(){
	$modalSelTime.modal();	
}

// Finish time selection (modalTime)
function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
	 
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	
	fTime = mdstGetValue(1);
	getReports();
}

/****************************************************************************************************
	EXPORT
****************************************************************************************************/
function exportFile() {
/*
	if (bShowInOut) {
		var output = "Bezeichnung,Menge Einahmen,Wert Einahmen,Menge Ausgaben,Wert Ausgaben,Menge Bestand,Wer Bestand\n";
		for (var i=0; i<arts.length; i++) {
			output += arts[i]['a_name']+',';
			output += arts[i]['count_in']+',';
			output += arts[i]['total_in']+',';
			output += arts[i]['count_out']+',';
			output += arts[i]['total_out']+',';
			output += arts[i]['count']+',';
			output += arts[i]['subtotal']+'\n';
		}
	} else {
		var output = "Bezeichnung,Menge Einahmen,Wert Einahmen,Menge Ausgaben,Wert Ausgaben\n";
		for (var i=0; i<arts.length; i++) {
			output += arts[i]['a_name']+',';
			output += arts[i]['count_in']+',';
			output += arts[i]['total_in']+',';
			output += arts[i]['count_out']+',';
			output += arts[i]['total_out']+'\n';
		}
	}
*/	
	var output = "Bezeichnung,Menge Einahmen,Wert Einahmen,Menge Ausgaben,Wert Ausgaben\n";
	for (var i=0; i<arts.length; i++) {
		output += arts[i]['a_name']+',';
		output += arts[i]['count_in']+',';
		output += arts[i]['total_in']+',';
		output += arts[i]['count_out']+',';
		output += arts[i]['total_out']+'\n';
	}
			
	var a = document.createElement("a");
	var file = new Blob([output], {type: 'text/plain'});
	var url = URL.createObjectURL(file);
	a.href = url;
	a.download = "transactions"+currentDate(1)+".csv";
	document.body.appendChild(a);
    a.click();
	window.URL.revokeObjectURL(url);
    a.remove();
}

/****************************************************************************************************
	PRINT
****************************************************************************************************/
function printFile() { 
	var i = 0;	
	var dt = currentDate();	
	var timeRange = mdstGetValue(1);
	
	var src = "files/"+"<?php echo $_SESSION['uDb']; ?>"+"/logo.png";
	var output = '<html><head>';
	output += '<style type="text/css" media="print">';
	output += '.thCenter{border-left:1px solid; text-align:center;}';
	output += '.tdLeft{padding:1px; border-left:1px solid; border-top:1px solid; text-align:left;}';
	output += '.tdRight{padding:1px; border-left:1px solid; border-top:1px solid; text-align:right;}';
	output += '@page { size:auto; margin:0.8cm 0.8cm 0.8cm 1.5cm; }\</style>';
	output += '</head><body>';	
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
	output += '<th class="thCenter">Bezeichnung</th>';
	output += '<th class="thCenter">Menge<br>Einahmen</th>';
	output += '<th class="thCenter">Wert<br>Einahmen</th>';
	output += '<th class="thCenter">Menge<br>Ausgaben</th>';
	output += '<th class="thCenter">Wert<br>Ausgaben</th>';
/*
	if (bShowInOut) {
		output += '<th class="thCenter">Menge<br>Bestand</th>';
		output += '<th class="thCenter">Wert<br>Bestand</th>';
	}
*/
	output += '</tr></thead><tbody>';
	for (i=0; i<arts.length; i++) {
		output += '<tr style="font-size:12px;">';
		output += '<td class="tdLeft">'+'&nbsp;'+arts[i]['a_name']+'</td>';
		output += '<td class="tdRight">'+'&nbsp;'+arts[i]['count_in']+'</td>';
		output += '<td class="tdRight">'+'&nbsp;'+arts[i]['total_in']+'</td>';
		output += '<td class="tdRight">'+'&nbsp;'+arts[i]['count_out']+'</td>';
		output += '<td class="tdRight">'+'&nbsp;'+arts[i]['total_out']+'</td>';
/*
		if (bShowInOut) {
			output += '<td class="tdRight">'+'&nbsp;'+arts[i]['count']+'</td>';
			output += '<td class="tdRight">'+'&nbsp;'+arts[i]['subtotal']+'</td>';
		}
		output += '</tr>';
*/
	}
	output += '<tr style="font-size:12px;">';
	output += '<td class="tdRight">Total&nbsp;</td>';
	output += '<td class="tdRight">'+sumInCount+'</td>';
	output += '<td class="tdRight">'+sumInTotal.toFixed(2)+'</td>';
	output += '<td class="tdRight">'+sumOutCount+'</td>';
	output += '<td class="tdRight">'+sumOutTotal.toFixed(2)+'</td>';
/*
	if (bShowInOut) {
		output += '<td class="tdRight">'+countTotal+'</td>';
		output += '<td class="tdRight">'+costTotal.toFixed(2)+'</td>';
	}
*/
	output += '</tr>';
	output += '</tbody></table>';
	// Footer
	output += '<a style="font-size:12px">Datum:&nbsp;'+dt+'&nbsp;&nbsp;Betreiber:&nbsp;'+company['c_name']+'</a>';
	// Print
	var mywindow = window.open();
    mywindow.document.write(output);
	mywindow.document.close();
	mywindow.focus();
	if (/Android/i.test(navigator.userAgent)) {
		openPrintDialogue(output);
	} else if (/iPhone|iPad/i.test(navigator.userAgent)) {
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

function openPrintDialogue(output){
	var iframe = document.createElement('iframe');
	iframe.id = 'print_order';
	iframe.name = 'print_order';
	iframe.style.visibility = "hidden";
	iframe.srcdoc = output;
	document.body.appendChild(iframe);
	window.frames['print_order'].onload = function () {
		window.frames['print_order'].focus();
		window.frames['print_order'].print();
	}		
};

</script>

</html>
