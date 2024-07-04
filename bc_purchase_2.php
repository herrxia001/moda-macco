<?php
/************************************************************************************
	File:		bc_purchase.php
	Purpose:	print barcode from purchase
	2021-04-17: created file
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'resource.php';
include_once 'db_functions.php';

$thisResource = new myResource($_SESSION['uLanguage']);
$backPhp = "pur_mgt.php";
$myId = '';

// Start a new purchase
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if (isset($_GET['p_id']))
		$myId = $_GET['p_id'];
	else 
	{
		window.location.assign("pur_mgt.php");
		return;
	}
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header_bc.php' ?>
	<title>EUCWS-BARCODE</title>
</head>

<body>
	<form action="" method="post">

    <div class="container">
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8" align="right">			
				<a class="btn btn-secondary" onclick="window.history.go(-1); return false;" href="#" role="button"><?php echo $thisResource->bcBack ?></a>
			</div>
		</div>
		
		<div class="row">	
<!-- purchase table -->				
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<table id="tablePurchase" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true" data-height="300">
					<thead class="thead-light">
						<tr>
						<th data-field="id" data-visible="false"></th>
						<th data-field="idx_image" data-width="20" data-width-unit="%"></th>
						<th data-field="idx_data" data-width="40" data-width-unit="%" data-sortable="true"><?php echo $thisResource->bcCapCode ?></th>
						<th data-field="idx_count" data-width="20" data-width-unit="%" data-sortable="true"><?php echo $thisResource->bcListCount ?></th>	
						<th data-field="idx_subtotal" data-width="20" data-width-unit="%" data-sortable="true"><?php echo $thisResource->bcListValue ?></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>		
		</div>

		<div class="row">
<!-- print fields -->		
		<div class="col-6 col-sm-6 col-md-6 col-lg-4">
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapCode ?></span></div>	
				<input type="text" class="form-control" name="i_code" id="i_code" style="background-color:white" readonly>		
			</div>	
		</div>
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapUnits ?></span></div>	
				<input type="text" class="form-control" name="units" id="units" style="background-color:white" readonly>		
			</div>	
		</div>
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapVariant ?></span></div>	
				<input type="text" class="form-control" name="i_variant" id="i_variant" style="background-color:white" readonly>		
			</div>	
		</div>
		<div class="row">
			<div class="input-group p-1">		
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapAmount ?></span></div>
				<input type="text" class="form-control" name="count" id="count" style="background-color:white" readonly>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapBarcode ?></span></div>
				<input type="text" class="form-control" name="code1" id="code1" style="background-color:white" readonly>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapCopy ?></span></div>
				<input type="number" min="1" step="1" class="form-control" name="bc_amount" id="bc_amount">
				<button type="button" id="btnPrint" name="btnPrint" class="ml-1 btn btn-primary" onclick="printBarcode()"><?php echo $thisResource->bcPrint ?></button>
			</div>
		</div>
		</div>
<!-- variants -->		
		<div class="col-6 col-sm-6 col-md-6 col-lg-4">
			<table id="tableVariant" class="p-1 ml-2 table-sm" data-toggle="table" data-click-to-select="true" data-single-select="true" data-height="300">
				<thead>
					<tr>
					<th data-field="state" data-checkbox="true"></th>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>
					<th data-field="idx_variant" data-width="70" data-width-unit="%" data-halign="center" data-align="left"><?php echo $thisResource->bcCapVariant ?></th>				
					<th data-field="idx_amount" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->bcCapAmount ?></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<br>
			<button type="button" id="btnPrintAll" name="btnPrintAll" class="btn btn-success" onclick="printAll()"><?php echo $thisResource->bcPrintAll ?></button>
		</div>
		
		</div>
	</div>
	
	</form>

<script src="js/ajax.js"></script>
<script src="js/barcodeOption.js?202108111005"></script>

<script>
// Purchase
pId = "<?php echo $myId ?>";
var pur = {};
var purItems = new Array(), itemCount = 0;
var thisItem = {};
var purVariant = new Array(), variantCount = 0;
var thisVariant = {};
// Variant
var $tableVariant = $('#tableVariant');
var myVariants = null;
document.getElementById("tableVariant").style.display = "none";
document.getElementById("btnPrintAll").style.display = "none";
// Option
var option = JSON.parse(localStorage.getItem("barcodePrint"));
if (option == null) {
	option = new Object();
	option['barcode'] = true;
	option['artno'] = true;
	option['variant'] = true;
}

// Table Purchase
var $tablePurchase = $('#tablePurchase');
$tablePurchase.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
/************************************************************************
	LOAD Purchase
************************************************************************/
$(document).ready(function(){	
	// Load purItems
	getRequest("getPurById.php?p_id="+pId, loadPur, loadError);	
	getRequest("getPurItemsById.php?p_id="+pId, loadPurItems, loadError);
	getRequest("getPurVariantById.php?p_id="+pId, loadPurVariantYes, loadPurVariantNo);		
});
// Load purchase
function loadPur(result) {
	pur = result;
}
function loadError(result) {

}
// Load purItems
function loadPurItems(result) {
	purItems = result;
	itemCount = purItems.length;
	
	$tablePurchase.bootstrapTable('removeAll');
	var rows = [];
	var dataStr, imgSrc, imgStr, countStr;
	for (var i=0; i<itemCount; i++) {
		purItems[i]['id'] = i;
		if (purItems[i]['i_name'] != null)
			dataStr = "<a style='font-weight:bold;'>"+purItems[i]['i_code']+"</a><br>"+"<a >"+purItems[i]['i_name']+"</a>";
		else
			dataStr = "<a style='font-weight:bold;'>"+purItems[i]['i_code']+"</a>";
		imgSrc = purItems[i]['path']+"/"+purItems[i]['i_id']+"_"+purItems[i]['m_no']+"_s.jpg";
		imgStr = "<img width='40' height='60' style='border:1px dotted; object-fit: cover' src='"+imgSrc+"' >";
		if (purItems[i]['unit'] == "1") {
			countStr = purItems[i]['count'];
			purItems[i]['real_count'] = purItems[i]['count'];
		} else {
			countStr = purItems[i]['count']+" (x"+purItems[i]['unit']+")";
			purItems[i]['real_count'] = (parseInt(purItems[i]['count'])*parseInt(purItems[i]['unit'])).toString();
		}
		subtotal = parseInt(purItems[i]['real_count'])*parseFloat(purItems[i]['cost']);
		purItems[i]['subtotal'] = subtotal.toFixed(2);
		rows.push({
			id: i,
			idx_image: imgStr,
			idx_data: dataStr,
			idx_count: countStr,
			idx_subtotal: purItems[i]['subtotal']
		});	
	}
	$tablePurchase.bootstrapTable('append', rows);
}
// Load purVariant
function loadPurVariantYes(result) {
	purVariant = new Array();
	variantCount = 0;
	var newVariant = null, newVariantCount = 0;
	var lastIid = "";
	for (var i=0; i<result.length; i++) {
		if (lastIid != result[i]['i_id']) {
			lastIid = result[i]['i_id'];
			if (newVariant != null) {
				purVariant[variantCount] = newVariant;
				variantCount++;
			}
			newVariant = new Array();
			newVariantCount = 0;
		}
		newVariant[newVariantCount] = result[i];
		newVariantCount++;
	}
	purVariant[variantCount] = newVariant;
	variantCount++;
}
function loadPurVariantNo(result) {
	
}
/************************************************************************
	SELECT ITEM 
************************************************************************/
// Find purItems item by searching id
function getItemIndexById(id) {
	for (var i=0; i<itemCount; i++) {
		if (purItems[i]['id'] == id)
			return i;
	}	
	return -1;
}
// Find variant in purVariant by i_id
function getVariantIndexById(id) {
	for (var i=0; i<variantCount; i++) {
		if (purVariant[i][0]['i_id'] == id)
			return i;
	}	
	return -1;
}
// Select item
$tablePurchase.on('click-row.bs.table', function (e, row, $element) {
	var index = getItemIndexById(row.id);
	if (index < 0)
		return;	
	thisItem = purItems[index];
	// check variant
	var v_idx = getVariantIndexById(thisItem['i_id']);
	if (v_idx >= 0) {
		myVariants = purVariant[v_idx];
		document.getElementById("tableVariant").style.display = "block";
		document.getElementById("btnPrintAll").style.display = "block";
		showVariant();
	} else {
		myVariants = null;
		document.getElementById("tableVariant").style.display = "none";
		document.getElementById("btnPrintAll").style.display = "none";
		showFields(0);
	}
});
// Show print fields
function showFields(option) {
	document.getElementById("i_code").value = thisItem['i_code'];
	// unit
	if (thisItem['unit'] == "1") {
		document.getElementById("units").value = "件 (x1)";	
	} else {
		document.getElementById("units").value = "包 (x"+thisItem['unit']+")";	
	}
	if (option == 1) {
		// variant
		document.getElementById("i_variant").value = thisVariant['variant'];
		document.getElementById("count").value = thisVariant['count'];
		document.getElementById("code1").value = thisVariant['barcode'];
		document.getElementById("bc_amount").value = thisVariant['count'];
		
	} else {
		// no variant
		document.getElementById("i_variant").value = "";
		document.getElementById("count").value = thisItem['count'];
		document.getElementById("code1").value = thisItem['code1'];
		document.getElementById("bc_amount").value = thisItem['count'];
	}		
}
/************************************************************************************
	VARIANT
************************************************************************************/
var selVariantRow = -1;

