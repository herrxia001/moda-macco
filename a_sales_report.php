<?php
/************************************************************************************
	File:		sales_report.php
	Purpose:	Reports
************************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include 'db_functions.php';
include 'db_invoice.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

$myTypes = dbQueryTypesInvoice();

if (isset($_GET['country'])){
	$country = $_GET['country'];
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Report</title>
</head>
<style>
body {
	font-size: 14px;
}
thead th {
	font-size: 14px;
	padding: 1px !important;
}
tbody td {
	font-size: 14px;
	padding: 1px !important;
}
#modalSalesDetailsCust {
	z-index:9999;
}
#modalOrder {
	z-index:10000;
}
</style>
<body>
	<?php include 'include/a_nav.php' ?>	
	<?php include "include/modalSelTime.php" ?>
		

<div class="container">	
<!-- tab content -->
	<div class="tab-content">
		
<!-- typeTab -->	
	<div class="tab-pane active" id="typeTab">
	<!-- options -->
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4">	
			<button type="button" class="ml-1 btn btn-outline-secondary" id="selTimeType" onclick="selectTime()" style="font-size:14px"></button>
		</div>

		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4" style="justify-content: flex-end;">
			<input type="text" class="form-control ml-2" style="max-width: 150px;" name="country" id="country" value="<?php if($country == "") echo '所有国家'; else echo $country; ?>" readonly>
				<div class="dropdown dropleft">
					<button type="button" class="btn btn-secondary dropdown-toggle ml-2" data-toggle="dropdown" aria-expanded="false">更改国家</button>
					<ul class="dropdown-menu" style="">
						<li><a class="dropdown-item" href="#" onclick="changeCountry('')">所有国家</a></li>
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

            <button type="button" class="btn btn-secondary ml-1" id="btnPrint" onclick="printFile()"><span class='fa fa-print'></button>
		</div>
	</div>
	<!-- summary -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<table id="tableTypeSum" class="table-sm" data-toggle="table">
				<thead class="thead-light">
					<tr>				
					<th data-field="idx_types" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comType ?></th>
					<th data-field="idx_count" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProCountTotal ?></th>
					<th data-field="idx_price" data-width="40" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProValueTotal ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>		
	</div>
	<!-- Search result table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
			<table id="tableType" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">
				<thead class="thead-light">
					<tr>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>				
					<th data-field="idx_type" data-width="40" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comType ?></th>
					<th data-field="idx_tcount" data-width="20" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->rptProInventory ?></th>
					<th data-field="idx_count" data-width="20" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->rptProSales ?></th>
					<th data-field="idx_price" data-width="20" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->rptProValue ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>
	</div>
	</div> <!-- End of typeTab -->		

</div> <!-- End of container -->

</body>

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?202108130959"></script>
<script src="js/modalSelTime.js?v1"></script>

<script>
var myRes = <?php echo json_encode($thisResource) ?>;
// Type
var types = new Array(), typesCount = 0;
var typeCountTotal = 0, typePriceTotal = 0;
var $tableType = $("#tableType");
var typeSearched = false;
var timeType = "timeThisMonth";
var typeSales = new Array();

var sortCol = "price_sum", sortOp = 1;

/* Load document */
$(document).ready(function(){	
	searchReportType();
 });

/* Prevent 'enter' key for submission, only enabled for barcode input */
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

// Load types
var a_types = <?php echo json_encode($myTypes) ?>;
function getTypeNameById(aid) {
	for (var i=0; i<a_types.length; i++) {
		if (a_types[i]['a_id'] == aid)
			return a_types[i]['a_name'];
	}
	return "未分类";
}

