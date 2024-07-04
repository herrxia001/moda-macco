<?php
/************************************************************************************
	File:		app_mgt.php
	Purpose:	APP product management
************************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';

// Init variables
$thisResource = new myResource();
$myAppTypes = dbAppTypesQuery();

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>APP Product Management</title>
</head>

<style>
.dropdown-menu{
    max-height: 300px;
    overflow-y: scroll;
}
</style>

<body>
	<?php include 'include/nav.php' ?>		
	
	<div class="container">	
<!-- buttons -->
		<div class="row">
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4">
				<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->appStatus ?></span></div>
				<button type="button" class="p-1 ml-1 btn btn-outline-secondary button-l dropdown-toggle" id="status_str" data-toggle="dropdown">
					<?php echo $thisResource->appStatusNormal ?></button>
				<input type='hidden' id="status">
				<div class="dropdown-menu">
					<div class="dropdown-item" href="#" onclick="selStatus(this)"><?php echo $thisResource->appStatusNormal ?>
						<input type='hidden' value='0'></div>
					<div class="dropdown-item" href="#" onclick="selStatus(this)"><?php echo $thisResource->appStatusOffline ?>
						<input type='hidden' value='1'></div>
					<div class="dropdown-item" href="#" onclick="selStatus(this)"><?php echo $thisResource->appStatusRestock ?>
						<input type='hidden' value='2'></div>
					<div class="dropdown-item" href="#" onclick="selStatus(this)"><?php echo $thisResource->appAll ?>
						<input type='hidden' value='-1'></div>
				</div>
			</div>
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4">
				<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comAppTypes ?></span></div>			
				<button type="button" class="p-1 ml-1 btn btn-outline-secondary button-l dropdown-toggle" id="t_name" data-toggle="dropdown">
					<?php echo $thisResource->appAll ?></button>	
				<div class="dropdown-menu">
					<?php for($i=0; $i<count($myAppTypes); $i++) 
					echo "<div class='dropdown-item' href='#' onclick='selType(this)'>".$myAppTypes[$i]['t_name'].
					"<input type='hidden' value='".$myAppTypes[$i]['ap_t_id']."'></div>";
					?>
					<div class='dropdown-item' href='#' onclick='selType(this)'><?php echo $thisResource->appAll ?>
						<input type='hidden' value='-1'></div>
				</div>
			</div>
			<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4">
				<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->appTag ?></span></div>
				<button type="button" class="p-1 ml-1 btn btn-outline-secondary button-l dropdown-toggle" id="tag_str" data-toggle="dropdown">
					<?php echo $thisResource->appAll ?></button>
				<input type='hidden' id="tag">
				<div class="dropdown-menu">
					<div class="dropdown-item" href="#" onclick="selTag(this)"><?php echo $thisResource->appHot ?>
						<input type='hidden' value='0'></div>
					<div class="dropdown-item" href="#" onclick="selTag(this)"><?php echo $thisResource->appNew ?>
						<input type='hidden' value='1'></div>
					<div class="dropdown-item" href="#" onclick="selTag(this)"><?php echo $thisResource->appDiscount ?>
						<input type='hidden' value='2'></div>
					<div class="dropdown-item" href="#" onclick="selTag(this)"><?php echo $thisResource->appAll ?>
						<input type='hidden' value='-1'></div>
				</div>
			</div>
		</div>
		
<!-- Search result table -->
		<div class="row">
			<div class="p-1 input-group col-8 col-sm-8 col-md-8 col-lg-6">
				<div class="input-group-prepend"><span class="input-group-text" style="width:100px"><?php echo $thisResource->comID ?></span></div>
				<input type="text" class="form-control autocomplete" id="i_code" autofocus>
			</div>
			<div class="p-1 col-4 col-sm-4 col-md-4 col-lg-6" align="right">
				<label class="mt-2" id="lbSum"></label>
			</div>			
		</div>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
			<table id="table" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">
				<thead class="thead-light">
					<tr>
					<th class="p-1" data-field="id" data-width="0" data-width-unit="%" data-visible="false"></th>
					<th class="p-1" data-field="idx_image" data-width="10" data-width-unit="%"></th>									
					<th class="p-1" data-field="idx_code" data-width="30" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comID ?></th>
					<th class="p-1" data-field="idx_type" data-width="20" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comAppTypes ?></th>
					<th class="p-1" data-field="idx_count" data-width="15" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comQuantity ?></th>
					<th class="p-1" data-field="idx_price" data-width="15" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comPrice ?></th>
					<th class="p-1" data-field="idx_status" data-width="10" data-width-unit="%" data-halign="center" data-align="center" data-sortable="true"><?php echo $thisResource->appStatus ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
			</div>
		</div>	

</div> <!-- End of container -->

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?202102101708"></script>

<script>
/************************************************************************************
	PHP
************************************************************************************/
var myResource = <?php echo json_encode($thisResource) ?>; 
var myAppTypes = <?php echo json_encode($myAppTypes) ?>; 
/************************************************************************************
	LOCAL
************************************************************************************/
var $table = $("#table");
var myTag = -1, myType = -1, myStatus = -1;
var products = [];
var countTotal = 0;

