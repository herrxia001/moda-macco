<?php
/************************************************************************************
	File:		set_print.php
	Purpose:	change pinter
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();
include_once 'db_functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	$thisDb = new myDatabase($root_db);
	$sqlUpdate = "UPDATE users SET printerName ='".$_POST['printerName']."',paperWidth='".
		$_POST['paperWidth']."',paperHeight = '".$_POST['paperHeight']."',codeWidth = '".$_POST['codeWidth']."', codeHeight = '".$_POST['codeHeight']."',fontSize='".$_POST['fontSize']."' WHERE u_id ='".$_SESSION['uId']."'";
	$thisDb->dbUpdate($sqlUpdate);
	$_SESSION['printerName'] = $_POST['printerName']; 
	$_SESSION['paperWidth'] = $_POST['paperWidth']; 
	$_SESSION['paperHeight'] = $_POST['paperHeight']; 
	$_SESSION['codeWidth'] = $_POST['codeWidth']; 
	$_SESSION['codeHeight'] = $_POST['codeHeight']; 
	$_SESSION['fontSize'] = $_POST['fontSize']; 
	header("Location:settings.php");	
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Printer</title>
</head>
<style>
body {
 padding-top: 0rem;
}
</style>
<body>
<?php include 'include/nav.php' ?>
<br><br>
<br>
	<form action="" method="post">

    <div class="container">

	<div class="row mb-2">
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey">
			<a class="btn" href="settings.php" role="button"><span style="color:white" class='fa fa-arrow-left'></span></a>
		</div>
		<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-4"  style="background-color: DarkSlateGrey" align="center"> 
			<a style="color: white; font-weight: bold">条码打印机管理</a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey" align="right">
			<button type="submit" name="ok" class="btn"><span style="color:white" class='fa fa-check'></span></button>
		</div>
	</div>
	
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:140px;">打印机型号</span></div>
			<input class="form-control" id="printerName" name="printerName" value="<?= $_SESSION['printerName'] ?>" required autofocus>
		</div>
	</div>
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:140px;">打印纸宽度</span></div>
			<input class="form-control" id="paperWidth" name="paperWidth" value="<?= $_SESSION['paperWidth'] ?>" required>
		</div>	
	</div>		
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:140px;">打印纸高度</span></div>
			<input class="form-control" id="paperHeight" name="paperHeight" value="<?= $_SESSION['paperHeight'] ?>" required>
		</div>	
	</div>	
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:140px;">条码宽度</span></div>
			<input class="form-control" id="codeWidth" name="codeWidth" value="<?= $_SESSION['codeWidth'] ?>" required>
		</div>	
	</div>	
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:140px;">条码高度</span></div>
			<input class="form-control" id="codeHeight" name="codeHeight" value="<?= $_SESSION['codeHeight'] ?>" required>
		</div>	
	</div>	
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:140px;">字符大小</span></div>
			<input class="form-control" id="fontSize" name="fontSize" value="<?= $_SESSION['fontSize'] ?>" required>
		</div>	
	</div>	


		
	</div>
	
	</form>
	
<script>
 
</script>

</body>
</html>