/*************************************************** 
	TYPE TAB 
****************************************************/
var country = "<?= $country ?>";
$tableType.bootstrapTable({   
	formatNoMatches: function () {
         return "没有符合条件的数据";
    }
});
function changeCountry(cty){
    country = cty;
	if(cty == "") $("#country").val("所有国家");
    else $("#country").val(country);
    searchReportType();
}
function searchReportType(){	
	getRequest("getSalesReportByTypeCountInvoice.php", afterSearchTypeCount, afterSearchTypeCountNo);
}
function afterSearchTypeCount(result){
	typeSearched = true;
	types = result;
	typesCount = types.length;
	
	timeType = mdstGetChecked();
	var timeStr = mdstGetStr();	
	document.getElementById("selTimeType").innerText = timeStr;	
	var timeResult = mdstGetValue();
	
	link = "getSalesReportByTypeInvoice.php?"+timeResult+"&country="+country;	
	getRequest(link, afterSearchType, afterSearchTypeNo);
}
function afterSearchTypeCountNo(result){
	typeSearched = false;
	types = null;
	typesCount = 0;
	typeCountTotal = 0;
	typePriceTotal = 0;
	displayTypeSum();
}
function afterSearchType(result){
	typeSearched = true;
	typeSales = result;
	loadTableType();
}
function afterSearchTypeNo(result) {
	$tableType.bootstrapTable('removeAll');
	types = null;
	typesCount = 0;
	typeCountTotal = 0;
	typePriceTotal = 0;
	displayTypeSum();
}
function loadTableType(){
	typeCountTotal = 0;
	typePriceTotal = 0;
	if (typeSales.length <= 0) {
		displayTypeSum();
		return;
	}	
	$tableType.bootstrapTable('removeAll');
	types.sort(sortTable(sortCol, sortOp));
	var rows = [];
	for(var i=0; i<typesCount; i++){
		types[i]['a_name'] = getTypeNameById(types[i]['a_id']);
		var count = "0";
		var price = "0.00";
		for ( var j=0; j<typeSales.length; j++) {
			if (typeSales[j]['a_id'] == types[i]['a_id']) {
				count = typeSales[j]['count_sum'];
				price = typeSales[j]['price_sum'];
				break;
			}
		}
		if(price > 0){
			rows.push({
				id: types[i]['a_id'],
				idx_type: types[i]['a_name'],
				idx_tcount: types[i]['tcount'],
				idx_count: count,
				idx_price: parseFloat(price).toFixed(2)
			});
		}
		typeCountTotal += parseInt(count);
		typePriceTotal += parseFloat(price);
	}
	$tableType.bootstrapTable('append', rows);
    $tableType.find("thead th:first-child() .sortable").click();
	displayTypeSum();
}
function displayTypeSum(){
	$tableTypeSum = $('#tableTypeSum');
	$tableTypeSum.bootstrapTable('removeAll');
	var rows = [];
	rows.push({
		idx_types: typesCount,
		idx_count: typeCountTotal.toString(),
		idx_price: typePriceTotal.toFixed(2)
	});
	$tableTypeSum.bootstrapTable('append', rows);	
}
/* Sort table */
function sortTable(key, option){
    return function(a, b){ 
		var x = a[key]; var y = b[key];
if (key == "count" || key == "count_sum" || key == "in_count" || key == "out_count" || key == "real_count" || key == "real_count_sum") {
			x= parseInt(x); y = parseInt(y);
		}
		if (key == "price_sum" || key == "cost_sum" || key == "profit_rate") {
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
/* Show time selection (modalTime) */
function selectTime(){
	$modalSelTime.modal();	
}
function mdstDoneTime(){
    $modalSelTime.modal("toggle");
	searchReportType();
}
/* Print report */
function printReport() {
	
}

/****************************************************************************************************
 PRINT
 ****************************************************************************************************/
function printFile() {
    var timestr = mdstGetValue();
    var from_time = timestr.substring(9, 19);
    from_time = from_time.substring(8)+"/"+from_time.substring(5,7)+"/"+from_time.substring(0,4);
    var to_time = timestr.substring(27);
    to_time = to_time.substring(8)+"/"+to_time.substring(5,7)+"/"+to_time.substring(0,4);
    var dt = from_time;
    if(dt != to_time) dt += " bis "+to_time;

    var company = <?php echo json_encode(dbQueryCompany()) ?>;

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
    output += '<a style="font-size:12px">'+dt+'&nbsp;'+country+'</a><br>';
    output += '</td>';
    output += '</tr></table>';
    // Articles
    output += '<table width="100%" cellpadding="2" cellspacing="0" style="border:1px solid;"><thead>';
    output += '<tr style="font-size:12px;">';
    output += '<th class="thCenter">Beschreibung</th>';
    output += '<th class="thCenter">Menge<br>Bestand</th>';
    output += '<th class="thCenter">Verkauf Menge<br>Bestand</th>';
    output += '<th class="thCenter">Wert<br>Bestand</th>';
    output += '</tr></thead><tbody>';
    $('#tableType tbody tr').each(function() {
        var val_1 = $(this).children('td').eq(0).html();
        if(val_1 == "未分类") val_1 = "Nicht kategorisiert";
        output += '<tr style="font-size:12px;">';
        output += '<td class="tdLeft">'+'&nbsp;'+val_1+'</td>';
        output += '<td class="tdRight">'+'&nbsp;'+$(this).children('td').eq(1).html()+'</td>';
        output += '<td class="tdRight">'+'&nbsp;'+$(this).children('td').eq(2).html()+'</td>';
        output += '<td class="tdRight">'+'&nbsp;'+$(this).children('td').eq(3).html()+'</td>';
        output += '</tr>';
        //test
    });
    output += '<tr style="font-size:12px;">';
    output += '<td class="tdRight" colspan="2">Total&nbsp;</td>';
    output += '<td class="tdRight">'+$("#tableTypeSum td:nth-child(2)").text()+'</td>';
    output += '<td class="tdRight">'+$("#tableTypeSum td:nth-child(3)").text()+'</td>';
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
