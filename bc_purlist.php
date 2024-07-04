<?php
/********************************************************************************
	File:		bc_purlist.php
	Purpose:	purchase list for barcode
	2021-04-18: created file
*********************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:bc_index.php");

// Include files
include 'resource.php';
include 'db_functions.php';

// Init variables
$thisResource = new myResource($_SESSION['uLanguage']);
$mySuppliers = dbQueryAllSuppliers();

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header_bc.php' ?>
	<title>EUCWS-BARCODE</title>
</head>

<style>
.dropdown-menu{
    max-height: 300px;
    overflow-y: scroll;
}
</style>

<body>
	<?php include "include/modalSelTime.php" ?>
<div class="container">	
<!-- buttons -->
	<div class="row">
		<div class="input-group p-1 col-10 col-sm-10 col-md-10 col-lg-6">
			<button type="button" class="btn btn-outline-secondary" id="selTime" onclick="selectTime()" style="width:210px">
				<?php echo $thisResource->mdstRdThisMonth ?></button>
			<button type="button" class="p-1 ml-1 btn btn-outline-secondary dropdown-toggle" id="s_name" data-toggle="dropdown" style="width:100px">
				全部厂家</button>
				<div class="dropdown-menu">
				<a class="dropdown-item" href="#" onclick="filterSup(this)">全部厂家</a>
				<a class="dropdown-item" href="#" onclick="filterSup(this)">未知厂家</a>
				<?php for($i=0; $i<count($mySuppliers); $i++)
					echo "<a class='dropdown-item' href='#' onclick='filterSup(this)'>".$mySuppliers[$i]['s_name']."</a>";
				?>
			</div>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" align="right">
			<button type="button" class="btn btn-secondary" onclick="backHome()"><?php echo $thisResource->bcBack ?></button>
		</div>
	</div>	
<!-- Search result table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
		<table id="table" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">			
			<thead class="thead-light">
				<tr>
				<th class="p-1" data-field="id" data-width="0" data-width-unit="%" data-visible="false"></th>
				<th class="p-1" data-field="idx_date" data-width="20" data-width-unit="%" data-sortable="true"><?php echo $thisResource->bcListDate ?></th>
				<th class="p-1" data-field="idx_purno" data-width="20" data-width-unit="%" data-sortable="true"><?php echo $thisResource->bcListPNo ?></th>
				<th class="p-1" data-field="idx_name" data-width="30" data-width-unit="%" data-sortable="true"><?php echo $thisResource->bcListSup ?></th>
				<th class="p-1" data-field="idx_count" data-width="10" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->bcListCount ?></th>
				<th class="p-1" data-field="idx_total" data-width="20" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->bcListValue ?></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		</div>
	</div>		
</div> <!-- End of container -->

<script src="js/ajax.js"></script>
<script src="js/modalSelTime.js?012901"></script>
<script>

var purs = new Array(), purCount = 0;
var $table = $("#table");
var link = "getPurs.php";
var sortCol = "p_date", sortOp = 1;

// Load suppliers
var sups = <?php echo json_encode($mySuppliers) ?>;
var sId = "";

function getSupIdByName(name) {	
	if (name == "全部厂家")
		return "";
	if (name == "未知厂家")
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
	for (var i=0; i<sups.length; i++) {
		if (sups[i]['s_id'] == sid)
			return sups[i]['s_name'];
	}
	
	return "未知厂家";
}

$table.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});

function loadTable(){
	$table.bootstrapTable('removeAll');
	purs.sort(sortTable(sortCol, sortOp));
	var rows = [];
	for(var i=0; i<purCount; i++){
		purs[i]['k_name'] = getSupNameById(purs[i]['s_id']);
		rows.push({
			id: purs[i]['p_id'],
			idx_date: purs[i]['p_date'].substring(0,10),
			idx_purno: purs[i]['p_code'],
			idx_name: purs[i]['k_name'],
			idx_count: purs[i]['count_sum'],
			idx_total: purs[i]['cost_sum']
		});
	}
	$table.bootstrapTable('append', rows);	
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
	$table.bootstrapTable('removeAll');
}

function searchPurs(){
	var timeResult = mdstGetValue(0);
	var link = "getPurs.php?";
	if (timeResult != "")
		link += timeResult;
	if (sId != "")
		link += "&s_id="+sId;
	getRequest(link, afterSearch, displayNo);
}
$(document).ready(function(){
	// Time
	mdstSetChecked("timeThisMonth");
	// Search by default
	searchPurs();
 });
// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});
// Click a row to view purchase
$('#table').on('click-row.bs.table', function (e, row, $element) {
	var url = "bc_purchase.php?p_id="+row.id;
	window.location.assign(url);
});
// Show time selection (modalTime)
function selectTime(){
	$modalSelTime.modal();	
}
// Finish time selection (modalTime)
function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
	 
	var timeStr = mdstGetStr();		
	document.getElementById("selTime").innerText = timeStr;
	
	searchPurs();
}
// Filter by supplier
function filterSup(e) {
	var x = $(e).text();
	document.getElementById("s_name").innerText = x;

	sId = getSupIdByName(x);
	
	searchPurs();
}
// Back to Home
function backHome() {
	window.location.assign("bc_home.php");
}
</script>

</body>
</html>
