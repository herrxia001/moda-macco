<?php
/************************************************************************************
	File:		app_report.php

************************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

// Init variables
$backPhp = 'app_home.php';
if(isset($_GET['back']))
	$backPhp = $_GET['back'].'.php';

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>MODAS - APP REPORT</title>
</head>

<body>
	<?php include 'include/nav.php' ?>
	<?php include "include/modalSelTime.php" ?>
	
	<div class="container">

	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8"> 
			<a class="btn btn-outline-secondary" href=<?php echo $backPhp ?>><?php echo $thisResource->comBack ?></a>
			<button type="button" class="btn btn-outline-secondary" id="selTime" onclick="selectTime()">
				<?php echo $thisResource->mdstRdThisMonth ?></button>
		</div>
	</div>
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8" align="center">
			<ul class="nav nav-tabs">
				<li class="nav-item"><a class="nav-link active" href="#tabSales" data-toggle="tab"><?php echo $thisResource->appRptSales ?></a></li>
				<li class="nav-item"><a class="nav-link" href="#tabUsers" data-toggle="tab"><?php echo $thisResource->appRptUsers ?></a></li>
				<li class="nav-item"><a class="nav-link" href="#tabProducts" data-toggle="tab" ><?php echo $thisResource->appRptProducts ?></a></li>
			</ul>
		</div>
	</div>
	
	<div class="tab-content">
<!-- tabSales -->
	<div class="tab-pane active" id="tabSales">
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<b id="sumSales"></b>
			</div>
		</div>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<div id="salesCanvasDiv">
					<canvas id="salesCanvas" style="border:1px solid lightgrey;" 
						onmousedown="saMouseDown(event)" onmousemove="saMouseMove(event)" onmouseup="saMouseUp(event)"></canvas>
					<div style="position: absolute; display:none; height:40px; width:100px; background-color:black; border-radius:5px;" id="salesPopup">
						<label id="salesPopupText" style="color: white; display:block; font-size:14px; text-align:center"></label>
					</div>
				</div>
				<label id="saMaxY" style="position: absolute;"></label>
				<label id="saMidY" style="position: absolute;"></label>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<table id="tableSales" class="table-sm" data-toggle="table">
					<thead class="thead-light">
						<tr>
						<th data-field="idx_date" data-width="50" data-width-unit="%">
							<?php echo $thisResource->appRptDate ?></th>
						<th data-field="idx_value" data-width="50" data-width-unit="%" data-align="right" data-halign="center">
							<?php echo $thisResource->appRptValue ?>(&euro;)</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- tabUsers -->
	<div class="tab-pane" id="tabUsers">
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<b id="sumUsers"></b>
			</div>
		</div>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<div id="usersCanvasDiv">
					<canvas id="usersCanvas" style="border:1px solid lightgrey;" 
						onmousedown="usMouseDown(event)" onmousemove="usMouseMove(event)" onmouseup="usMouseUp(event)"></canvas>
					<div style="position: absolute; display:none; height:40px; width:100px; background-color:black; border-radius:5px;" id="usersPopup">
						<label id="usersPopupText" style="color: white; display:block; font-size:14px; text-align:center"></label>
					</div>
				</div>
				<label id="usMaxY" style="position: absolute;"></label>
				<label id="usMidY" style="position: absolute;"></label>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<table id="tableUsers" class="table-sm" data-toggle="table">
					<thead class="thead-light">
						<tr>
						<th data-field="idx_date" data-width="50" data-width-unit="%">
							<?php echo $thisResource->appRptDate ?></th>
						<th data-field="idx_value" data-width="50" data-width-unit="%" data-align="right" data-halign="center">
							<?php echo $thisResource->appRptUserApply ?></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- tabProducts -->
	<div class="tab-pane" id="tabProducts">
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
				<table id="tableProducts" class="table-sm" data-toggle="table">
					<thead class="thead-light">
						<tr>
						<th data-field="id" data-width="0" data-width-unit="%" data-visible="false"></th>
						<th data-field="idx_image" data-width="10" data-width-unit="%"></th>
						<th data-field="idx_code" data-width="30" data-width-unit="%" data-sortable="true">
							<?php echo $thisResource->comProductNo ?></th>
						<th data-field="idx_browse" data-width="15" data-width-unit="%" data-align="center" data-sortable="true">
							<span class='fa fa-mouse-pointer'></span></th>
						<th data-field="idx_favorite" data-width="15" data-width-unit="%" data-align="center" data-sortable="true">
							<span class='fa fa-heart'></span></th>
						<th data-field="idx_cart" data-width="15" data-width-unit="%" data-align="center" data-sortable="true">
							<span class='fa fa-shopping-cart'></span></th>
						<th data-field="idx_buy" data-width="15" data-width-unit="%" data-align="center" data-sortable="true">
							<span class='fa fa-shopping-bag'></span></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
	
	</div> <!-- tab-content -->
	
	</div> <!-- container -->

<script src="js/ajax.js?2022-0403"></script>
<script src="js/sysfunc.js?2022-0403"></script>
<script src="js/modalSelTime.js?2022-0414"></script>

<script>
/************************************************************************************
	PHP VARIABLE
************************************************************************************/
var myRes = <?php echo json_encode($thisResource) ?>;

