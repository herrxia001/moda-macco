<?php
/********************************************************************************
	File:		pur_mgt.php
	Purpose:	purchase management
*********************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

// Init variables
$mySuppliers = dbQueryAllSuppliers();
$active[4] = "active";
?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS- Purchase Management</title>
</head>

<style>
.dropdown-menu{
    max-height: 300px;
    overflow-y: scroll;
}
</style>

<body>

	<?php include 'include/nav.php' ?>	
	<?php include "include/modalSelTime.php" ?>
<div class="container">	
<!-- buttons -->
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-4">
				<button type="button" class="btn btn-outline-secondary" id="selTime" onclick="selectTime()">
					<?php echo $thisResource->mdstRdThisMonth ?></button>
				<button type="button" class="p-1 ml-1 btn btn-outline-secondary dropdown-toggle" id="s_name" data-toggle="dropdown" style="width:100px">
					<?php echo $thisResource->comSupplierAll ?></button>
					<div class="dropdown-menu">
					<input type="text" style="position: sticky; top: 0; margin-left: 20px; margin-right: 20px; width: calc(100% - 40px);" class="form-control" placeholder="搜索.." id="myinput" oninput="filterFunction($(this))">
					<a class="dropdown-item" href="#" onclick="filterSup(this)"><?php echo $thisResource->comSupplierAll ?></a>
					<a class="dropdown-item" href="#" onclick="filterSup(this)"><?php echo $thisResource->comSupplierUnknown ?></a>
					<?php for($i=0; $i<count($mySuppliers); $i++)
						echo "<a class='dropdown-item' href='#' onclick='filterSup(this)'>".$mySuppliers[$i]['s_name']."</a>";
					?>
					</div>
			</div>
			<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-3 input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comProductNo ?></span></div>
				<input type="text" class="form-control" name="i_code" id="i_code">
				<button type="button" class="ml-1 btn btn-outline-secondary" onclick="allCode()"><?php echo $thisResource->appAll ?></button>
			</div>
			<div class="p-1 col-4 col-sm-4 col-md-4 col-lg-1" align="right">
				<button type="button" class="ml-1 btn btn-primary" onclick="newPur()"><span class='fa fa-plus'></button>
			</div>
		</div>	
<!-- summary -->
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-8" align="center" style="border:1px solid lightgray;">
				<a><?php echo $thisResource->comTotalRecord ?>:&nbsp;&nbsp;</a><a style="color:blue" id="purCount"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalQuantity ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumCount"></a>
				<a>&nbsp;&nbsp;<?php echo $thisResource->comTotalGross ?>:&nbsp;&nbsp;</a><a style="color:blue" id="sumCost"></a>
			</div>
		</div>
<!-- Search result table -->
		<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
		<table id="table" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">			
			<thead class="thead-light">
				<tr>
				<th class="p-1" data-field="id" data-width="0" data-width-unit="%" data-visible="false"></th>
				<th class="p-1" data-field="idx_date" data-width="25" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comTime ?></th>
				<th class="p-1" data-field="idx_no" data-width="25" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comPurchaseNo ?></th>
				<th class="p-1" data-field="idx_name" data-width="25" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comSupplier ?></th>
				<th class="p-1" data-field="idx_count" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comQuantity ?></th>
				<th class="p-1" data-field="idx_total" data-width="25" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->comValue ?></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		</div>
		</div>

		
	</div> <!-- End of container -->

</body>

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js"></script>
<script src="js/modalSelTime.js?012901"></script>
<script>
var myRes = <?php echo json_encode($thisResource) ?>;
var purs = new Array(), purCount = 0;
var $table = $("#table");
var link = "getPurs.php";
var sortCol = "p_date", sortOp = 1;
var countTotal = 0, costTotal = 0;
// i_code
var a_icode = JSON.parse(localStorage.getItem("a_icode"));
var a_image = JSON.parse(localStorage.getItem("a_image"));
// suppliers
var sups = <?php echo json_encode($mySuppliers) ?>;
var sId = "";

function getSupIdByName(name) {	
	if (name == myRes['comSupplierAll'])
		return "";
	if (name == myRes['comSupplierUnknwon'])
		return "0";

	for (var i=0; i<sups.length; i++) {
		if (sups[i]['s_name'] == name) {
			return sups[i]['s_id'];
			break;
		}
	}
	
	return "0";
}
function getSupNameById(sid) {
	if (sid == "")
		return myRes['comSupplierAll'];
	for (var i=0; i<sups.length; i++) {
		if (sups[i]['s_id'] == sid)
			return sups[i]['s_name'];
	}
	
	return myRes['comSupplierUnknwon'];
}

$table.bootstrapTable({   
	formatNoMatches: function () {
         return myRes['sysMsgNoRecord'];
    }
});

// Display summary
function displaySum(){
	document.getElementById("purCount").innerText = purCount;
	document.getElementById("sumCount").innerText = countTotal;
	document.getElementById("sumCost").innerText = costTotal.toFixed(2);
}

function loadTable(){
	countTotal = 0;
	costTotal = 0;
	if (purCount <= 0) {
		displaySum();
		return;
	}
	for(var i=0; i<purCount; i++){
		purs[i]['k_name'] = getSupNameById(purs[i]['s_id']);
	}	
	purs.sort(sortTable(sortCol, sortOp));
	$table.bootstrapTable('removeAll');
	var rows = [];
	for(var i=0; i<purCount; i++){		
		rows.push({
			id: purs[i]['p_id'],
			idx_date: purs[i]['p_date'].substring(0,10),
			idx_no: purs[i]['p_code'],
			idx_name: purs[i]['k_name'],
			idx_count: purs[i]['count_sum'],
			idx_total: purs[i]['cost_sum']
		});
		countTotal += parseInt(purs[i]['count_sum']);
		costTotal += parseFloat(purs[i]['cost_sum']);
	}
	$table.bootstrapTable('append', rows);	
	displaySum();
	// maintain previous scroll position
	var pos = localStorage.getItem("pur_mgt_scrolltop");
	document.documentElement.scrollTop = pos;
	localStorage.setItem("pur_mgt_scrolltop", 0)
}

function sortTable(key, option){
    return function(a, b){ 
		var x = a[key]; var y = b[key];
		if (key == "p_date") {
			var x1 = a[key].substring(0,10); var x2 = a[key].substring(11,19); x = x1+"T"+x2; x = new Date(x); 
			var y1 = b[key].substring(0,10); var y2 = b[key].substring(11,19); y = y1+"T"+y2; y = new Date(y);
		}
		if (key == "count_sum") {
			x= parseInt(x); y = parseInt(y);
		}
		if (key == "cost_sum") {
			x= parseFloat(x); y = parseFloat(y);
		}
		if(option == 1){
			return ((x < y) ? 1 : ((x > y) ? -1 : 0));
		}
		else {
			return ((x < y) ? -1 : ((x > y) ? 1 : 0));
		}  
    }    
}    

function afterSearch(result){
	purs = result;
	purCount = purs.length;
	loadTable();
}

function displayNo(result) {
	purs = null;
	purCount = 0;
	$table.bootstrapTable('removeAll');
	countTotal = 0;
	costTotal = 0;
	displaySum();
}

function searchPurs(){
	var timeResult = mdstGetValue(0);
	var code = document.getElementById("i_code").value;
	var link = "getPurs.php?";
	
	if (timeResult != "")
		link += timeResult;
	if (sId != "")
		link += "&s_id="+sId;
	if (code != "")
		link += "&i_code="+code;
	getRequest(link, afterSearch, displayNo);
}

/****************************************************************************
	INIT
****************************************************************************/
$(document).ready(function(){
	document.getElementById("myTitle").innerHTML = myRes['comPurchase'];
	autocomplete_like(document.getElementById("i_code"), a_icode, a_image);
	// time
	var timeChecked = localStorage.getItem("pur_mgt_timecheck");
	if (timeChecked == null)
		mdstSetChecked("timeThisMonth");
	else
		mdstSetChecked(timeChecked);
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	// supplier
	sId = localStorage.getItem("pur_mgt_supid");
	if (sId == null)
		sId = "";
	document.getElementById("s_name").innerText = getSupNameById(sId);
	// i_code
	var code = localStorage.getItem("pur_mgt_i_code");
	if (code == null)
		code = "";
	document.getElementById("i_code").value = code;
	// sort	
	sortCol = localStorage.getItem("pur_mgt_sortcol"); 
	sortOp = localStorage.getItem("pur_mgt_sortop");
	if (sortCol == null)
		sortCol = "p_date";
	if (sortOp == null)
		sortOp = 1;
	// search
	searchPurs();
 });

// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

/****************************************************************************
	View purchase
****************************************************************************/
$('#table').on('click-row.bs.table', function (e, row, $element) {
	// save the current scroll position
	var pos =  document.documentElement.scrollTop;
	localStorage.setItem("pur_mgt_scrolltop", pos);
	// view purchase
	var url = "purchase.php?back=pur_mgt&p_id="+row.id;
	window.location.assign(url);
});

/****************************************************************************
	SORT
****************************************************************************/
$('#table').on('sort.bs.table', function (e, name, order) {
	switch(name) {
		case "idx_date": sortCol = 'p_date';  break;
		case "idx_name": sortCol = 'k_name';  break;
		case "idx_count": sortCol = 'count_sum';  break;
		case "idx_total": sortCol = 'cost_sum';  break;
		default: sortCol = "p_date"; 
	}
	if (order == "asc")
		sortOp = 0;
	else
		sortOp = 1;
	localStorage.setItem("pur_mgt_sortcol", sortCol);
	localStorage.setItem("pur_mgt_sortop", sortOp); 
});

/****************************************************************************
	Filter by time
****************************************************************************/
function selectTime(){
	$modalSelTime.modal();	
}

function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
	 
	var timeStr = mdstGetStr();		
	document.getElementById("selTime").innerText = timeStr;
	// save time option
	var timeChecked = mdstGetChecked();
	localStorage.setItem("pur_mgt_timecheck", timeChecked);
	
	searchPurs();
}

/****************************************************************************
	New purchase
****************************************************************************/
function newPur() {
	var url = "purchase.php?back=pur_mgt";
	window.location.assign(url);
}

/****************************************************************************
	Filter by supplier
****************************************************************************/
function filterSup(e) {
	var x = $(e).text();
	document.getElementById("s_name").innerText = x;
	sId = getSupIdByName(x);
	localStorage.setItem("pur_mgt_supid", sId);
	
	searchPurs();
}

/****************************************************************************
	Search by i_code
****************************************************************************/
function doneAutocomp() {
	var code = document.getElementById("i_code").value;
	if (code == "")
		return;
	localStorage.setItem("pur_mgt_i_code", code);
	
	searchPurs();
}

function allCode() {
	document.getElementById("i_code").value = "";
	localStorage.setItem("pur_mgt_i_code", "");
	
	searchPurs();
}
/**
 * Filter funktion
 */
function filterFunction(obj) {
  var input, filter, ul, li, a, i;
  input = document.getElementById(obj.attr("id"));
  filter = input.value.toUpperCase();
  div = input.parentNode;
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>

</html>
