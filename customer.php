<?php
/************************************************************************************
	File:		customer.php
	Purpose:	customer profile
************************************************************************************/

// Start session; If session expired, load the login page.
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include_once 'resource.php';
include_once 'db_functions.php';

// Load screen resources
$thisResource = new myResource($_SESSION['uLanguage']);
$backPhp = 'cust_list.php';

// Init variables

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(isset($_GET['back']))
	{
		$backPhp = $_GET['back'].'.php';
	}	
	if(isset($_GET['id']))
	{
		$myCustomer = dbQueryCustomerById($_GET['id']);
		if ($myCustomer <= 0)
		{
			header('Location:'.$backPhp);
			return;
		}
			
		$myId = $_GET['id'];
		$myCode = $myCustomer['k_code'];
		$myOrders = dbQueryCustOrders($myId, NULL, NULL);
		$mySumOrders = count($myOrders);
			
		// For payTab
		$myUnpaidCount = 0;
		$myPriceTotal = 0;
		$myUnpaidTotal = 0;
		for($i=0; $i<$mySumOrders; $i++)
		{
			if($myOrders[$i]['due'] <= 0)
				continue;
			$myUnpaidCount++;
			$myUnpaidTotal += $myOrders[$i]['due'];
			$myPriceTotal += $myOrders[$i]['total_sum'];
		}
	}
}

?>

<!doctype html>
<html lang="en">
<head>
	<?php include 'include/header.php' ?>
	<title>EUCWS - Customer</title>
<style>
body {
 padding-top: 0.2rem;
}
</style>
</head>

<body>
    <div class="container">
	
	<?php include "include/modalTime.php" ?>
	<?php include "include/modalOrder.php" ?>
	<?php include "include/modalItems.php" ?>
	
<!-- action button -->
	<div class="row">
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-1 bg-light" align="left">
			<a class="btn btn-secondary" href="<?php echo $backPhp ?>"  role="button"><span class='fa fa-arrow-left'></a>		
		</div>
		<div class="p-1 col-8 col-sm-8 col-md-4 col-lg-4 bg-light" align="center">
			<label id="myTitle"><?php echo $thisResource->fmCustTitle.$myCustomer['k_name'] ?></label>		
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-1 bg-light" align="right">	
			<button type="button" id="btnSave" name="btnSave" class="ml-2 btn btn-primary" onclick="saveCust()"><span class='fa fa-check'></button>
		</div>
	</div>
<!-- Tabs -->
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" id="tabPro" href="#profileTab"  data-toggle="tab"><?php echo $thisResource->fmCustTabPro ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="tabSal" href="#salesTab"  data-toggle="tab" onclick="showSalesTab()"><?php echo $thisResource->fmCustTabSal ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="tabPay" href="#payTab"  data-toggle="tab" onclick="showPayTab()"><?php echo $thisResource->fmCustTabPay ?></a>
		</li>
	</ul>
<!-- tab content -->
	<div class="tab-content">
<!-- tab profile -->	
		<div class="tab-pane active" id="profileTab">
		<hr>
<!-- k_id (hidden) -->
		<input type="text" class="form-control" id="k_id" name="k_id" value="<?php echo $myCustomer['k_id'] ?>" hidden>
<!-- k_code -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="k_id_cap" class="input-group-text"><?php echo $thisResource->fmCustCapId ?></span></div>
			<input type="text" class="form-control" id="k_code" name="k_code" value="<?php echo $myCustomer['k_code'] ?>" autofocus>			
		</div></div>		
<!-- k_name -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="k_name_cap" class="input-group-text"><?php echo $thisResource->fmCustCapName ?></span></div>
			<input type="text" class="form-control" id="k_name" name="k_name" value="<?php echo $myCustomer['k_name'] ?>">
		</div></div>
<!-- name1 -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="name1_cap" class="input-group-text"><?php echo $thisResource->fmCustCapName1 ?></span></div>
			<input type="text" class="form-control" id="name1" name="name1" value="<?php echo $myCustomer['name1'] ?>">
		</div></div>		
<!-- address -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="addr_cap" class="input-group-text"><?php echo $thisResource->fmCustCapAddr ?></span></div>
			<input type="text" class="form-control" id="address" name="address" value="<?php echo $myCustomer['address'] ?>">
		</div></div>
<!-- post -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="post_cap" class="input-group-text"><?php echo $thisResource->fmCustCapPost ?></span></div>
			<input type="text" class="form-control" id="post" name="post" value="<?php echo $myCustomer['post'] ?>">
		</div></div>