/************************************************************************************
	LOCAL VARIABLE
************************************************************************************/
var timeSel = {};
// sales
var $tableSales = $("#tableSales");
var sales = [];
var salesTotal = 0.00, saMminSales, saMaxSales;
var salesCanvasDiv = document.getElementById("salesCanvasDiv");
var salesCanvas = document.getElementById("salesCanvas");
var salesPopup = document.getElementById("salesPopup");
var salesPopupText = document.getElementById("salesPopupText");
var saMaxY = document.getElementById("saMaxY");
var saMidY = document.getElementById("saMidY");
var saIsMouseDown = false;
// users
var $tableUsers = $("#tableUsers");
var users = [];
var usersTotal = 0.00, usMminUsers, usMaxUsers;
var usersCanvasDiv = document.getElementById("usersCanvasDiv");
var usersCanvas = document.getElementById("usersCanvas");
var usersPopup = document.getElementById("usersPopup");
var usersPopupText = document.getElementById("usersPopupText");
var usMaxY = document.getElementById("usMaxY");
var usMidY = document.getElementById("usMidY");
var usIsMouseDown = false;
// products
var $tableProducts = $("#tableProducts");
var products = [];

/************************************************************************************
	INIT
************************************************************************************/
$(document).ready(function(){ 
	document.getElementById("myTitle").innerText = myRes['comAppReport'];
	mdstSetChecked("timeThisMonth");
	timeSel = mdstGetValue(0);
	searchAll();
	
	salesCanvasDiv.style.width = salesCanvas.offsetWidth + "px";
	usersCanvasDiv.style.width = usersCanvas.offsetWidth + "px";
 });
 
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

$tableSales.bootstrapTable({   
	formatNoMatches: function () {
         return myRes['sysMsgNoRecord'];
    }
});

$tableUsers.bootstrapTable({   
	formatNoMatches: function () {
         return myRes['sysMsgNoRecord'];
    }
});

$tableProducts.bootstrapTable({   
	formatNoMatches: function () {
         return myRes['sysMsgNoRecord'];
    }
});

function searchAll() {
	getRequest("apGetRptSales.php?"+timeSel, salesSearchYes, salesSearchNo);
	getRequest("apGetRptUsers.php?"+timeSel, usersSearchYes, usersSearchNo);
	getRequest("apGetRptProducts.php?"+timeSel, prdSearchYes, prdSearchNo);
}