function getVariantSeqById(id) {
	for (var i=0; i<myVariants.length; i++){
		if (myVariants[i]['iv_id'] == id)
			return i;
	}
	return -1;
}
$tableVariant.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
function showVariant() {
	$tableVariant.bootstrapTable('removeAll');
	var rows = [];
	for (var i=0; i<myVariants.length; i++){
		rows.push({
			id: myVariants[i]['iv_id'],
			idx_variant: myVariants[i]['variant'],
			idx_amount: myVariants[i]['count']
		});
	}
	$tableVariant.bootstrapTable('append', rows);
	
	$tableVariant.bootstrapTable('check', 0);
	selVariantRow = 0;
	thisVariant = myVariants[selVariantRow];
	showFields(1);	
}
$tableVariant.on('click-row.bs.table', function (e, row, $element) {
	if (selVariantRow >= 0) {
		$tableVariant.bootstrapTable('uncheck', selVariantRow);
		selVariantRow = getVariantSeqById(row.id);
		thisVariant = myVariants[selVariantRow];
	}
	showFields(1);	
});
/************************************************************************************
	PRINT
************************************************************************************/
function printBarcode() {
	// get data
	var code1 = document.getElementById('code1').value;
	var i_code = document.getElementById('i_code').value;
	var i_variant = document.getElementById('i_variant').value;
	if (code1 == "" || i_code == "")
		return;
	//if (myVariants != null && option['variant'] && !option['colorSecond'])
	//	i_code += "    "+i_variant;
	var bc_amount = document.getElementById('bc_amount').value;
	// numbers
	/*var paperSize = "SIZE "+option['paperWidth']+" mm, "+option['paperHeight']+" mm";
	if (option['paperWidth'] == 40)
		paperMargin = 30;
	else
		paperMargin = 50;*/
	// print
	/*var TSCObj;
	TSCObj = new ActiveXObject("TSCActiveX.TSCLIB");
	TSCObj.ActiveXopenport("TSC TDP-225");
	TSCObj.ActiveXsendcommand(paperSize);
	TSCObj.ActiveXsendcommand("SPEED 4");
	TSCObj.ActiveXsendcommand("DENSITY 12");
	TSCObj.ActiveXsendcommand("DIRECTION 1");
	TSCObj.ActiveXsendcommand("SET TEAR ON");
	TSCObj.ActiveXclearbuffer();*/
	
	//if (i_code.match(/[\u3400-\u9FBF]/))
	//	TSCObj.ActiveXwindowsfont(paperMargin.toString(), "20", option['fontSize'].toString(), "0", "0", "0", "宋体", i_code);
	//else
	//	TSCObj.ActiveXwindowsfont(paperMargin.toString(), "20", option['fontSize'].toString(), "0", "0", "0", "arial", i_code);
	//if (option['colorSecond'] && myVariants != null) {
	//	if (i_variant.match(/[\u3400-\u9FBF]/))
	//		TSCObj.ActiveXwindowsfont(paperMargin.toString(), "45", option['fontSize'].toString(), "0", "0", "0", "宋体", i_variant);
	//	else
	//		TSCObj.ActiveXwindowsfont(paperMargin.toString(), "45", option['fontSize'].toString(), "0", "0", "0", "arial", i_variant);
	//}
	//TSCObj.ActiveXbarcode(paperMargin.toString(), "85", "128", option['codeHeight'].toString(), "1", "0", option['codeWidth'].toString(), option['codeWidth'].toString(), code1);
	//TSCObj.ActiveXprintlabel("1", bc_amount);
	//TSCObj.ActiveXcloseport();


	var form = new FormData();
	form.append('i_code', i_code);
	form.append('code', code1);
	form.append('amount', bc_amount);
	form.append('variant', i_variant);
	postRequest('postInvPrint.php', form, mdprintDbYes, mdprintDbNo);

}


