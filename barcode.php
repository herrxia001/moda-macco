<?php
/************************************************************************************
	File:		barcode.php
	Purpose:	print barcode
	2021-03-15: created file
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'resource.php';
include_once 'db_functions.php';

$backPhp = "home.php";
if(isset($_GET['back']))
	$backPhp = $_GET['back'].'.php';
	
$labelFile = file_get_contents("barcode.label");

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Barcode</title>
</head>

<body>
	<?php include 'include/nav.php' ?>
	
	<form action="" method="post">

    <div class="container">
		<div class="row">
			<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" align="left">
				<a class="btn btn-secondary" href=<?php echo $backPhp ?> role="button"><span class='fa fa-arrow-left'></a>		
			</div>
			<div class="p-1 col-4 col-sm-4 col-md-4 col-lg-3" align="center">
				<a>请输入货号</a>		
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3" align="right">
				<button type="button" id="btnOption" name="btnOption" class="btn btn-secondary" onclick="showOption()">条码选项</button>			
				<button type="button" id="btnClear" name="btnClear" class="btn btn-secondary" onclick="clearFields()">重新输入</button>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<div class="input-group-prepend"><span class="input-group-text">货号</span></div>
				<input type="text" class="form-control" name="i_code" id="i_code" autofocus>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<div class="input-group-prepend"><span class="input-group-text">库存</span></div>
				<input type="text" class="form-control" name="count" id="count" style="background-color:white" readonly>
				<div class="ml-1 input-group-prepend"><span class="input-group-text">售价</span></div>
				<input type="text" class="form-control" name="price" id="price" style="background-color:white" readonly>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<table id="tableVariant" class="table-sm" data-toggle="table" data-click-to-select="true" data-single-select="true">
				<thead>
					<tr>
					<th data-field="state" data-checkbox="true"></th>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>
					<th data-field="idx_variant" data-width="70" data-width-unit="%" data-halign="center" data-align="left">款色</th>				
					<th data-field="idx_amount" data-width="30" data-width-unit="%" data-halign="center" data-align="right">库存</th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<div class="input-group-prepend"><span class="input-group-text">条码</span></div>
				<input type="text" class="form-control" name="code1" id="code1" style="background-color:white" readonly>				
				<div class="ml-1 input-group-prepend"><span class="input-group-text">数量</span></div>
				<input type="number" min="1" step="1" class="form-control" name="bc_amount" id="bc_amount">
				<button type="button" id="btnPrint" name="btnPrint" class="ml-1 btn btn-primary" onclick="printBarcode()">打印</button>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-8">				
				<img id="barcodeImg"/ hidden>
			</div>
		</div>
	</div>
	
	</form>
	
<!-- Modal Barcode Option -->	
<div class="modal fade" id="modalBcOption" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">条码打印选项</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdbcBarcode" value="">打印条码 
				</label>
			</div>
			<div class="mt-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdbcArtNo" value="">打印货号 Art. No.
				</label>
			</div>
			<div class="mt-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdbcVariant" value="">打印款色
				</label>
			</div>
			<div class="mt-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdbcPrice" value="">打印售价
				</label>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="mdbcSave()"><span class='fa fa-check'></button>
			</div>
		</div>
	</div>
</div> <!-- End of Modal Barcode Option -->
			
</body>

<!-- DYMO barcode printer -->
<script src = "http://www.labelwriter.com/software/dls/sdk/js/DYMO.Label.Framework.3.0.js" type="text/javascript" charset="UTF-8"> </script>
<!-- barcode generator -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/barcodes/JsBarcode.code128.min.js"></script>
<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?202102101708"></script>
<script>

// Lable file
var labelFile = <?php echo json_encode($labelFile) ?>;
if (!labelFile) {
	alert("读取条码文件barcode.label错误");
	window.location.assign("home.php");
}
// Load data
var invs;
var a_icode = JSON.parse(localStorage.getItem("a_icode"));
var a_image = JSON.parse(localStorage.getItem("a_image"));
// Variant
var $tableVariant = $('#tableVariant');
var myVariants = null;
// Option
var $modalBcOption = $('#modalBcOption');
var option = JSON.parse(localStorage.getItem("barcodePrint"));
if (option == null) {
	option = new Object();
	option['barcode'] = true;
	option['artno'] = true;
	option['variant'] = true;
	option['price'] = false;
}

// Display Title
$(document).ready(function(){
	 document.getElementById("myTitle").innerHTML = "条码打印";
	 // hide variant table
	 document.getElementById("tableVariant").style.display = "none";
	 // Load data for autocomplete 
	autocomplete(document.getElementById("i_code"), a_icode, a_image);
 });

/************************************************************************************
	SEARCH
************************************************************************************/
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
	
	document.getElementById("code1").value = inv['code1'];
	document.getElementById("count").value = inv['count'];
	document.getElementById("price").value = inv['price'];
	$('#bc_amount').focus();
	
	getRequest("getVariant.php?i_id="+inv['i_id'], searchVariantYes, searchVariantNo);	
}
// Error or no found
function searchCodeNo(invs) {
	alert("没有找到该商品");
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
	
	document.getElementById('code1').value = getVariantById(myVariants[0]['iv_id']);
	$tableVariant.bootstrapTable('check', 0);
	selVariantRow = 0;
}
function searchVariantNo(result) {
	document.getElementById("tableVariant").style.display = "none";
	myVariants = null;
}	
/************************************************************************************
	Variant
************************************************************************************/
var selVariantRow = -1;
var selVariant = "";
$tableVariant.bootstrapTable({   
	formatNoMatches: function () {
         return "没有符合条件的数据";
    }
});
$tableVariant.on('click-row.bs.table', function (e, row, $element) {
	if (selVariantRow >= 0) {
		$tableVariant.bootstrapTable('uncheck', selVariantRow);
		selVariantRow = getVariantSeqById(row.id);
	}
	document.getElementById('code1').value = getVariantById(row.id);
	document.getElementById('bc_amount').value = "";
	$('#bc_amount').focus();	
});
function getVariantById(id) {
	for (var i=0; i<myVariants.length; i++){
		if (myVariants[i]['iv_id'] == id) {
			selVariant = myVariants[i]['variant'];
			return myVariants[i]['barcode'];
		}
	}
	return "";
}
function getVariantSeqById(id) {
	for (var i=0; i<myVariants.length; i++){
		if (myVariants[i]['iv_id'] == id)
			return i;
	}
	return -1;
}
/************************************************************************************
	Option
************************************************************************************/
function showOption() {	
	if (option == null) {
		document.getElementById("mdbcBarcode").checked = true;
		document.getElementById("mdbcArtNo").checked = true;
		document.getElementById("mdbcVariant").checked = true;
		document.getElementById("mdbcPrice").checked = false;
	} else {
		document.getElementById("mdbcBarcode").checked = option['barcode'];
		document.getElementById("mdbcArtNo").checked = option['artno'];
		document.getElementById("mdbcVariant").checked = option['variant'];
		document.getElementById("mdbcPrice").checked = option['price'];
	}
	
	$modalBcOption.modal();
}
function mdbcSave() {
	document.getElementById("mdbcBarcode").checked ? option['barcode'] = true : option['barcode'] = false;
	document.getElementById("mdbcArtNo").checked ? option['artno'] = true : option['artno'] = false;
	document.getElementById("mdbcVariant").checked ? option['variant'] = true : option['variant'] = false;
	document.getElementById("mdbcPrice").checked ? option['price'] = true : option['price'] = false;
	
	localStorage.setItem("barcodePrint", JSON.stringify(option));
	
	$modalBcOption.modal("toggle");
}
/************************************************************************************
	Clear
************************************************************************************/
function clearFields() {
	document.getElementById("i_code").value = "";
	document.getElementById("code1").value = "";
	document.getElementById("count").value = "";
	document.getElementById("price").value = "";
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
	var printButton = document.getElementById("btnPrint");
	var code1 = document.getElementById('code1').value;
	var i_code = document.getElementById('i_code').value;
	if (myVariants != null && option['variant'])
		i_code += "    "+selVariant;
	var bc_amount = document.getElementById('bc_amount').value;
	bc_amount = parseInt(bc_amount);
	// generate barcode
	JsBarcode("#barcodeImg", code1);
	// set printer
	var printers = [];
	printers = dymo.label.framework.getPrinters();
    if (printers.length == 0) {
        alert("没有找到DYMO条码打印机");
        return;
    }
	var printer = printers[0];			
	if (!printer || printer.name == "")
        throw new Error("条码打印机错误");
	// load label
	var barcodeAsImageLabel = null;
	barcodeAsImageLabel = dymo.label.framework.openLabelXml(labelFile);
	if (!barcodeAsImageLabel)
		throw "openLabelXml错误";
	var img = new Image();
    img.onload = function() {
         try {
			printButton.disabled = true;
			 
            var canvas = document.createElement('canvas');
            canvas.width = img.width;                     
            canvas.height = img.height;

            var context = canvas.getContext('2d');
            context.drawImage(img, 0, 0);

            var dataUrl = canvas.toDataURL('image/png');
            var pngBase64 = dataUrl.substr('data:image/png;base64,'.length);
			
			barcodeAsImageLabel.setObjectText('Text', i_code);
            barcodeAsImageLabel.setObjectText('Image', pngBase64);
			var paramsXml = dymo.label.framework. createLabelWriterPrintParamsXml ({ copies: bc_amount }); 
            barcodeAsImageLabel.print(printer.name, paramsXml);
			
			printButton.disabled = false;
        } catch(e) {
            alert(e.message || e);
			printButton.disabled = false;
        }
    };
	img.src= barcodeImg.src;
}

</script>

</html>
