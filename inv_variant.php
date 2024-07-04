<?php
/************************************************************************************
	File:		inv_variant.php
	Purpose:	product variants
************************************************************************************/

// Start session; If session expired, load the login page.
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include_once 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

// Init variables
$backPhp = 'management.php';

if(isset($_GET['back']))
	$backPhp = $_GET['back'].'.php';

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Product Variants</title>
</head>
<style>
body {
 padding-top: 0rem;
}
</style>
<body>
	<div class="container">	
	
	<div class="row mb-2">
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey">
			<a class="btn" href=<?php echo $backPhp ?> role="button"><span style="color:white" class='fa fa-arrow-left'></span></a>
		</div>
		<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-4"  style="background-color: DarkSlateGrey" align="center"> 
			<a style="color: white; font-weight: bold;"><?php echo $thisResource->comVariants ?></a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2"  style="background-color: DarkSlateGrey">
		</div>
	</div>
	
	<div class="row">
		<div class="p-1 input-group col-4 col-sm-4 col-md-4 col-lg-4">
		</div>
		<div class="p-1 input-group col-8 col-sm-8 col-md-8 col-lg-4" align="right">
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comVariant ?></span></div>
				<input type="text" class="form-control" id="variant" name="variant" autofocus>	
				<button type="button" id="btnNew" name="btnNew" class="ml-1 btn btn-primary" onclick="newItem()"><span class='fa fa-plus'></span></button>
		</div>
	</div>
	
	<div class="row"> 
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<table id="table" data-toggle="table" data-single-select="true" data-click-to-select="true" data-unique-id="id">
			<thead>
				<tr>
				<th data-field="id" data-width="" data-width-unit="%" data-visible="false"></th>
				<th data-field="idx_variant" data-width="85" data-width-unit="%"><?php echo $thisResource->comVariant ?></th>
				<th data-field="idx_del" data-width="15" data-width-unit="%"></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
		</div>
	</div>
	
	</div>

</body>

<script src="js/ajax.js"></script>
<script>
var myRes = <?php echo json_encode($thisResource) ?>;
var myVariants = [];
var $table = $("#table");

/********************************************************************
	INIT
********************************************************************/
// Init
$(document).ready(function(){
	searchVariants();
 });
// Prevent 'enter' key for submission
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});
$table.bootstrapTable({   
	formatNoMatches: function () {
         return myRes['sysMsgNoRecord'];
    }
});
/********************************************************************
	LOAD TABLE
********************************************************************/
function searchVariants() {
	getRequest("getVariants.php", loadTableYes, loadTableNo);
}
function loadTableYes(result) {
	myVariants = result;
	$table.bootstrapTable('removeAll');	
	var rows = [];
	for(var i=0; i<myVariants.length; i++){
		var delStr = "<button type='button' class='btn btn-secondary' id='btnDel' onclick='delItem()'><span class='fa fa-trash'></button>";	
		rows.push({
			id: myVariants[i]['va_id'],
			idx_variant: myVariants[i]['variant'],
			idx_del: delStr
		});
	}
	$table.bootstrapTable('append', rows);
}
function loadTableNo(result) {
	myVariants = null;
	$table.bootstrapTable('removeAll');
}
/********************************************************************
	DELETE ITEM
********************************************************************/
var delItemOk = 0;
$table.on('click-row.bs.table', function (e, row, $element) {
	if (!delItemOk)
		return;
	if (!confirm(myRes['msgConfirmDelete']+" "+row.idx_variant+" ?"))
		return;
	delDbVariant(row.id);
	delItemOk = 0;	
})
function delItem() {
	delItemOk = 1;
}
/********************************************************************
	ADD ITEM
********************************************************************/
function newItem(){
	var variant = document.getElementById("variant").value;
	if (variant == "" || variant.length > 100 ) {
		$('#variant').focus();
		return;
	}
	if(!checkVariant(variant)) {
		alert(myRes['msgErrDupData']);
		$('#variant').focus();
		return;
	}	
	addDbVariant(variant);
	document.getElementById("variant").value = "";	
}
/********************************************************************
	DATABASE ACTION
********************************************************************/
function addDbVariant(variant) {
	var form = new FormData();
	form.append('variant', variant);
	postRequest('postVariantsAdd.php', form, addDbVariantYes, addDbVariantNo);
}
function addDbVariantYes(result) {
	searchVariants();
}
function addDbVariantNo(result) {
	alert(myRes['msgErrDatabase']);
}
function delDbVariant(id) {
	var form = new FormData();
	form.append('id', id);
	postRequest('postVariantsDel.php', form, delDbVariantsYes, delDbVariantsNo);
}
function delDbVariantsYes(result) {
	searchVariants();
}
function delDbVariantsNo(result) {
	alert(myRes['msgErrDatabase']);
}
/********************************************************************
	FUNCTIONS
********************************************************************/
function checkVariant(variant) { 
	if (myVariants == null)
		return true;
	for(var i=0; i<myVariants.length; i++){
		if (variant == myVariants[i]['variant']) {
			return false;
		}
	}
	return true;
}

</script>

</html>

