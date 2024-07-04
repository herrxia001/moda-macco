<?php
/************************************************************************************
	File:		bc_index.php
	Purpose:	index page barcode
	2021-04-16: created file
************************************************************************************/

session_start();

include_once 'resource.php';
include_once 'db_functions.php';

date_default_timezone_set("Europe/Berlin");	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<link href="css/signin.css" rel="stylesheet">
	<title>EUCWS-BARCODE</title>
</head>

<body class="text-center">
	<form method="post" class="form-signin">
		<h1 class="h3 mb-3 font-weight-normal">EUCWS BARCODE</h1>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa fa-user"></i></span>
            </div>
			<input type="text" id="inputUser" name="inputUser" class="form-control" autofocus>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa fa-unlock-alt"></i></span>
            </div>
			<input type="password" id="inputPassword" name="inputPassword" class="form-control">
		</div>
		<button type="button" name="login" class="btn btn-lg btn-secondary btn-block" onclick="loginSubmit()"><i class="fa fa-sign-in"></i></button>
	</form>	
</body>

<script src="js/sysfunc.js?v1"></script>
<script src="js/ajax.js"></script>
<script>

var user = "", password = "";

$(document).ready(function(){
	user = localStorage.getItem("bc_user");
	password = localStorage.getItem("bc_password");
	
	if (user != null && user != "") {
		document.getElementById("inputUser").value = user;
	}
	if (password != null && password != "") {
		document.getElementById("inputPassword").value = password;
	}
 });
 
function loginSubmitYes(result) {
	localStorage.setItem("bc_user", user);
	localStorage.setItem("bc_password", password);
	var url = "bc_home.php";
	window.location.assign(url);
}
function loginSubmitNo(result) {
	$('#inputUser').focus();
}
function loginSubmit() {
	user = document.getElementById("inputUser").value;
	if (user == "") {
		$('#inputUser').focus();
		return;
	}
	password = document.getElementById("inputPassword").value;
	if (password == "") {
		$('#inputPassword').focus();
		return;
	}

	var form = new FormData();
	form.append('user', JSON.stringify(user));
	form.append('password', JSON.stringify(password)); 
	postRequest("postLogin.php", form, loginSubmitYes, loginSubmitNo);
	
}

</script>

</html>

