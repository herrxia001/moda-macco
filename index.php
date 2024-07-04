<?php
/************************************************************************
index.php
************************************************************************/

session_start();

include_once 'db_functions.php';

date_default_timezone_set("Europe/Berlin");	

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<link href="css/signin.css" rel="stylesheet">
	<title>EUCWS</title>
</head>

<body class="text-center">
	<form method="post" class="form-signin">
		<h1 class="h3 mb-3 font-weight-normal">EUCWS</h1>
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

<script src="js/ajax.js"></script>
<script>

var user = "", password = "";

$(document).ready(function(){
	user = localStorage.getItem("user");
	if (user != null && user != "") {
		document.getElementById("inputUser").value = user;
		$('#inputPassword').focus();
	}
 });
 
function loginSubmitYes(result) {
	localStorage.setItem("user", user);
	
	var url = "home.php";
	window.location.assign(url);
}
function loginSubmitNo(result) {
	$('#inputUser').focus();
	console.log(result);
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

$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        loginSubmit();
    }
});

</script>

</html>

