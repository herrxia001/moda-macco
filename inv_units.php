<?php
/************************************************************************************
	File:		inv_units.php
	Purpose:	product units
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
	<title>EUCWS - Product Units</title>
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
			<a style="color: white; font-weight: bold"><?php echo $thisResource->comPackages ?></a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2"  style="background-color: DarkSlateGrey">
		</div>
	</div>
		
	<div class="row">
		<div class="p-1 input-group col-6 col-sm-6 col-md-6 col-lg-4">
		</div>
		<div class="p-1 input-group col-6 col-sm-6 col-md-6 col-lg-4" align="right">
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comPackageCap ?></span></div>
			<input type="number" min="0" step="1" class="form-control" id="units" name="units" autofocus>	
			<button type="button" id="btnNew" name="btnNew" class="ml-1 btn btn-primary" onclick="newItem()"><span class='fa fa-plus'></span></button>
		</div>
	</div>
	
	<div class="row"> 
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<table id="table" data-toggle="table" data-single-select="true" data-click-to-select="true" data-unique-id="id">
			<thead>
				<tr>
				<th data-field="id" data-width="" data-width-unit="%" data-visible="false"></th>
				<th data-field="idx_units" data-width="85" data-width-unit="%"><?php echo $thisResource->comPackageCap ?></th>
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
var myUnits = [];
var $table = $("#table");

/********************************************************************
	INIT
********************************************************************/
// Init
$(document).ready(function(){
	searchUnits();
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
function searchUnits() {
	getRequest("getUnits.php", loadTableYes, loadTableNo);
}
function loadTableYes(result) {
	myUnits = result;
	$table.bootstrapTable('removeAll');	
	var rows = [];
	for(var i=0; i<myUnits.length; i++){
		var delStr = "<button type='button' class='btn btn-secondary' id='btnDel' onclick='delItem()'><span class='fa fa-trash'></button>";	
		rows.push({
			id: myUnits[i]['ut_id'],
			idx_units: myUnits[i]['units'],
			idx_del: delStr
		});
	}
	$table.bootstrapTable('append', rows);
}
function loadTableNo(result) {
	myUnits = null;
	$table.bootstrapTable('removeAll');
}
/********************************************************************
	DELETE ITEM
********************************************************************/
var delItemOk = 0;
$table.on('click-row.bs.table', function (e, row, $element) {
	if (!delItemOk)
		return;
	if (!confirm(myRes['msgConfirmDelete']+" "+row.idx_units+" ?"))
		return;
	delDbUnits(row.id);
	delItemOk = 0;	
})
function delItem() {
	delItemOk = 1;
}
/********************************************************************
	ADD ITEM
********************************************************************/
function newItem(){
	var units = document.getElementById("units").value;
	if (units == "" || !onlyDigits(units)) {
		$('#units').focus();
		return;
	}
	units = parseInt(units).toString();
	if(!checkUnits(units)) {
		alert(myRes['msgErrDupData']);
		$('#units').focus();
		return;
	}	
	addDbUnits(units);
	document.getElementById("units").value = "";	
}
/********************************************************************
	DATABASE ACTION
********************************************************************/
function addDbUnits(units) {
	var form = new FormData();
	form.append('units', units);
	postRequest('postUnitAdd.php', form, addDbUnitsYes, addDbUnitsNo);
}
function addDbUnitsYes(result) {
	searchUnits();
}
function addDbUnitsNo(result) {
	alert(myRes['msgErrDatabase']);
}
function delDbUnits(id) {
	var form = new FormData();
	form.append('id', id);
	postRequest('postUnitDel.php', form, delDbUnitsYes, delDbUnitsNo);
}
function delDbUnitsYes(result) {
	searchUnits();
}
function delDbUnitsNo(result) {
	alert(myRes['msgErrDatabase']);
}
/********************************************************************
	FUNCTIONS
********************************************************************/
function checkUnits(units) { 
	if (myUnits == null)
		return true;
	for(var i=0; i<myUnits.length; i++){
		if (units == myUnits[i]['units']) {
			return false;
		}
	}
	return true;
}
function onlyDigits(s) {
	var d;
	for (var i=0; i<s.length; i++) {
		d = s[i];
		if (d < "0" || d > "9")
			return false;
	}
	if (parseInt(s) <= 0 || parseInt(s) > 9999)
		return false;
	return true;
}
</script>

</html>

