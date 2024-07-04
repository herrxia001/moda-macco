<?php
/************************************************************************************
	File:		inv_suppliers.php
	Purpose:	suppliers
************************************************************************************/

// Start session
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
	<title>EUCWS - Suppliers</title>
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
			<a style="color: white; font-weight: bold"><?php echo $thisResource->comSuppliers ?></a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey" align="right">
			<button type="button" class="btn" onclick="newSup()"><span style="color:white" class='fa fa-plus'></span></button>
		</div>
	</div>
	
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
		<table id="table" data-toggle="table" data-single-select="true" data-click-to-select="true" data-unique-id="id" >
			<thead>
				<tr>
				<th data-field="id" data-visible="false"></th>
				<th data-field="idx_code" data-width="20" data-width-unit="%"><?php echo $thisResource->comID ?></th>
				<th data-field="idx_name" data-width="40" data-width-unit="%" ><?php echo $thisResource->comName ?></th>
				<th data-field="idx_count" data-width="20" data-width-unit="%" data-align="right"><?php echo $thisResource->comInventory ?></th>
				<th data-field="idx_value" data-width="20" data-width-unit="%" data-align="right"><?php echo $thisResource->comValue ?></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	
	</div>
		
<!-- Modal for supplier -->
<div class="modal fade" id="modalSup" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="msTitle"><?php echo $thisResource->comSupplier ?></h5>				
				<button type="button" class="btn btn-secondary ml-2" data-dismiss="modal"><span class='fa fa-times'></span></button>
				<button type="button" id="msSave" name="msSave" class="btn btn-primary ml-2"  onclick="msDoneSup()"><span class='fa fa-check'></span></button>
			</div>
			<div class="modal-body">
<!-- s_code -->
		<input type="text" class="form-control" id="ms_s_id" name="ms_s_id" hidden>
		<input type="text" class="form-control" id="ms_s_code_old" name="ms_s_code_old" hidden>
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comID ?> *</span></div>
			<input type="text" class="form-control" id="ms_s_code" name="ms_s_code">
		</div>		
<!-- s_name -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comName ?> *</span></div>
			<input type="text" class="form-control" id="ms_s_name" name="ms_s_name">
		</div>
<!-- name1 -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comName1 ?></span></div>
			<input type="text" class="form-control" id="ms_name1" name="ms_name1">
		</div>		
<!-- address -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comAddress ?></span></div>
			<input type="text" class="form-control" id="ms_address" name="ms_address">
		</div>
<!-- post -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comPost ?></span></div>
			<input type="text" class="form-control" id="ms_post" name="ms_post">
		</div>
<!-- city -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comCity ?></span></div>
			<input type="text" class="form-control" id="ms_city" name="ms_city" value="Prato">
		</div>
<!-- country -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comCountry ?></span></div>
			<input type="text" class="form-control" id="ms_country" name="ms_country" value="Italien">
		</div>
<!-- tel -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comTel ?></span></div>
			<input type="text" class="form-control" id="ms_tel" name="ms_tel">
		</div>
<!-- contact -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comContact ?></span></div>
			<input type="text" class="form-control" id="ms_contact" name="ms_contact">
		</div>
<!-- email -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comEMail ?></span></div>
			<input type="text" class="form-control" id="ms_email" name="ms_email">
		</div>
<!-- WhatsApp -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comWhatsApp ?></span></div>
			<input type="text" class="form-control" id="ms_whatsapp" name="ms_whatsapp">
		</div>
<!-- WeChat -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comWeChat ?></span></div>
			<input type="text" class="form-control" id="ms_wechat" name="ms_wechat">
		</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div> <!-- End of Modal supplier -->

	</div> <!-- end of container -->

</body>

<script src="js/ajax.js"></script>
<script>
var myRes = <?php echo json_encode($thisResource) ?>;
var sups = [], sup;
var $tableSups = $("#table");
var actionType = 0;
// modalSup
var $modalSup = $("#modalSup");
var msColumns = ['s_code', 's_name', 'name1', 'address', 'post', 'city', 'country', 'tel', 'email', 'contact', 'whatsapp', 'wechat'];
var msColumnTotal = 12