/************************************************************************************
	INIT
************************************************************************************/
$(document).ready(function(){
	// Display Title
	document.getElementById("myTitle").innerHTML = myResource['comAppMgt'];

	// Tag
	myTag = localStorage.getItem("app_mgt_tag");
	if (myTag == null)
		myTag = "-1";
	document.getElementById("tag_str").innerText = getTagNameById(myTag);
	// Type
	myType = localStorage.getItem("app_mgt_type");
	if (myType == null)
		myType = "-1";
	document.getElementById("t_name").innerText = getTypeNameById(myType);
	// Status
	myStatus = localStorage.getItem("app_mgt_status");
	if (myStatus == null)
		myStatus = "-1";
	document.getElementById("status_str").innerText = getStatusNameById(myStatus);

	// Load table
	searchAll();
});
$table.bootstrapTable({   
	formatNoMatches: function () {
         return myResource['sysMsgNoRecord'];
    }
});
// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});
/************************************************************************************
	LOAD TABLE
************************************************************************************/
function searchYes(result) {
	products = result;
	loadTable();
}
function searchNo(result) {
	products = null;
	loadTable();
}
function searchAll() {
	getRequest("apGetProducts.php", searchYes, searchNo);
}
function displaySum(){
	document.getElementById("lbSum").innerText = myResource['comAppMgt']+": "+countTotal+" / "+products.length;
}
function loadTable(){
	if (products == null || products == 0){
		$table.bootstrapTable('removeAll');
		document.getElementById("lbSum").innerText = myResource['comAppMgt']+": 0 / 0";
		return;
	}

	var rows = []; 
	var imgSrc, imgStr;
	var a_code = [], a_image = [];
	countTotal = 0;
	for(var i=0; i<products.length; i++){
		if (myStatus != "-1" && products[i]['state'] != myStatus)
			continue;
		if (myType != "-1" && products[i]['ap_t_id'] != myType)
			continue; 
		if (myTag != "-1") { 
			if (myTag == "0" && products[i]['collections'][6] != "1")
				continue;
			if (myTag == "1" && products[i]['collections'][7] != "1")
				continue;
			if (myTag == "2" && products[i]['collections'][5] != "1")
				continue;
		}
		imgSrc = products[i]['path']+"/"+products[i]['i_id']+"_"+products[i]['m_no']+"_s.jpg";
		imgStr = "<img width='60' height='60' style='object-fit: cover' src='"+imgSrc+"' >";
		products[i]['t_name'] = getTypeNameById(products[i]['ap_t_id']);
		products[i]['status'] = getStatusNameById(products[i]['state']);
		rows.push({
			id: products[i]['i_id'],
			idx_image: imgStr,
			idx_code: products[i]['i_code'],
			idx_type: products[i]['t_name'],
			idx_count: products[i]['count'],
			idx_price: products[i]['price'],
			idx_status: products[i]['status']
		});
		
		a_code[countTotal] = products[i]['i_code'];
		a_image[countTotal] = imgSrc;
		countTotal++;
	}
	$table.bootstrapTable('removeAll');
	$table.bootstrapTable('append', rows);	
	displaySum();
	autocomplete(document.getElementById("i_code"), a_code, a_image);
	// maintain previous scroll position
	var pos = localStorage.getItem("app_mgt_scrolltop");
	if (pos != null)
		document.documentElement.scrollTop = pos;
	localStorage.setItem("app_mgt_scrolltop", 0);
}

/************************************************************************************
	VIEW
************************************************************************************/
// Click a row to view product
$('#table').on('click-row.bs.table', function (e, row, $element) {	
	// save the current scroll position
	var pos =  document.documentElement.scrollTop;
	localStorage.setItem("app_mgt_scrolltop", pos);
	// view product
	viewApp(row.id);
});

function doneAutocomp() {
	var code = document.getElementById("i_code").value;
	for (var i=0; i<products.length; i++) {
		if (products[i]['i_code'] == code) {
			viewApp(products[i]['i_id']);
			break;
		}
	}
}

function viewApp(id) {
	var url = "inv_view.php?back=app_mgt&id="+id;
	window.location.assign(url);
}
/************************************************************************************
	FILTER
************************************************************************************/
function getStatusNameById(id) {
	var name = "";
	switch(id) {
		case "0": name = myResource['appStatusNormal']; break;
		case "1": name = myResource['appStatusOffline']; break;
		case "2": name = myResource['appStatusRestock']; break;
		default: name = myResource['appAll'];
	}
	
	return name;
}

function selStatus(e) { 
	document.getElementById("status_str").innerText = $(e).text();
	myStatus = e.getElementsByTagName("input")[0].value; 
	localStorage.setItem("app_mgt_status", myStatus);
	
	loadTable();
}

function getTagNameById(id) {
	var name = "";
	switch(id) {
		case "0": name = myResource['appHot']; break;
		case "1": name = myResource['appNew']; break;
		case "2": name = myResource['appDiscount']; break;
		default: name = myResource['appAll'];
	}
	
	return name;
}

function selTag(e) {
	document.getElementById("tag_str").innerText = $(e).text();
	myTag = e.getElementsByTagName("input")[0].value; 
	localStorage.setItem("app_mgt_tag", myTag);
	
	loadTable();
}

function getTypeNameById(id) {
	if (id == "-1")
		return myResource['appAll'];
	
	for (var i=0; i<myAppTypes.length; i++) {
		if (myAppTypes[i]['ap_t_id'] == id) {
			return myAppTypes[i]['t_name'];
		}
	}
	
	return "";
}

function selType(e) {
	document.getElementById("t_name").innerText = $(e).text();
	myType = e.getElementsByTagName("input")[0].value; 
	localStorage.setItem("app_mgt_type", myType);
	
	loadTable();
}

</script>

</body>
</html>
