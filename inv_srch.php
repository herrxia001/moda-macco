<?php
/************************************************************************************
	File:		inv_srch.php
	Purpose:	search product
	
	2021-08-15: created
************************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include 'resource.php';
include 'db_functions.php';

// Init variables
$thisResource = new myResource($_SESSION['uLanguage']);

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Products</title>
</head>

<style>
.dropdown-menu{
    max-height: 300px;
    overflow-y: scroll;
}
.loader {
  position: fixed;
  left: 30%;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 80px;
  height: 80px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<body>
	<?php include 'include/nav.php' ?>
	<?php include "include/modalSelTime.php" ?>		
	
	<div class="container">	

		<div class="row">
			<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-1">
				<a class="btn btn-secondary" href="home.php" role="button"><span class='fa fa-arrow-left'></span></a>
			</div>
			<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-6 input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmInvMgtCapCode ?></span></div>
				<input type="text" class="form-control" name="i_code" id="i_code" autofocus>
			</div>
			<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-1" align="right">
				<button type="button" class="mx-1 btn btn-primary" id="btnNew" onclick="newInv()"><span class='fa fa-plus'></button>
			</div>
		</div>
		
		<div class="row">
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-4">
				<button type="button" class="p-1 btn btn-outline-secondary" id="selTime" onclick="selectTime()">
					<?php echo $thisResource->mdstRdToday ?></button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-4" align="right">
				<div class="dropdown">
				<button type="button" class="p-1 btn btn-outline-secondary dropdown-toggle" id="sortOption" data-toggle="dropdown">
					<?php echo $thisResource->fmInvMgtSUpdated ?></button>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#" onclick="doneSort(this)"><?php echo $thisResource->fmInvMgtSUpdated ?></a>
						<a class="dropdown-item" href="#" onclick="doneSort(this)"><?php echo $thisResource->fmInvMgtSCreated ?></a>
						<a class="dropdown-item" href="#" onclick="doneSort(this)"><?php echo $thisResource->fmInvMgtSCodeAZ ?></a>
						<a class="dropdown-item" href="#" onclick="doneSort(this)"><?php echo $thisResource->fmInvMgtSCodeZA ?></a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
			<table id="table" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">
				<thead class="thead-light">
					<tr>
					<th class="p-1" data-field="id" data-width="0" data-width-unit="%" data-visible="false"></th>
					<th class="p-1" data-field="idx_image" data-width="20" data-width-unit="%" data-sotable="true"><?php echo $thisResource->fmInvMgtCapImage ?></th>
					<th class="p-1" data-field="idx_data" data-width="80" data-width-unit="%"  data-sotable="true"><?php echo $thisResource->fmInvMgtCapData ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
			</div>
		</div>
		
		<div class="loader" id="loader"></div>
		
	</div> <!-- End of container -->

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?202108151504"></script>
<script src="js/modalSelTime.js"></script>

<script>

var invs;
var a_icode = new Array(), a_image = new Array();
var $table = $("#table");
var sortCol = "time_updated", sortOp = 1;
var fTime = new Object();

var timeChecked = localStorage.getItem("inv_srch_time"); 
if (timeChecked == null)
	timeChecked = "timeToday";	
mdstSetChecked(timeChecked);
var timeStr = mdstGetStr();	
document.getElementById("selTime").innerText = timeStr;
fTime = mdstGetValue(1);

sortCol = localStorage.getItem("inv_srch_sortcol");
sortOp = localStorage.getItem("inv_srch_sortop");
document.getElementById("sortOption").innerText = getSort();

document.getElementById("loader").style.display = "block";
getRequest("getInvs.php", loadInvs, loadInvsNo);

function loadInvs(result) {
	var imgFile;
	
	invs = result;
	for (var i = 0; i < result.length; i++) {
		a_icode[i] = result[i]['i_code'];
		imgFile = result[i]['path']+"/"+result[i]['i_id']+"_"+result[i]['m_no']+"_s.jpg";
		a_image[i] = imgFile;
	}	
	autocomplete_like(document.getElementById("i_code"), a_icode, a_image);
	
	loadTable();
	document.getElementById("loader").style.display = "none";
}
function loadInvsNo(result) {
	document.getElementById("loader").style.display = "none";
	alert("Error loading data");
}

/************************************************************************************
	INIT
************************************************************************************/
// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});
/************************************************************************************
	TABLE
************************************************************************************/
function loadTable() {
	invs.sort(sortTable(sortCol, sortOp));
	$table.bootstrapTable('removeAll');
	var rows = [];
	var dataStr, imgSrc, imgStr, todayStr;
	for(var i=0; i<invs.length; i++){
		var tu = invs[i]['time_updated'].substring(0,10)+"T"+invs[i]['time_updated'].substring(11,19);
		var tr = new Date(tu); 
		ftf = fTime['timefrom']+"T00:00:01"; ftt = fTime['timeto']+"T23:59:59"; 
		ftfr = new Date(ftf); fttr = new Date(ftt);
		if (tr < ftfr || tr > fttr)
			continue;
		if (invs[i]['i_name'] && invs[i]['i_name'] != '')
			dataStr = "<b>"+invs[i]['i_code']+"</b><br><a>"+invs[i]['i_name']+"</a>";
		else
			dataStr = "<b>"+invs[i]['i_code']+"</b>";
		imgSrc = invs[i]['path']+"/"+invs[i]['i_id']+"_"+invs[i]['m_no']+"_s.jpg";
		imgStr = "<img width='60' height='80' style='object-fit: cover' src='"+imgSrc+"'>";		
		rows.push({
			id: invs[i]['i_id'],
			idx_image: imgStr,
			idx_data: dataStr,
		});
	}
	$table.bootstrapTable('append', rows);
}
/************************************************************************************
	SEARCH
************************************************************************************/
function searchInv() {
	var code = document.getElementById("i_code").value;
	if (code == "")
		return false;	
	var id = "";
	for (var i=0; i<invs.length; i++) {
		if (invs[i]['i_code'] == code) {
			id = invs[i]['i_id'];
			break;
		}
	}
	if (id == "")
		return false;
	var url = "inv_view.php?back=inv_srch&id="+id;
	window.location.assign(url);
}
// This is a callback for autocomplete
function doneAutocomp() {
	searchInv();
}
/************************************************************************************
	NEW
************************************************************************************/
function newInv() { 	 
	var url = "inv_view.php?back=inv_srch";
	window.location.assign(url);
}
/************************************************************************************
	VIEW
************************************************************************************/
// Click a row to view product
$('#table').on('click-row.bs.table', function (e, row, $element) {	
	// save the current scroll position
	var pos =  document.documentElement.scrollTop;
	localStorage.setItem("inv_srch_scrolltop", pos);
	// view product
	var url = "inv_view.php?back=inv_srch&id="+row.id;
	window.location.assign(url);
});
/************************************************************************************
	SORT
************************************************************************************/
function getSort() {
	var x = "";
	if (sortCol == 'time_created' && sortOp == 1)
		x = "<?php echo $thisResource->fmInvMgtSCreated ?>";
	else if (sortCol == 'i_code' && sortOp == 0)
		x = "<?php echo $thisResource->fmInvMgtSCodeAZ ?>";
	else if (sortCol == 'i_code' && sortOp == 1)
		x = "<?php echo $thisResource->fmInvMgtSCodeZA ?>";
	else
		x = "<?php echo $thisResource->fmInvMgtSUpdated ?>";
	
	return x;
}
function doneSort(e){
	var x = $(e).text();

	switch(x) {
		case "<?php echo $thisResource->fmInvMgtSCreated ?>": sortCol = 'time_created'; sortOp = 1; break;
		case "<?php echo $thisResource->fmInvMgtSCodeAZ ?>": sortCol = 'i_code'; sortOp = 0; break;
		case "<?php echo $thisResource->fmInvMgtSCodeZA ?>": sortCol = 'i_code'; sortOp = 1; break;
		default: sortCol = 'time_updated'; sortOp = 1;
	}
	localStorage.setItem("inv_srch_sortcol", sortCol);
	localStorage.setItem("inv_srch_sortop", sortOp);
	document.getElementById("sortOption").innerText = x;
	loadTable();
}
// Sort table
function sortTable(key, option){ 
    return function(a, b){ 
		var x = a[key]; var y = b[key];
		if (key == "time_created" || key == "time_updated") {
			var x1 = a[key].substring(0,10); var x2 = a[key].substring(11,19); x = x1+"T"+x2; x = new Date(x); 
			var y1 = b[key].substring(0,10); var y2 = b[key].substring(11,19); y = y1+"T"+y2; y = new Date(y);
		} 
		if(option == 1){
			return ((x < y) ? 1 : ((x > y) ? -1 : 0));
		}
		else {
			return ((x < y) ? -1 : ((x > y) ? 1 : 0));
		}  
    }    
}
/************************************************************************************
	TIME
************************************************************************************/
// Show time selection (modalTime)
function selectTime(){
	$modalSelTime.modal();	
}

// Finish time selection (modalTime)
function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
	 
	timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;	
	timeChecked = mdstGetChecked();
	localStorage.setItem("inv_srch_time", timeChecked);
	fTime = mdstGetValue(1);
	
	loadTable();
}
/************************************************************************************
	FUNCTIONS
************************************************************************************/
function getToday() {
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); 
	var yyyy = today.getFullYear();
	
	return yyyy+"-"+mm+"-"+dd;
}

</script>

</body>
</html>