window.addEventListener('click', function(e){ 
	if (!(salesCanvasDiv.contains(e.target))){
		salesPopup.style.display = "none";
		drawReport(salesCanvas, sales, saMaxSales, saMaxY, saMidY);
	}
	if (!(usersCanvasDiv.contains(e.target))){
		usersPopup.style.display = "none";
		drawReport(usersCanvas, users, usMaxUsers, usMaxY, usMidY);
	}
});

/********************************************************************
	SALES
********************************************************************/
function salesSearchYes(result) {
	sales = result;
	salesLoadTable();
}

function salesSearchNo(result) {
	sales = [];
	salesLoadTable();
}

function salesLoadTable() {
	salesTotal = 0.00;
	saMinSales = 10000000;
	saMaxSales = 0.00;
	var rows = [];

	for(var i=0; i<sales.length; i++){	
		salesTotal += parseFloat(sales[i]['value']);
		rows.push({
			idx_date: sales[i]['dateonly'].substr(2, 8),
			idx_value: sales[i]['value']
		});
		if (saMinSales >= parseFloat(sales[i]['value']))
			saMinSales = parseFloat(sales[i]['value']);
		if (saMaxSales <= parseFloat(sales[i]['value']))
			saMaxSales = parseFloat(sales[i]['value']);			
	}
	$tableSales.bootstrapTable('removeAll');
	$tableSales.bootstrapTable('append', rows);

	document.getElementById("sumSales").innerText = myRes['appRptValueSum'] + ": " + salesTotal.toFixed(2);	

	drawReport(salesCanvas, sales, saMaxSales, saMaxY, saMidY);
}

function saMouseDown(evt) {
	showPopup(0, evt, salesCanvas, sales, salesPopup, salesPopupText);
	saIsMouseDown = true;
}

function saMouseMove(evt) {
	if (saIsMouseDown) {
		showPopup(0, evt, salesCanvas, sales, salesPopup, salesPopupText);		
	}
}

function saMouseUp(evt) {
	saIsMouseDown = false;
}	

/********************************************************************
	USERS
********************************************************************/
function usersSearchYes(result) {
	users = result;
	usersLoadTable();
}

function usersSearchNo(result) {
	users = [];
	usersLoadTable();
}

function usersLoadTable() {
	usersTotal = 0;
	usMinUsers = 10000;
	usMaxUsers = 0;
	var rows = [];

	for(var i=0; i<users.length; i++){	
		usersTotal += parseInt(users[i]['value']);
		rows.push({
			idx_date: users[i]['dateonly'].substr(2, 8),
			idx_value: users[i]['value']
		});
		if (usMinUsers >= parseInt(users[i]['value']))
			usMinUsers = parseInt(users[i]['value']);
		if (usMaxUsers <= parseInt(users[i]['value']))
			usMaxUsers = parseInt(users[i]['value']);			
	}
	$tableUsers.bootstrapTable('removeAll');
	$tableUsers.bootstrapTable('append', rows);

	document.getElementById("sumUsers").innerText = myRes['appRptUserSum'] + ": " + usersTotal;
	
	drawReport(usersCanvas, users, usMaxUsers, usMaxY, usMidY);
}

function usMouseDown(evt) {
	usIsMouseDown = true;
	showPopup(1, evt, usersCanvas, users, usersPopup, usersPopupText);
}

function usMouseMove(evt) {
	if (usIsMouseDown) {
		showPopup(1, evt, usersCanvas, users, usersPopup, usersPopupText);		
	}
}

function usMouseUp(evt) {
	usIsMouseDown = false;
}

