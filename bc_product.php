<?php
/************************************************************************************
	File:		bc_product.php
	Purpose:	print barcode from inventory
	2021-03-15: created file
	2021-04-14: use TSC TDP-225
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:bc_index.php");

include_once 'resource.php';
include_once 'db_functions.php';

$thisResource = new myResource($_SESSION['uLanguage']);
$backPhp = "bc_home.php";

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
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">			
				<button type="button" id="btnClear" name="btnClear" class="btn btn-secondary" onclick="clearFields()"><?php echo $thisResource->bcClear ?></button>
				<a class="btn btn-secondary" href=<?php echo $backPhp ?> role="button"><?php echo $thisResource->bcBack ?></a>
			</div>
		</div>
		<div class="row">
		
		<div class="col-lg-4">
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapCode ?></span></div>	
				<input type="text" class="form-control" name="i_code" id="i_code" autofocus>		
			</div>	
		</div>
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapVariant ?></span></div>	
				<input type="text" class="form-control" name="i_variant" id="i_variant" readonly>		
			</div>	
		</div>
		<div class="row">
			<div class="input-group p-1">		
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapCount ?></span></div>
				<input type="text" class="form-control" name="count" id="count" readonly>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCapBarcode ?></span></div>
				<input type="text" class="form-control" name="code1" id="code1" readonly>
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
		
		<div class="col-lg-4">
		<div class="row">
			<div class="p-1">
				<table id="tableVariant" class="table-sm" data-toggle="table" data-click-to-select="true" data-single-select="true" data-height="300">
				<thead>
					<tr>
					<th data-field="state" data-checkbox="true"></th>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>
					<th data-field="idx_variant" data-width="70" data-width-unit="%" data-halign="center" data-align="left"><?php echo $thisResource->bcCapVariant ?></th>				
					<th data-field="idx_amount" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->bcCapCount ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
			</div>
		</div>
		</div>
		
		</div>
	</div>
	
	</form>

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?202109132235"></script>
<script src="js/barcodeOption.js?202108111005"></script>
<script>

// Load data
var invs;
var bc_icode = JSON.parse(localStorage.getItem("bc_icode"));
var bc_image = JSON.parse(localStorage.getItem("bc_image"));
// Variant
var $tableVariant = $('#tableVariant');
var myVariants = null;

// Display Title
$(document).ready(function(){
	 // hide variant table
	 document.getElementById("tableVariant").style.display = "none";
	 // Load data for autocomplete 
	autocomplete_like(document.getElementById("i_code"), bc_icode, bc_image);
 });

/************************************************************************************
	SEARCH
************************************************************************************/
// Prevent 'enter" key to submit
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        searchInv();
		return;
    }
});
function searchInv() {
	var code = document.getElementById("i_code").value;
	if (code == "")
		return false;	
	var link = "getInvByCode.php?code="+code;
	getRequest(link, searchCodeYes, searchCodeNo);
}
// This is a callback for autocomplete
function doneAutocomp() {
	searchInv();
}
// Result back
function searchCodeYes(invs) {
	var inv = invs[0];
	
	document.getElementById("i_code").readOnly = true;
	document.getElementById("code1").value = inv['code1'];
	document.getElementById("count").value = inv['count'];
	$('#bc_amount').focus();
	
	getRequest("getVariant.php?i_id="+inv['i_id'], searchVariantYes, searchVariantNo);	
}
// Error or no found
function searchCodeNo(invs) {
	alert("没有找到该货品");
	clearFields();
	$('#i_code').focus();
}
// Variant
function searchVariantYes(result) {
	document.getElementById("tableVariant").style.display = "block";
	myVariants = result;
	
	$tableVariant.bootstrapTable('removeAll');
	var rows = [];
	for (var i=0; i<myVariants.length; i++){
		rows.push({
			id: myVariants[i]['iv_id'],
			idx_variant: myVariants[i]['variant'],
			idx_amount: myVariants[i]['amount']
		});
	}
	$tableVariant.bootstrapTable('append', rows);
	
	$tableVariant.bootstrapTable('check', 0);
	selVariantRow = 0;
	showVariant();	
}
function searchVariantNo(result) {
	document.getElementById("i_variant").readOnly = true;
	document.getElementById("tableVariant").style.display = "none";
	myVariants = null;
}	
/************************************************************************************
	Variant
************************************************************************************/
var selVariantRow = -1;

