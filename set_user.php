<?php
/************************************************************************************
	File:		set_user.php
	Purpose:	add user
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'resource.php';
include_once 'db_functions.php';

$thisResource = new myResource($_SESSION['uLanguage']);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	$myUser = $_POST['user'];
	if(strcmp($_POST['pwd'],$_POST['pwd-re'])!=0)
	{
		$pwdError = $thisResource->fmUserMsgPwdNotMatch;
	}
	else
	{		
		if(dbCheckUserExist($_POST['user']))
			$pwdError = $thisResource->fmUserMsgUserExist;
		else	
		{	
			dbAddUser($_POST['user'], $_POST['pwd']);	
			header("Location:settings.php");
		}
	}	
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - User</title>
</head>

<body>
	<?php include 'include/nav.php' ?>
	
	<form action="" method="post">

    <div class="container">
		<div class="row">
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px"><?php echo $thisResource->fmUserCapName ?></span></div>
				<input type="text" class="form-control" id="user" name="user" required autofocus
					oninvalid="this.setCustomValidity('<?php echo $thisResource->fmUserMsgUser ?>')" oninput="setCustomValidity('')"
					value="<?php echo $myUser ?>">
			</div>
		</div>
		<div class="row">
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px"><?php echo $thisResource->fmUserCapPwd ?></span></div>
				<input type="password" class="form-control" id="pwd" name="pwd" required
					oninvalid="this.setCustomValidity('<?php echo $thisResource->fmUserMsgPwd ?>')" oninput="setCustomValidity('')">
			</div>
		</div>
		<div class="row">
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px"><?php echo $thisResource->fmUserCapPwdRe ?></span></div>
				<input type="password" class="form-control" id="pwd-re" name="pwd-re" required
					oninvalid="this.setCustomValidity('<?php echo $thisResource->fmUserMsgPwdRe ?>')" oninput="setCustomValidity('')">
			</div>	
		</div>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8" align="right">
				<a class="btn btn-secondary" href="settings.php" role="button"><?php echo $thisResource->fmUserBtnBack ?></a>
				<button type="submit" name="ok" class="btn btn-primary"><?php echo $thisResource->fmUserBtnSave ?></button>
			</div>
		</div>

		<?php if ($pwdError ) { ?>
			<div class="alert alert-warning"><?php echo $pwdError; ?></div>
		<?php } ?>		
	</div>
	
	</form>
	
<script>

// Display Title
$(document).ready(function(){
	 document.getElementById("myTitle").innerHTML = "用户管理";
 });
 
</script>

</body>
</html>