/********************************************************************
	INIT
********************************************************************/
// Init
$(document).ready(function(){
	 searchSups();
 });
// Prevent 'enter' key for submission
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});
$tableSups.bootstrapTable({   
	formatNoMatches: function () {
         return myRes['sysMsgNoRecord'];
    }
});
/********************************************************************
	SEARCH AND LOAD
********************************************************************/
function searchSups() {
	var link = "getSups.php";
	getRequest(link, loadSups, null);
}
function loadSups(result) {
	sups = result; 
	supCount = sups.length;

	$tableSups.bootstrapTable('removeAll');
	var rows = [];
	for (var i=0; i<supCount; i++){
		rows.push({
			id: sups[i]['s_id'],
			idx_code: sups[i]['s_code'],
			idx_name: sups[i]['s_name']
		});
	}
	$tableSups.bootstrapTable('append', rows);	
	
	var link = "getSupsInvs.php";
	getRequest(link, loadSupsInvs, null);
}
function loadSupsInvs(result) {
	for (var i=0; i<supCount; i++){
		for (var j=0; j<result.length; j++) {
			if (result[j]['s_id'] == sups[i]['s_id'])
				break;
		}
		if (j == result.length)
			continue;
		$tableSups.bootstrapTable('updateCellByUniqueId', {
			id: sups[i]['s_id'],
			field: 'idx_count',
			value: result[j]['count_total']
		})
		$tableSups.bootstrapTable('updateCellByUniqueId', {
			id: sups[i]['s_id'],
			field: 'idx_value',
			value: result[j]['value_total']
		})
	}
}
/********************************************************************
	VIEW/EDIT
********************************************************************/
// Click a row to view supplier
$('#table').on('click-row.bs.table', function (e, row, $element) {
	for (var i=0; i<sups.length; i++) {
		if (sups[i]['s_id'] == row.id) {
			sup = sups[i];
			break;
		}
	}
	document.getElementById("ms_s_id").value = sup['s_id'];
	document.getElementById("ms_s_code_old").value = sup['s_code'];
	for (var i=0; i<msColumnTotal; i++) {
		document.getElementById("ms_"+msColumns[i]).value = sup[msColumns[i]];
	}
	actionType = 1;
	$modalSup.modal();
});
$modalSup.on('shown.bs.modal', function () {
	$("#ms_s_code").trigger('focus');
})
/********************************************************************
	NEW
********************************************************************/
function newSup() {
	document.getElementById("ms_s_id").value = "";
	document.getElementById("ms_s_code_old").value = "";
	for (var i=0; i<msColumnTotal; i++) {
		document.getElementById("ms_"+msColumns[i]).value = "";
	}
	actionType = 0;
	$modalSup.modal();	
}
/********************************************************************
	SAVE
********************************************************************/
function msDoneSup() {
	sup = new Object();
	
	sup['s_id'] = document.getElementById("ms_s_id").value;
	for (var i=0; i<msColumnTotal; i++) {
		sup[msColumns[i]] = document.getElementById("ms_"+msColumns[i]).value;
	}
	if (sup['s_code'] == "") {
		$("#ms_s_code").trigger('focus');
		return;
	}	
	if (sup['s_code'] != document.getElementById("ms_s_code_old").value) {
		if (sups != null) {
			for (var i=0; i<sups.length; i++) {
				if (sup['s_code'] == sups[i]['s_code']) {
					alert(myRes['msgErrDupData']);
					$("#ms_s_code").trigger('focus');
					return;
				}
			}
		}		
	}
	if (sup['s_name'] == "") {
		$("#ms_s_name").trigger('focus');
		return;
	}
	
	msSaveSup();
}
function msSaveSup() {
	$modalSup.modal("toggle");
	
	if (actionType == 1)
		var link = "postSupUpdate.php";
	else
		var link = "postSupAdd.php";
	var form = new FormData();
	form.append('sup', JSON.stringify(sup)); 
	postRequest(link, form, saveBack, null);
}
function saveBack(result) {
	searchSups();
}

</script>

</html>