<!-- city -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="city_cap" class="input-group-text"><?php echo $thisResource->fmCustCapCity ?></span></div>
			<input type="text" class="form-control" id="city" name="city" value="<?php echo $myCustomer['city'] ?>">
		</div></div>
<!-- country -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="country_cap" class="input-group-text"><?php echo $thisResource->fmCustCapCountry ?></span></div>
			<input type="text" class="form-control" id="country" name="country" value="<?php echo $myCustomer['country'] ?>">
			<div class="input-group-append">
				<div class="dropdown dropleft">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"></button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="#" onclick="$('#country').val('Belgien')">Belgien</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#country').val('Deutschland')">Deutschland</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#country').val('Nederland')">Nederland</a></li>
					</ul>
				</div>
			</div>
		</div></div>
<!-- Tax No. -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="taxno_cap" class="input-group-text"><?php echo $thisResource->fmCustCapTaxNo ?></span></div>
			<input type="text" class="form-control" id="taxno" name="taxno" value="<?php echo $myCustomer['taxno'] ?>">
		</div></div>
<!-- Ust-IdNo. -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="ustno_cap" class="input-group-text"><?php echo $thisResource->fmCustCapUstNo ?></span></div>
			<input type="text" class="form-control" id="ustno" name="ustno" value="<?php echo $myCustomer['ustno'] ?>">
		</div></div>
<!-- tel -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="tel_cap" class="input-group-text"><?php echo $thisResource->fmCustCapTel ?></span></div>
			<input type="text" class="form-control" id="tel" name="tel" value="<?php echo $myCustomer['tel'] ?>">
		</div></div>
<!-- contact -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="contact_cap" class="input-group-text"><?php echo $thisResource->fmCustCapContact ?></span></div>
			<input type="text" class="form-control" id="contact" name="contact" value="<?php echo $myCustomer['contact'] ?>">
		</div></div>
<!-- email -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="email_cap" class="input-group-text"><?php echo $thisResource->fmCustCapEmail ?></span></div>
			<input type="text" class="form-control" id="email" name="email" value="<?php echo $myCustomer['email'] ?>">
		</div></div>
<!-- WhatsApp -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="whatsapp_cap" class="input-group-text"><?php echo $thisResource->fmCustCapWhatsApp ?></span></div>
			<input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $myCustomer['whatsapp'] ?>">
		</div></div>
<!-- WeChat -->
		<div class="row"><div class="input-group p-1 col-12 col-sm-12 col-md-8 col-lg-6"> 
			<div class="input-group-prepend"><span id="wechat_cap" class="input-group-text"><?php echo $thisResource->fmCustCapWeChat ?></span></div>
			<input type="text" class="form-control" id="wechat" name="wechat" value="<?php echo $myCustomer['wechat'] ?>">
		</div></div>
		</div> <!-- end of tab profile -->
<!-- tab sales-->
		<div class="tab-pane" id="salesTab">
			<hr>
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8" align="right">
					<button type="button" id="selTime" name="selTime" class="ml-2 btn btn-secondary" onclick="selectTime()"><?php echo $thisResource->mdTimeRdAll ?></button>
					<button type="button" id="selTime" name="selTime" class="ml-2 btn btn-secondary" onclick="showItems()"><?php echo $thisResource->fmCustBtnStItems ?></button>
				</div>
			</div>
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
					<a><?php echo $thisResource->fmCustCapStSumOrders ?></a><a style="color:blue" id="stSumOrders"></a>
					<a><?php echo $thisResource->fmCustCapStSumCount ?></a><a style="color:blue" id="stSumCount"></a>
					<a><?php echo $thisResource->fmCustCapStSumPrice ?></a><a style="color:blue" id="stSumPrice"></a>
				</div>				
			</div>
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
					<table id="tableSales" data-toggle="table">
						<thead>
							<tr>
							<th data-field="id" data-width="20" data-width-unit="%"><?php echo $thisResource->fmCustCapthId ?></th>
							<th data-field="idx_date" data-width="40" data-width-unit="%"><?php echo $thisResource->fmCustCapthDate ?></th>
							<th data-field="idx_count" data-width="20" data-width-unit="%"><?php echo $thisResource->fmCustCapthCount ?></th>
							<th data-field="idx_price" data-width="20" data-width-unit="%"><?php echo $thisResource->fmCustCapthSales ?></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div> <!-- end of tab sales -->
