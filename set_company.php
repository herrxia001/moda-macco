<?php
/************************************************************************************
	File:		set_company.php
	Purpose:	company profile
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

$cmpError = "";

$column = dbGetCompanyColumns();
$column_no = dbGetCompanyColumnNo();
$myCompany = dbQueryCompany();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	$myCompany = array();
	for($i=0; $i<$column_no; $i++)
		$myCompany[$column[$i]] = $_POST[$column[$i]];
	dbUpdateCompany($myCompany);
	header("Location:settings.php");
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Company</title>
</head>
<style>
body {
 padding-top: 0.0rem;
}
</style>
<body>
	<form action="" method="post">
	
	<div class="container">
	
	<div class="mb-2 row">
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2"  style="background-color: DarkSlateGrey"> 
			<a class="btn" href="settings.php" role="button"><span style="color:white" class='fa fa-arrow-left'></span></a>
		</div>
		<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-4"  style="background-color: DarkSlateGrey" align="center"> 
			<a style="color: white; font-weight: bold"><?php echo $thisResource->comCompProfile ?></a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2"  style="background-color: DarkSlateGrey" align="right">
			<button type="submit" name="ok" class="btn"><span style="color:white" class='fa fa-check'></span></button>
		</div>
	</div>

	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:120px"><?php echo $thisResource->comCompCap[0] ?></span></div>
			<input type="text" class="form-control" id="<?php echo $column[0] ?>" name="<?php echo $column[0] ?>" required autofocus
					oninvalid="this.setCustomValidity('<?php echo $thisResource->msgErrDataInput ?>')" oninput="setCustomValidity('')"
					value="<?php echo $myCompany[$column[0]] ?>">
		</div>
	</div>
	<?php for ($i=1; $i<$column_no; $i++){ ?>
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:120px"><?php echo $thisResource->comCompCap[$i] ?></span></div>
				<input type="text" class="form-control" id="<?php echo $column[$i] ?>" name="<?php echo $column[$i] ?>" value="<?php echo $myCompany[$column[$i]] ?>">
		</div>
	</div>
	<?php } ?>	
	
	</div>
	
	</form>
	
<script>
 
</script>

</body>
</html>