$tableVariant.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
$tableVariant.on('click-row.bs.table', function (e, row, $element) { 
	if (selVariantRow >= 0) { 
		$tableVariant.bootstrapTable('uncheck', selVariantRow);
		selVariantRow = getVariantSeqById(row.id); 
	}
	showVariant();	
});
function showVariant() {
	document.getElementById('i_variant').value = myVariants[selVariantRow]['variant'];
	document.getElementById('code1').value = myVariants[selVariantRow]['barcode'];
	document.getElementById('count').value = myVariants[selVariantRow]['amount'];
	document.getElementById('bc_amount').value = "";
	$('#bc_amount').focus();
}
function getVariantSeqById(id) {
	for (var i=0; i<myVariants.length; i++){
		if (myVariants[i]['iv_id'] == id)
			return i;
	}
	return -1;
}
/************************************************************************************
	Clear
************************************************************************************/
function clearFields() {
	document.getElementById("i_code").readOnly = false;
	document.getElementById("i_code").value = "";
	document.getElementById("code1").value = "";
	document.getElementById("i_variant").value = "";
	document.getElementById("count").value = "";
	document.getElementById("bc_amount").value = "";
	document.getElementById("tableVariant").style.display = "none";
	$tableVariant.bootstrapTable('removeAll');
	myVariants = null;
	$('#i_code').focus();
}
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
	if (myVariants != null && option['variant'] && !option['colorSecond'])
		i_code += "    "+i_variant;
	var bc_amount = document.getElementById('bc_amount').value;
	// numbers
	var paperSize = "SIZE "+option['paperWidth']+" mm, "+option['paperHeight']+" mm";
	if (option['paperWidth'] == 40)
		paperMargin = 30;
	else
		paperMargin = 50;
	// print
	var TSCObj;
	TSCObj = new ActiveXObject("TSCActiveX.TSCLIB");
	TSCObj.ActiveXopenport("TSC TDP-225");
	TSCObj.ActiveXsendcommand(paperSize);
	TSCObj.ActiveXsendcommand("SPEED 4");
	TSCObj.ActiveXsendcommand("DENSITY 12");
	TSCObj.ActiveXsendcommand("DIRECTION 1");
	TSCObj.ActiveXsendcommand("SET TEAR ON");
	TSCObj.ActiveXclearbuffer();

	if (i_code.match(/[\u3400-\u9FBF]/))
		TSCObj.ActiveXwindowsfont(paperMargin.toString(), "20", option['fontSize'].toString(), "0", "0", "0", "宋体", i_code);
	else
		TSCObj.ActiveXwindowsfont(paperMargin.toString(), "20", option['fontSize'].toString(), "0", "0", "0", "arial", i_code);
	if (option['colorSecond'] && myVariants != null) {
		if (i_variant.match(/[\u3400-\u9FBF]/))
			TSCObj.ActiveXwindowsfont(paperMargin.toString(), "45", option['fontSize'].toString(), "0", "0", "0", "宋体", i_variant);
		else
			TSCObj.ActiveXwindowsfont(paperMargin.toString(), "45", option['fontSize'].toString(), "0", "0", "0", "arial", i_variant);
	}
	TSCObj.ActiveXbarcode(paperMargin.toString(), "85", "128", option['codeHeight'].toString(), "1", "0", option['codeWidth'].toString(), option['codeWidth'].toString(), code1);
	TSCObj.ActiveXprintlabel("1", bc_amount);
	TSCObj.ActiveXcloseport();
}

</script>

</body>
</html>
