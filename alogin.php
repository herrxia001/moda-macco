<?php
/* INVOICE LOGIN */
// 2021-01-10 changed to js

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
	<title>EUIMS</title>
</head>

<body class="text-center">
	<form method="post" class="form-signin">
		<h1 class="h3 mb-3 font-weight-normal">EUIMS发票管理系统</h1>
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
	user = localStorage.getItem("user");
	if (user != null && user != "") {
		document.getElementById("inputUser").value = user;
		$('#inputPassword').focus();
	}
 });

function loginSubmitYes(result) {
	localStorage.setItem("user", user);
	
	var url = "a_neword.php";
	window.location.assign(url);
}
function loginSubmitNo(result) {
	alert("用户名或密码有误");
	$('#inputUser').focus();
}
function loginSubmit() {
	user = document.getElementById("inputUser").value;
	if (user == "") {
		alert("请输入用户名");
		$('#inputUser').focus();
		return;
	}
	password = document.getElementById("inputPassword").value;
	if (password == "") {
		alert("请输入密码");
		$('#inputPassword').focus();
		return;
	}

	var tabID = sessionStorage.tabID ? 
            sessionStorage.tabID : 
            sessionStorage.tabID = Math.random();

	var form = new FormData();
	form.append('user', JSON.stringify(user));
	form.append('password', JSON.stringify(password)); 
	form.append('tabID', JSON.stringify(tabID)); 
	postRequest("postLogin.php", form, loginSubmitYes, loginSubmitNo);
		
}

$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        loginSubmit();
    }
});

</script>

</html>

