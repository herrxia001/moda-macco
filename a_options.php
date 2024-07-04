<?php
/************************************************************************************
	File:		a_options.php
	Purpose:	invoice options
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'resource_'.$_SESSION['uLanguage'].'.php';
include_once 'db_functions.php';

$thisResource = new myResource();

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUIMS - Options</title>
</head>

<body>
	<?php include 'include/a_nav.php' ?>
	
    <div class="container">
	
	<div class="row">
		<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3">
			<label><?php echo $thisResource->comSettings ?></label>
		</div>
		<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3" align="right">
			<button type="button" class="btn btn-primary" id="btnSave" onclick="saveOptions()"><span class='fa fa-check'><span></button>
		</div>
	</div>
	<div class="row"><div class="col-12 col-sm-12 col-md-12 col-lg-6"><hr></div></div>
	
	<div class="row"><div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6">
		<?php echo $thisResource->comPrint ?>
	</div></div>
	<div class="row"><div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="ml-2 form-check"><label class="form-check-label">
			<input type="checkbox" class="form-check-input" id="opPrintNoArt" value=""><?php echo $thisResource->opPrintNoART ?> 
		</label></div>
	</div></div>
	<div class="row"><div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="ml-2 form-check"><label class="form-check-label">
			<input type="checkbox" class="form-check-input" id="opPrintReklamation" value=""><?php echo $thisResource->opPrintReklamation ?> 
		</label></div>
	</div></div>
	<div class="row"><div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="ml-2 form-check"><label class="form-check-label">
			<input type="checkbox" class="form-check-input" id="opPrintQRCode" value=""><?php echo $thisResource->opPrintQRCode ?> 
		</label></div>
	</div></div>
	<div class="row"><div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="ml-2 form-check"><label class="form-check-label">
			<input type="checkbox" class="form-check-input" id="opPrintReklamation1" value=""><?php echo $thisResource->opPrintReklamation1 ?> 
		</label></div>
	</div></div>

	<div class="row"><div class="col-12 col-sm-12 col-md-12 col-lg-6"><hr></div></div>
	
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6">
			<?php echo $thisResource->comExport ?>
		</div>
	</div>
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6">
			<div class="input-group p-1">
				<label id="rd1"><input type="radio" class="ml-1" id="radio1" name="opExport" value="opExport1" checked><?php echo $thisResource->opDecimalNormal ?></label>
				<label id="rd2"><input type="radio" class="ml-4" id="radio2" name="opExport" value="opExport2"><?php echo $thisResource->opDecimalComma ?></label>
			</div>
		</div>
	</div>
	<div class="row"><div class="col-12 col-sm-12 col-md-12 col-lg-6"><hr></div></div>
	
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6" align="right">
			<button type="button" class="btn btn-primary" id="btnSave" onclick="saveOptions()"><span class='fa fa-check'><span></button>
		</div>
	</div>
	
	</div>

<script src="js/aOptions.js?2022-0914-1022"></script>
<script>
var myRes = <?php echo json_encode($thisResource) ?>;

initAOptions();
displayOptions();

function displayOptions() {
	// print
	document.getElementById("opPrintNoArt").checked = aOptions['printNoART'];
	document.getElementById("opPrintReklamation").checked = aOptions['printReklamation'];
	document.getElementById("opPrintQRCode").checked = aOptions['printQRCode'];
	document.getElementById("opPrintReklamation1").checked = aOptions['printReklamation1'];
	// export
	var radiosExport = document.getElementsByName('opExport');
	if (aOptions['exportDecimal'] == 1)
		radiosExport[1].checked  = true;
	else
		radiosExport[0].checked  = true;
}

function saveOptions() {
	// print
	document.getElementById("opPrintNoArt").checked ? aOptions['printNoART'] = 1 : aOptions['printNoART'] = 0;
	document.getElementById("opPrintReklamation").checked ? aOptions['printReklamation'] = 1 : aOptions['printReklamation'] = 0;
	document.getElementById("opPrintQRCode").checked ? aOptions['printQRCode'] = 1 : aOptions['printQRCode'] = 0;
	document.getElementById("opPrintReklamation1").checked ? aOptions['printReklamation1'] = 1 : aOptions['printReklamation1'] = 0;
	//export
	var radiosExport = document.getElementsByName('opExport');
	if (radiosExport[1].checked)
		aOptions['exportDecimal'] = 1;
	else
		aOptions['exportDecimal'] = 0;
	
	saveAOptions();
	alert(myRes['msgDataSaved']);
}
 
</script>

</body>
</html>
