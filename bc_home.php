<?php
/************************************************************************************
	File:		bc_home.php
	Purpose:	Home page with barcode
	2021-04-16: created file
	2021-04-17：added options
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:bc_index.php");

include_once 'resource.php';
$thisResource = new myResource($_SESSION['uLanguage']);

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header_bc.php' ?>
	<title>EUCWS-BARCODE</title>
</head>
<style>
.center {
  text-align: center;
  border: 3px;
}
img {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>
<body>
	<br>
    <div class="container">
		<div class="row">
			<div class="col-6 col-sm-6 col-md-3 col-lg-3 center">
				<a href="bc_purlist.php"><img class="mb-3" src="images/bc_purchase.svg" alt="" width="80" height="80"></a>
				<p><a class="btn btn-secondary" href="bc_purlist.php" role="button"><?php echo $thisResource->bcPurchase ?></a></p>
			</div>
			<div class="col-6 col-sm-6 col-md-3 col-lg-3 center">
				<a href="bc_product.php"><img class="mb-3" src="images/h_barcode.svg" alt="" width="80" height="80"></a>
				<p><a class="btn btn-secondary" href="bc_product.php" role="button"><?php echo $thisResource->bcProducts ?></a></p>
			</div>
			<div class="col-6 col-sm-6 col-md-3 col-lg-3 center">
				<a onclick="showOption()"><img class="mb-3" src="images/bc_settings.svg" alt="" width="80" height="80"></a>
				<p><a class="btn btn-secondary" onclick="showOption()" role="button"><?php echo $thisResource->bcSettings ?></a></p>
			</div>
			<div class="col-6 col-sm-6 col-md-3 col-lg-3 center">
				<a onclick="updateData()"><img class="mb-3" src="images/bc_update1.svg" alt="" width="80" height="80"></a>
				<p><a class="btn btn-secondary" onclick="updateData()" role="button"><?php echo $thisResource->bcUpdate ?></a></p>
			</div>
		</div>
	</div> <!-- end of container -->

<!-- Modal Barcode Option -->	
<div class="modal fade" id="modalBcOption" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo $thisResource->bcSetTitle ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			
			<div class="modal-body">
			
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdbcBarcode" value=""><?php echo $thisResource->bcSetBC ?> 
				</label>
			</div>
			<div class="mt-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdbcArtNo" value=""><?php echo $thisResource->bcSetCode ?>
				</label>
			</div>
			<div class="mt-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdbcVariant" value=""><?php echo $thisResource->bcSetVariant ?>
				</label>
			</div>
			<div class="mt-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdbcColorSecond" value=""><?php echo $thisResource->bcColorSecond ?>
				</label>
			</div>
			<div class="mt-2 input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcPaperWidth ?></span></div>	
				<input type="number" class="form-control" name="mdbcPaperWidth" id="mdbcPaperWidth" value="50">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcPaperHeight ?></span></div>	
				<input type="number" class="form-control" name="mdbcPaperHeight" id="mdbcPaperHeight" value="25">
			</div>
			<div class="mt-2 input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCodeWidth ?></span></div>	
				<input type="number" class="form-control" name="mdbcCodeWidth" id="mdbcCodeWidth" value="3">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcCodeHeight ?></span></div>	
				<input type="number" class="form-control" name="mdbcCodeHeight" id="mdbcCodeHeight" value="50">
			</div>
			<div class="mt-2 input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->bcFontSize ?></span></div>	
				<input type="number" class="form-control" name="mdbcFontSize" id="mdbcFontSize" value="32">
			</div>

			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="mdbcSave()"><span class='fa fa-check'></span></button>
			</div>
		</div>
	</div>
</div> <!-- End of Modal Barcode Option -->

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?01201026"></script>
<script src="js/barcodeOption.js?202108101453"></script>
<script>

var myResource = <?php echo json_encode($thisResource) ?>; 
var $modalBcOption = $('#modalBcOption');

// Get all inventories for autocomplete
getRequest("getInvs.php", loadInvs, null);
function loadInvs(result) {
	var a_icode = new Array(), a_image = new Array(), imgFile;
	
	for (var i = 0; i < result.length; i++) {
		a_icode[i] = result[i]['i_code'];
		imgFile = result[i]['path']+"/"+result[i]['i_id']+"_"+result[i]['m_no']+"_s.jpg";
		a_image[i] = imgFile;
	}	
	
	localStorage.setItem("bc_icode", JSON.stringify(a_icode));
	localStorage.setItem("bc_image", JSON.stringify(a_image)); 
	
	if (isUpdateData) {
		alert(myResource['bcMsgUpdate']);
		isUpdateData = false;
	}		
}

/************************************************************************************
	Option
************************************************************************************/
function showOption() {	
	document.getElementById("mdbcBarcode").checked = option['barcode'];
	document.getElementById("mdbcArtNo").checked = option['artno'];
	document.getElementById("mdbcVariant").checked = option['variant'];
	document.getElementById("mdbcColorSecond").checked = option['colorSecond'];
	document.getElementById("mdbcPaperWidth").value = option['paperWidth'];
	document.getElementById("mdbcPaperHeight").value = option['paperHeight'];
	document.getElementById("mdbcCodeWidth").value = option['codeWidth'];
	document.getElementById("mdbcCodeHeight").value = option['codeHeight'];
	document.getElementById("mdbcFontSize").value = option['fontSize'];
	
	$modalBcOption.modal();
}
function mdbcSave() {
	document.getElementById("mdbcBarcode").checked ? option['barcode'] = true : option['barcode'] = false;
	document.getElementById("mdbcArtNo").checked ? option['artno'] = true : option['artno'] = false;
	document.getElementById("mdbcVariant").checked ? option['variant'] = true : option['variant'] = false;	
	document.getElementById("mdbcColorSecond").checked ? option['colorSecond'] = true : option['colorSecond'] = false;	
	option['paperWidth'] = parseInt(document.getElementById("mdbcPaperWidth").value);
	option['paperHeight'] = parseInt(document.getElementById("mdbcPaperHeight").value);
	option['codeWidth'] = parseInt(document.getElementById("mdbcCodeWidth").value);
	option['codeHeight'] = parseInt(document.getElementById("mdbcCodeHeight").value);
	option['fontSize'] = parseInt(document.getElementById("mdbcFontSize").value);
	
	localStorage.setItem("barcodePrint", JSON.stringify(option));
	
	$modalBcOption.modal("toggle");
}

/************************************************************************************
	Update
************************************************************************************/
var isUpdateData = false;
function updateData() {
	isUpdateData = true;
	getRequest("getInvs.php", loadInvs, null);
}

</script>

</body>
</html>