<!-- tab pay-->
		<div class="tab-pane" id="payTab">
			<hr>
			<div class="p-1 col-12 col-sm-12 col-md-8 col-lg-6">
				<a><?php echo $thisResource->fmCustCapPSumOrders ?></a><a style="color:blue" id="pSumOrders"><?php echo $myUnpaidCount ?></a>
				<a><?php echo $thisResource->fmCustCapPSumPrice ?></a><a style="color:blue" id="pSumPrice"><?php echo $myPriceTotal ?></a>
				<a><?php echo $thisResource->fmCustCapPSumUnpaid ?></a><a style="color:red" id="pSumUnpaid"><?php echo $myUnpaidTotal ?></a>
			</div>
			<div class="p-1 col-12 col-sm-12 col-md-8 col-lg-6">
				<table id="tablePay" data-toggle="table">
					<thead>
						<tr>
						<th data-field="id" data-width="30" data-width-unit="%"><?php echo $thisResource->fmCustCapthId ?></th>
						<th data-field="idx_date" data-width="30" data-width-unit="%"><?php echo $thisResource->fmCustCapthDate ?></th>
						<th data-field="idx_price" data-width="20" data-width-unit="%"><?php echo $thisResource->fmCustCapthPrice ?></th>
						<th data-field="idx_unpaid" data-width="20" data-width-unit="%"><?php echo $thisResource->fmCustCapthUnpaid ?></th>
						</tr>
					</thead>
					<tbody>
						<?php for($i=0; $i<$mySumOrders; $i++) if ($myOrders[$i]['due'] > 0) { ?>    
						<tr>
						<td><?php echo $myOrders[$i]['o_id'] ?></td>
						<td><?php echo substr($myOrders[$i]['date'], 0, 10) ?></td>
						<td><?php echo $myOrders[$i]['total_sum'] ?></td>
						<td><?php echo $myOrders[$i]['due'] ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div> <!-- end of tab pay -->
		
		</div> <!-- end of tab content -->
		
	</div> <!-- end of container -->	

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js"></script>
<script src="js/modalTime.js"></script>
<script src="js/modalOrder.js"></script>
<script src="js/modalItems.js"></script>
<script>

var kId = "";
var $table = $("#tableSales");
var orders = [], orderCounts = [], orderPrice = [], orderItems = [];
var sumOrders = 0, sumCount = 0, sumPrice = 0;
var salesLoaded = false;
var customer = new Object();

function tableSalesLoad(){	
	$table.bootstrapTable('removeAll');

	var rows = [];
	for(var i=0; i<sumOrders; i++){
		rows.push({
			id: orders[i]['o_id'],
			idx_date: orders[i]['date'].substring(0,10),
			idx_count: orderCounts[i],
			idx_price: orderPrice[i]
		});
	}
	$table.bootstrapTable('append', rows);	
	
	document.getElementById("stSumOrders").innerText = sumOrders;
	document.getElementById("stSumCount").innerText = sumCount;
	document.getElementById("stSumPrice").innerText = sumPrice;
}

function getOrderItems(result){
	orderItems = result; 

	for (var i=0; i<sumOrders; i++) {
		orderCounts[i] = 0;
		orderPrice[i] = 0;
		for (var j=0; j<orderItems[i].length; j++) {			
			orderCounts[i] += parseInt(orderItems[i][j]['count']);
			orderPrice[i] += parseInt(orderItems[i][j]['count'])*parseFloat(orderItems[i][j]['price']);
		}
		sumCount += orderCounts[i];
		sumPrice += orderPrice[i];
		orderPrice[i].toFixed(2);		
	}
	sumPrice.toFixed(2);
	
	tableSalesLoad();
}

function getOrders(result){
	orders = result;
	sumOrders = orders.length;
	var idList = [];
	for (var i=0; i<sumOrders; i++) {
		idList[i] = orders[i]['o_id'];
	}

	getRequest("getOrderItems.php?o_id="+JSON.stringify(idList), getOrderItems, null);
}

function emptyOrders(){
	alert(fmCustRes.msgNoRecordFound);
	
	orders = [];
	orderCounts = [];
	orderPrice = [];
	orderItems = [];
	sumOrders = 0;
	sumCount = 0;
	sumPrice = 0;

	$table.bootstrapTable('removeAll');
	document.getElementById("stSumOrders").innerText = sumOrders;
	document.getElementById("stSumCount").innerText = sumCount;
	document.getElementById("stSumPrice").innerText = sumPrice;
}

$(document).ready(function(){
	kId = "<?php echo $myId ?>";
	// Load all country codes
	var a_country = JSON.parse(localStorage.getItem("a_country")); 
	autocomplete(document.getElementById("country"), a_country);	
 })


// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
})

