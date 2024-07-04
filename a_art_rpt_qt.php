<?php
/************************************************************************************
	File:		a_art_rpt_qt.php

************************************************************************************/
// Start session; If session expired, load the login page.
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

// Include files
include_once 'resource.php';
include_once 'db_functions.php';
include_once 'db_invoice.php';

$thisResource = new myResource($_SESSION['uLanguage']);
$myCompany= dbQueryCompany();

if(isset($_GET['year']) && isset($_GET['month'])) {
	$year = $_GET['year'];
	$month = $_GET['month'];
} else {
	$year = date("Y");
	$month = date("m");
	if ($month >= 10)
		$month = 0;
	else if ($month >= 7 && $month <= 9)
		$month = 9;
	else if ($month >= 4 && $month <= 6)
		$month = 6;
	else
		$month = 3;
}

if ($month == 3) {
	$yearLast = $year - 1;
	$monthLast = 0;
} else if($month == 0){
	$yearLast = $year;
	$monthLast = 9;
}else{
	$yearLast = $year;
	$monthLast = $month - 3;
}
$invs = dbQueryArtHist($year, $month);
$last = dbQueryArtHistLast($yearLast, $monthLast);

if(is_array($invs))for ($i=0; $i<count($invs); $i++) {
	$sum['count'] += intval($invs[$i]['count']);
	
	$invs[$i]['subtotal'] = strval(intval($invs[$i]['count'])*floatval($invs[$i]['cost']));
	$sum['subtotal'] += floatval($invs[$i]['subtotal']);
	
	if ($invs[$i]['in_count'] == NULL) $invs[$i]['in_count'] = "0";
	$sum['in_count'] += intval($invs[$i]['in_count']);
	
	if ($invs[$i]['in_total'] == NULL) $invs[$i]['in_total'] = "0.00";
	$sum['in_total'] += floatval($invs[$i]['in_total']);
	
	if ($invs[$i]['out_count'] == NULL) $invs[$i]['out_count'] = "0";
	$sum['out_count'] += intval($invs[$i]['out_count']);
	
	if ($invs[$i]['out_total'] == NULL) $invs[$i]['out_total'] = "0.00";
	$sum['out_total'] += floatval($invs[$i]['out_total']);
	
	if ($invs[$i]['rf_count'] == NULL) $invs[$i]['rf_count'] = "0";
	$sum['rf_count'] += intval($invs[$i]['rf_count']);
	
	if ($invs[$i]['rf_total'] == NULL) $invs[$i]['rf_total'] = "0.00";
	$sum['rf_total'] += floatval($invs[$i]['rf_total']);
	
	if ($last <= 0) {
		$invs[$i]['last'] = strval(intval($invs[$i]['count']) - intval($invs[$i]['in_count']) + intval($invs[$i]['out_count']) - intval($invs[$i]['rf_count']));		
	} else {
		$ok = 0;
		for ($j=0; $j<count($last); $j++) {
			if ($last[$j]['a_id'] == $invs[$i]['a_id']) {
				$invs[$i]['last'] = $last[$j]['count'];
				$ok = 1;
				break;
			}
		}
		if (!$ok) {
			$invs[$i]['last'] = "0";
		}
	}
	$sum['last'] += intval($invs[$i]['last']);
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUIMS - ARTICLES - QUARTERLY REPORT</title>
</head>

<body>
	<?php include 'include/a_nav.php' ?>
	
	<div class="container">	
<!-- options -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-4 input-group">
			<div class="dropdown">
				<button type="button" class="btn btn-outline-secondary dropdown-toggle" id="btnYear" data-toggle="dropdown"><?= $year ?></button>
				<div class="dropdown-menu">
					<?php for($i = date("Y"); $i >= 2020; $i--){ ?>
						<li class="dropdown-item" onclick="selYear(this)"><?= $i ?></li>
					<?php }?>
				</div>
			</div>
			<div class="dropdown">
				<button type="button" class="ml-1 btn btn-outline-secondary dropdown-toggle" id="btnQuarter" data-toggle="dropdown"></button>
				<div class="dropdown-menu">
					<li class="dropdown-item" onclick="selQuater(this)">第一季度</li>
					<li class="dropdown-item" onclick="selQuater(this)">第二季度</li>
					<li class="dropdown-item" onclick="selQuater(this)">第三季度</li>
					<li class="dropdown-item" onclick="selQuater(this)">第四季度</li>					
				</div>
			</div>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6 input-group">
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="chkLastInv" onChange="clickLastInv()">打印初始库存 
				</label>
			</div>
			<div class="form-check ml-2">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="chkInOut" onChange="clickInOut()">打印进销明细 
				</label>
			</div>
		</div>
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-2" align="right">			
			<button type="button" class="btn btn-secondary" id="btnExport" onclick="exportFile()"><span class='fa fa-floppy-o'></button>
			<button type="button" class="btn btn-secondary" id="btnPrint" onclick="printFile()"><span class='fa fa-print'></button>
		</div>
	</div>
<!-- Article table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
			<table id="table" class="table-sm" data-toggle="table" 
				data-show-footer="true" data-unique-id="id" data-height="480">
				<thead class="thead-light">
					<tr>
					<th class="p-1" data-field="id" data-visible="false"></th>			
					<th class="p-1" data-field="idx_data" data-halign="center" data-sortable="true">商品</th>
					<th class="p-1" data-field="idx_last" data-halign="center" data-align="right" data-sortable="true">初始库存</th>
					<th class="p-1" data-field="idx_count" data-halign="center" data-align="right" data-sortable="true">截止库存</th>
					<th class="p-1" data-field="idx_cost" data-halign="center" data-align="right" data-sortable="true">单位成本</th>					
					<th class="p-1" data-field="idx_total" data-halign="center" data-align="right" data-sortable="true">库存金额</th>
					<th class="p-1" data-field="idx_in" data-halign="center" data-align="right" data-sortable="true">进货</th>
					<th class="p-1" data-field="idx_invalue" data-halign="center" data-align="right" data-sortable="true">进货金额</th>
					<th class="p-1" data-field="idx_out" data-halign="center" data-align="right" data-sortable="true">销售</th>
					<th class="p-1" data-field="idx_outvalue" data-halign="center" data-align="right" data-sortable="true">销售金额</th>
					<th class="p-1" data-field="idx_rf" data-halign="center" data-align="right" data-sortable="true">退货</th>
					<th class="p-1" data-field="idx_rfvalue" data-halign="center" data-align="right" data-sortable="true">退货金额</th>
					</tr>
				</thead>
				<tbody>
				<?php if(is_array($invs))for ($i=0; $i<count($invs); $i++) { ?>
					<tr>
					<td></td>
					<td><?php echo $invs[$i]['a_name']; ?></td>
					<td><?php echo $invs[$i]['last']; ?></td>
					<td><?php echo $invs[$i]['count']; ?></td>
					<td><?php echo $invs[$i]['cost']; ?></td>
					<td><?php echo $invs[$i]['subtotal']; ?></td>
					<td><?php echo $invs[$i]['in_count']; ?></td>
					<td><?php echo $invs[$i]['in_total']; ?></td>
					<td><?php echo $invs[$i]['out_count']; ?></td>
					<td><?php echo $invs[$i]['out_total']; ?></td>
					<td><?php echo $invs[$i]['rf_count']; ?></td>
					<td><?php echo $invs[$i]['rf_total']; ?></td>
					</tr>
				<?php } ?>
				</tbody>
				<tfoot>
					<tr>
					<td></td>
					<td>总计</td>
					<td><?php echo $sum['last']; ?></td>
					<td><?php echo $sum['count']; ?></td>
					<td>-</td>
					<td><?php echo number_format((float)$sum['subtotal'], 2, '.', ''); ?></td>
					<td><?php echo $sum['in_count']; ?></td>
					<td><?php echo number_format((float)$sum['in_total'], 2, '.', ''); ?></td>
					<td><?php echo $sum['out_count']; ?></td>
					<td><?php echo number_format((float)$sum['out_total'], 2, '.', ''); ?></td>
					<td><?php echo $sum['rf_count']; ?></td>
					<td><?php echo number_format((float)$sum['rf_total'], 2, '.', ''); ?></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	
	</div> <!-- End of container -->

</body>

<script src="js/sysfunc.js?v2"></script>
<script src="js/ajax.js"></script>
<script src="js/autocomplete.js"></script>

<script>

var invs = <?php echo json_encode($invs) ?>;
var sum = <?php echo json_encode($sum) ?>;
var company = <?php echo json_encode($myCompany) ?>;
var searchYear = <?php echo json_encode($year) ?>;
var searchMonth = <?php echo json_encode($month) ?>;

var searchQuarter;
var bLastInv = true, bInOut = true;

/****************************************************************************************************
	INIT
****************************************************************************************************/
$(document).ready(function(){
	document.getElementById("myTitle").innerText = "库存季报";
	searchQuarter = getQuarterByMonth(searchMonth);
	document.getElementById("btnQuarter").innerText = searchQuarter;

	loadPrintOption();
});

// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

/****************************************************************************************************
	TIME
****************************************************************************************************/
function selYear(e) {
	searchYear = $(e).text();
	document.getElementById("btnYear").innerText = searchYear;
	
	var url = "a_art_rpt_qt.php?year="+searchYear+"&month="+searchMonth;
	window.location.assign(url);
}

function selQuater(e) {
	searchQuarter = $(e).text();
	document.getElementById("btnQuarter").innerText = searchQuarter;
	searchMonth = getMonthByQuarter(searchQuarter);
	
	var url = "a_art_rpt_qt.php?year="+searchYear+"&month="+searchMonth;
	window.location.assign(url);
}

function getQuarterByMonth(month) {
	if (month >= 1 && month <= 3)
		return "第一季度";
	else if (month >= 4 && month <= 6)
		return "第二季度";
	else if (month >= 7 && month <= 9)
		return "第三季度";
	else
		return "第四季度";
}

function getMonthByQuarter(quarter) {
	if (quarter == "第一季度")
		return 3;
	else if (quarter == "第二季度")
		return 6;
	else if (quarter == "第三季度")
		return 9;
	else
		return 0;
}

/****************************************************************************************************
	PRINT OPTION
****************************************************************************************************/
function loadPrintOption() {
	var lastInv = localStorage.getItem("a_art_rpt_qt_lastinv"); 
	var inOut = localStorage.getItem("a_art_rpt_qt_inout"); 
	
	if (lastInv == null || lastInv == "1") {
		bLastInv = true;
	} else {
		bLastInv = false;
	}
	if (inOut == null || inOut == "1") {
		bInOut = true;
	} else {
		bInOut = false;
	}
	
	document.getElementById("chkLastInv").checked = bLastInv;
	document.getElementById("chkInOut").checked = bInOut;	
}

function clickLastInv() {
	bLastInv = !bLastInv;
	if (!bLastInv) {
		localStorage.setItem("a_art_rpt_qt_lastinv", "0");
	} else {
		localStorage.setItem("a_art_rpt_qt_lastinv", "1");
	}	
}

function clickInOut() {
	bInOut = !bInOut; 
	if (!bInOut) {
		localStorage.setItem("a_art_rpt_qt_inout", "0");
	} else {
		localStorage.setItem("a_art_rpt_qt_inout", "1");
	}	
}

/****************************************************************************************************
	EXPORT
****************************************************************************************************/
function exportFile() {
	var output = "Artikel Nr.,Beschreibung,";
	if (bLastInv) {
		output += "Menge Anfanglichen,";
	}
	output += "Menge Bestand,Durchschnittskosten,Wert Bestand";
	if (bInOut) {
		output += ",Menge Einahmen,Menge Ausgaben";
	}
	output += '\n';
	for (var i=0; i<invs.length; i++) {
		output += invs[i]['a_code']+',';
		output += invs[i]['a_name']+',';
		if (bLastInv) {
			output += invs[i]['last']+',';
		}
		output += invs[i]['count']+',';
		output += invs[i]['cost']+',';
		output += invs[i]['subtotal'];
		if (bInOut) {
			output += ',';
			output += invs[i]['in_count']+',';
			output += invs[i]['out_count'];
		}
		output += '\n';
	}
	
	var a = document.createElement("a");
	var file = new Blob([output], {type: 'text/plain'});
	var url = URL.createObjectURL(file);
	a.href = url;
	a.download = "bestand_"+searchMonth+"_"+searchYear+".csv";
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
	
	var src = "files/"+"<?php echo $_SESSION['uDb']; ?>"+"/logo.png";
	var output = '<html><head>';
	output += '<style type="text/css" media="print">';
	output += '.thCenter{border-left:1px solid; text-align:center;}';
	output += '.tdLeft{padding:1px; border-left:1px solid; border-top:1px solid; text-align:left;}';
	output += '.tdRight{padding:1px; border-left:1px solid; border-top:1px solid; text-align:right;}';
	output += '@page { size:auto; margin:0.8cm 0.8cm 0.8cm 1.5cm; }\</style>';	
	// Title
	output += '<table width="100%" cellpadding="5" cellspacing="0"><tr>';
	output += '<td align="center">';
	output += '<img height="100" style="object-fit: cover" src="'+src+'"></img>';
	output += '</td>';
	output += '<td align="left" style="border-left:1px solid; border-top:1px solid; border-right:1px solid">';
	output += '<a style="font-size:12px">'+searchMonth+"/"+searchYear+'&nbsp;Bestandssituation</a><br>';
	output += '<a style="font-size:12px">Alle Artikel</a><br>';
	output += '<a style="font-size:12px">Wert bei der Durchschnittskosten</a><br>';
	output += '</td>';
	output += '</tr></table>';
	// Articles
	output += '<table width="100%" cellpadding="2" cellspacing="0" style="border:1px solid;"><thead>';
	output += '<tr style="font-size:12px;">';
	output += '<th class="thCenter">Artikel Nr.</th>';
	output += '<th class="thCenter">Beschreibung</th>';
	if (bLastInv) {
		output += '<th class="thCenter">Menge<br>Anfanglichen</th>';
	}	
	output += '<th class="thCenter">Menge<br>Bestand</th>';
	output += '<th class="thCenter">Durchschnitts-<br>kosten</th>';
	output += '<th class="thCenter">Wert<br>Bestand</th>';
	if (bInOut) {
		output += '<th class="thCenter">Menge<br>Einahmen</th>';
		output += '<th class="thCenter">Menge<br>Ausgaben</th>';
	}
	output += '</tr></thead><tbody>';
	for (i=0; i<invs.length; i++) {
		var subTotal = parseFloat(invs[i]['cost'])*parseInt(invs[i]['count']);
		output += '<tr style="font-size:12px;">';
		output += '<td class="tdLeft">'+'&nbsp;'+invs[i]['a_code']+'</td>';
		output += '<td class="tdLeft">'+'&nbsp;'+invs[i]['a_name']+'</td>';
		if (bLastInv) {
			output += '<td class="tdRight">'+'&nbsp;'+invs[i]['last']+'</td>';
		}
		output += '<td class="tdRight">'+'&nbsp;'+invs[i]['count']+'</td>';
		output += '<td class="tdRight">'+'&nbsp;'+invs[i]['cost']+'</td>';
		output += '<td class="tdRight">'+'&nbsp;'+invs[i]['subtotal']+'</td>';
		if (bInOut) {
			output += '<td class="tdRight">'+'&nbsp;'+invs[i]['in_count']+'</td>';
			output += '<td class="tdRight">'+'&nbsp;'+invs[i]['out_count']+'</td>';
		}
		output += '</tr>';
	}
	output += '<tr style="font-size:12px;">';
	output += '<td class="tdRight" colspan="2">Total&nbsp;</td>';
	if (bLastInv) {
		output += '<td class="tdRight">'+'&nbsp;'+sum['last']+'</td>';
	}
	output += '<td class="tdRight">'+sum['count']+'</td>';
	output += '<td class="tdRight">'+''+'</td>';
	output += '<td class="tdRight">'+sum['subtotal']+'</td>';
	if (bInOut) {
		output += '<td class="tdRight">'+'&nbsp;'+sum['in_count']+'</td>';
		output += '<td class="tdRight">'+'&nbsp;'+sum['out_count']+'</td>';
	}
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
