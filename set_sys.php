<?php
/************************************************************************************
	File:		set_sys.php
	Purpose:	system settings
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';		
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Settings</title>
</head>
<style>
body {
 padding-top: 0.0rem;
}
</style>
<body>
    <div class="container">
	
	<div class="row mb-2">
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey">
			<a class="btn" href="settings.php" role="button"><span style="color:white" class='fa fa-arrow-left'></span></a>
		</div>
		<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-4"  style="background-color: DarkSlateGrey" align="center"> 
			<a style="color: white; font-weight: bold"><?php echo $thisResource->comSettings ?></a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey" align="right">
			<button type="button" class="btn" onclick="saveOptions()"><span style="color:white" class='fa fa-check'></span></button>
		</div>
	</div>

	<div class="row">
		<div class="p-1 ml-2 col-12 col-sm-12 col-md-12 col-lg-8">
			<?php echo $thisResource->comOptions ?>
		</div>
	</div>
	<div class="row">
		<div class="p-1 ml-2 col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="ml-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="sysSearchLike" value=""><?php echo $thisResource->opWildSearch ?> 
				</label>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="p-1 ml-2 col-12 col-sm-12 col-md-12 col-lg-8">
			<?php echo $thisResource->comPurchase ?>
		</div>
	</div>
	<div class="row">
		<div class="p-1 ml-2 col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="ml-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="sysPurPosition" value=""><?php echo $thisResource->opPurPosition ?> 
				</label>
			</div>
		</div>
	</div>
	
	</div>
	
<script>
var options = JSON.parse(localStorage.getItem("sysOptions"));
if (options == null) {
	options = new Object();
	options['sysSearchLike'] = false;
	options['sysPurPosition'] = false;
}

document.getElementById("sysSearchLike").checked = options['sysSearchLike'];
document.getElementById("sysPurPosition").checked = options['sysPurPosition'];

function saveOptions() {
	document.getElementById("sysSearchLike").checked ? options['sysSearchLike'] = true : options['sysSearchLike'] = false;
	document.getElementById("sysPurPosition").checked ? options['sysPurPosition'] = true : options['sysPurPosition'] = false;
	
	localStorage.setItem("sysOptions", JSON.stringify(options));
	
	window.location.assign("settings.php");
}
 
</script>

</body>
</html>