function mdprintDbYes(result) {	
    alert("已经添加到打印列表!");
}
function mdprintDbNo(result) {	
	alert("请重新登入!");
}
//var all_st = false;
function mdprintDbYes_leise(result) {	
	//all_st = true;
}
function mdprintDbNo_leise(result) {	
	//all_st = false;
}
function printDone(result){
	alert("已经添加到打印列表!");
	window.history.go(-1); 
	return false;
}

function printAll() {
	// get data
	var totalCount = 0;
	for (var i=0; i<myVariants.length; i++) {
		totalCount += parseInt(myVariants[i]['count']);
	}
	if (!confirm(totalCount+" 个条码需要打印。选择继续?"))
		return;

/*		var link = "postPurPrint.php";
		var pur = {};
		pur['p_id'] = pId;
	var form = new FormData();
	form.append('pur', JSON.stringify(pur));
	postRequest(link, form, printDone, mdprintDbNo);*/
		


	// numbers
	var paperSize = "SIZE "+option['paperWidth']+" mm, "+option['paperHeight']+" mm";
	if (option['paperWidth'] == 40)
		paperMargin = 30;
	else
		paperMargin = 50;
	// print
	var i_code = document.getElementById('i_code').value;
	/*var TSCObj;
	TSCObj = new ActiveXObject("TSCActiveX.TSCLIB");
	TSCObj.ActiveXopenport("TSC TDP-225");
	TSCObj.ActiveXsendcommand(paperSize);
	TSCObj.ActiveXsendcommand("SPEED 4");
	TSCObj.ActiveXsendcommand("DENSITY 12");
	TSCObj.ActiveXsendcommand("DIRECTION 1");
	TSCObj.ActiveXsendcommand("SET TEAR ON");*/

	for (var i=0; i<myVariants.length; i++) {
		if (myVariants[i]['count'] <= 0)
			continue;
		var code = i_code;
		//if (option['variant'] && !option['colorSecond'])
		//	code += "    "+myVariants[i]['variant'];
		var code1 = myVariants[i]['barcode'];
		var bc_amount = myVariants[i]['count'];
		/*TSCObj.ActiveXclearbuffer();
		if (code.match(/[\u3400-\u9FBF]/))
			TSCObj.ActiveXwindowsfont(paperMargin.toString(), "20", option['fontSize'].toString(), "0", "0", "0", "宋体", code);
		else
			TSCObj.ActiveXwindowsfont(paperMargin.toString(), "20", option['fontSize'].toString(), "0", "0", "0", "arial", code);
		if (option['colorSecond'] && myVariants != null) {
			if (myVariants[i]['variant'].match(/[\u3400-\u9FBF]/))
				TSCObj.ActiveXwindowsfont(paperMargin.toString(), "45", option['fontSize'].toString(), "0", "0", "0", "宋体", myVariants[i]['variant']);
			else
				TSCObj.ActiveXwindowsfont(paperMargin.toString(), "45", option['fontSize'].toString(), "0", "0", "0", "arial", myVariants[i]['variant']);
		}
		TSCObj.ActiveXbarcode(paperMargin.toString(), "85", "128", option['codeHeight'].toString(), "1", "0", option['codeWidth'].toString(), option['codeWidth'].toString(), code1);
		TSCObj.ActiveXprintlabel("1", bc_amount);*/



		var form = new FormData();
		form.append('i_code', code);
		form.append('code', code1);
		form.append('amount', bc_amount);
		form.append('variant', myVariants[i]['variant']);
		postRequest('postInvPrint.php', form, mdprintDbYes_leise, mdprintDbNo_leise);
	
	}
	alert("已经添加到打印列表!");
	//TSCObj.ActiveXcloseport();
}

</script>

</body>
</html>