/********************************************************************
	DRAW
********************************************************************/
function drawReport(canvas, data, dataYMax, maxY, midY, index) {
	var width = canvas.offsetWidth;
	var height = canvas.offsetHeight;
	var ctx = canvas.getContext("2d");
	var x = 0, xr = width/(data.length-1), y = 0, yr = height/dataYMax;
	
	ctx.clearRect(0, 0, canvas.width, canvas.height);
	ctx.beginPath();
	ctx.lineWidth = 3;	
	for (var i=0; i<data.length; i++) {
		x = i*xr;
		y = height - parseFloat(data[i]['value'])*yr;
		if (i == 0)
			ctx.moveTo(x, y);
		else
			ctx.lineTo(x, y);
	}
	ctx.strokeStyle = "green";
	ctx.stroke();
	// middle line
	ctx.beginPath();
	ctx.lineWidth = 1;
	ctx.moveTo(0, height/2);
	ctx.lineTo(width, height/2);
	ctx.strokeStyle = "lightgrey";
	ctx.stroke();
	// popup line
	if (index) {
		ctx.beginPath();
		ctx.lineWidth = 1;
		ctx.moveTo(index*xr, 0);
		ctx.lineTo(index*xr, height);
		ctx.strokeStyle = "lightgrey";
		ctx.stroke();
	}
	
	maxY.style.left = width + 20 + "px";
	maxY.style.top = 0  + "px";
	maxY.innerText = dataYMax.toFixed(0);

	midY.style.left = width + 20 + "px";
	midY.style.top = height/2  + "px";
	midY.innerText = (dataYMax/2).toFixed(0);
}

function showPopup(option, evt, canvas, data, popup, popupText) {
	var width = canvas.offsetWidth;
	var xr = width/(data.length-1), x = 0;
	var pos = getMousePos(canvas, evt);
	var index = -1;
	
	for (var i=0; i<data.length; i++) {
		x = i*xr;
		if (pos.x >= x - 10 && pos.x <= x + 10) {
			index = i;
			break;
		}
	}
	
	if (index < 0)
		return;
	
	if (option == 0)
		drawReport(canvas, data, saMaxSales, saMaxY, saMidY, index);
	else
		drawReport(canvas, data, usMaxUsers, usMaxY, usMidY, index);
	
	popup.style.left = pos.x + 5 + "px";
	popup.style.top = pos.y + 5 + "px";
	popup.style.display = "block";
	popupText.innerHTML = "<p>"+data[index]['dateonly'].substr(2, 8)+"<br>"+data[index]['value']+"</p>";
}

function getMousePos(canvas, evt) {
	var rect = canvas.getBoundingClientRect();
	return {
		x: evt.clientX - rect.left,
		y: evt.clientY - rect.top
	};
}

/************************************************************************************
	TAB SWITCH
************************************************************************************/
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	var target = $(e.target).attr("href");
	if (target == "#tabUsers") {
		drawReport(usersCanvas, users, usMaxUsers, usMaxY, usMidY);
	} else {
		drawReport(salesCanvas, sales, saMaxSales, saMaxY, saMidY);
	}
});

/************************************************************************************
	TIME
************************************************************************************/
function selectTime(){
	$modalSelTime.modal();
}

function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
	 
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	
	timeSel = mdstGetValue(0);
	searchAll();
}

/********************************************************************
	PRODUCTS
********************************************************************/
function prdSearchYes(result) {
	products = result;
	prdLoadTable();
}

function prdSearchNo(result) {
	products = [];
	prdLoadTable();
}

function prdLoadTable() {
	var rows = [], imgSrc = "", imgStr = "";

	for(var i=0; i<products.length; i++){	
		imgSrc = products[i]['path']+"/"+products[i]['i_id']+"_"+products[i]['m_no']+"_s.jpg";
		imgStr = "<img width='60' height='60' style='object-fit: cover' src='"+imgSrc+"' >";
		rows.push({
			id: products[i]['i_id'],
			idx_image: imgStr,
			idx_code: products[i]['i_code'],
			idx_browse: products[i]['browse'],
			idx_favorite: products[i]['favorite'],
			idx_cart: products[i]['cart'],
			idx_buy: products[i]['buy']
		});	
	}
	$tableProducts.bootstrapTable('removeAll');
	$tableProducts.bootstrapTable('append', rows);
}

</script>

</body>
</html>