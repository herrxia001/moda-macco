<?php
/************************************************************************************
	File:		set_password.php
	Purpose:	change password
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();
include_once 'db_functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	if(strcmp($_POST['pwd'],$_POST['pwd-re'])!=0){
		$pwdError = $thisResource->fmPwdMsgPwdNotMatch;
	}
	else
	{
		dbUpdatePassword($_POST['pwd']);
		header("Location:settings.php");
	}	
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Password</title>
</head>
<style>
body {
 padding-top: 0rem;
}
</style>
<body>
	
	<form action="" method="post">

    <div class="container">

	<div class="row mb-2">
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey">
			<a class="btn" href="settings.php" role="button"><span style="color:white" class='fa fa-arrow-left'></span></a>
		</div>
		<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-4"  style="background-color: DarkSlateGrey" align="center"> 
			<a style="color: white; font-weight: bold"><?php echo $thisResource->comPassMgt ?></a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey" align="right">
			<button type="submit" name="ok" class="btn"><span style="color:white" class='fa fa-check'></span></button>
		</div>
	</div>
	
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:140px;"><?php echo $thisResource->comPassNew ?></span></div>
			<input type="password" class="form-control" id="pwd" name="pwd" required autofocus>
		</div>
	</div>
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<div class="input-group-prepend"><span class="input-group-text" style="width:140px;"><?php echo $thisResource->comPassRe ?></span></div>
			<input type="password" class="form-control" id="pwd-re" name="pwd-re" required>
		</div>	
	</div>		
		
	</div>
	
	</form>
	
<script>
 
</script>

</body>
</html>