// Click a row to view order details
$('#tableSales').on('click-row.bs.table', function (e, row, $element) {
	$modalOrder.modal();

	var id = row.id, idx = 0;
	for(var i=0; i<orderItems.length; i++) {
		if(row.id == orderItems[i][0]['o_id'])
			idx = i;
	}
	mdOrderLoad(orderItems[idx]);
})

// Show time selection (modalTime)
function selectTime(){
	$modalTime.modal();	
}

// Finish time selection (modalTime)
function doneTime(){
	$modalTime.modal("toggle");	
	 
	var timeStr = mdTimeGetStr();	
	document.getElementById("selTime").innerText = timeStr;
	
	var timeResult = mdTimeGetValue();
	var link = "getOrderByCus.php?k_id="+kId;
	if (timeResult != "")
		link += "&"+timeResult;
	
	getRequest(link, getOrders, emptyOrders);
}

// Click sales TAB
function showSalesTab(){		
	if (!salesLoaded) {
		salesLoaded = true;
		getRequest("getOrderByCus.php?k_id="+kId, getOrders, emptyOrders);
	}
}

// Show all items
function showItems(){
	var allitems = new Array();
	var itemcount = 0, isExist = false;
	for (var i=0; i<orderItems.length; i++) {
		for (var j=0; j<orderItems[i].length; j++) {			
			if (itemcount == 0) {
				allitems[itemcount] = new Object();
				allitems[itemcount]['i_code'] = orderItems[i][j]['i_code'];
				allitems[itemcount]['i_name'] = orderItems[i][j]['i_name'];
				allitems[itemcount]['count'] = parseInt(orderItems[i][j]['count']);
				allitems[itemcount]['price'] = parseInt(orderItems[i][j]['count'])*parseFloat(orderItems[i][j]['price']);
				allitems[itemcount]['price'].toFixed(2);
				itemcount++;
			} else {
				isExist = false;
				for (var k=0; k<allitems.length; k++) {
					if(allitems[k]['i_code'] == orderItems[i][j]['i_code']) {
						isExist = true;
						allitems[k]['count'] += parseInt(orderItems[i][j]['count']);
						allitems[k]['price'] += parseInt(orderItems[i][j]['count'])*parseFloat(orderItems[i][j]['price']);
						allitems[k]['price'].toFixed(2);
					}
				}
				if(!isExist) {
					allitems[itemcount] = new Object();
					allitems[itemcount]['i_code'] = orderItems[i][j]['i_code'];
					allitems[itemcount]['i_name'] = orderItems[i][j]['i_name'];
					allitems[itemcount]['count'] = parseInt(orderItems[i][j]['count']);
					allitems[itemcount]['price'] = parseInt(orderItems[i][j]['count'])*parseFloat(orderItems[i][j]['price']);
					allitems[itemcount]['price'].toFixed(2);
					itemcount++;
				}
			}			
		}
	}
		
	$modalItems.modal();
	mdItemsLoad(allitems);
}

// Click pay TAB
function showPayTab(){

}

// Save
function saveBack(result) {
	var url = "<?php echo $backPhp; ?>"
	window.location.assign(url);
}

function getBackYes(result){
	alert("编号已存在。请输入其他编号");	
	$('#k_code').focus();
	return;	
}

function getBackNo(result){
	saveCustContinue();
}

function saveCustContinue() {
	if (customer['k_name'] == "") {
		$('#k_name').focus();
		return false;
	}	
	
	var link = "postCust.php";
	var form = new FormData();
	form.append('cust', JSON.stringify(customer));
	postRequest(link, form, saveBack, null);
}

function saveCust() {
	var kColumns = ['k_id', 'k_code', 'k_name', 'name1', 'address', 'post', 'city', 'country', 'tel', 'email', 'contact', 'taxno', 'ustno', 'whatsapp', 'wechat'];
	var kColumnTotal = 15;	
	var i= 0;
	
	for (i=0; i<kColumnTotal; i++) {
		customer[kColumns[i]] = document.getElementById(kColumns[i]).value;
	}		
	
	if (customer['k_code'] == "") {
		$('#k_code').focus();
		return false;
	}	
	if (customer['k_code'] == "<?php echo $myCode; ?>")
		saveCustContinue();
	else
		getRequest("getCustsByColumn.php?col=k_code&val="+customer['k_code'], getBackYes, getBackNo);	
}

</script>

</body>
</html>

