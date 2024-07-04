<?php

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>	
<title>EUCWS APP TEST</title>
</head>

<body>
	<br>
    <div class="container">
		<div class="row">
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="getInvs" name="getAllInvs" class="btn btn-secondary" 
					onclick="testGetInvs()">getInvs</button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="getVariants" name="getAllInvs" class="btn btn-secondary" 
					onclick="testGetVariants()">getVariants</button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="postCompanyUpdate" name="postCompanyUpdate" class="btn btn-secondary" 
					onclick="testPostCompanyUpdate()">postCompanyUpdate</button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="postCompanyAdd" name="postCompanyAdd" class="btn btn-secondary" 
					onclick="testPostCompanyAdd()">postCompanyAdd</button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="postApplyShop" name="postApplyShop" class="btn btn-secondary" 
					onclick="testPostApplyShop()">postApplyShop</button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="postApplyShopAgain" name="postApplyShopAgain" class="btn btn-secondary" 
					onclick="testPostApplyShopAgain()">postApplyShopAgain</button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="getShopStatus" name="getShopStatus" class="btn btn-secondary" 
					onclick="testGetApplyStatus()">getApplyStatus</button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="postOrderAdd" name="postOrderAdd" class="btn btn-secondary" 
					onclick="testPostOrderAdd()">postOrderAdd</button>
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3 center">
				<button type="button" id="getOrderStatus" name="getOrderStatus" class="btn btn-secondary" 
					onclick="testGetOrderStatus()">getOrderStatus</button>
			</div>
		</div>
	</div>

<script>

// AJAX - GET
function getRequest(link, cb, cb1){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var result = JSON.parse(this.responseText);
			if(result != "-1" && result != "-2"){
				if(cb) cb(result);
			}
			else{
				if(cb1) cb1(result);
			}
		};
	};
	xhr.open("GET", link, true);
	xhr.send();
}

// AJAX - POST
function postRequest(link, form, cb, cb1){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var result = JSON.parse(this.responseText);
			if(result != "-1" && result != "-2"){
				if(cb) cb(result);
			}
			else{
				if(cb1) cb1(result);
			}
		}
	}
	xhr.open('POST', link, true);
	xhr.send(form);
}

function returnYes(result) {
	alert(JSON.stringify(result));
}
function returnNo(result) {
	alert(result);
}

function testPostCompanyUpdate() {
	var company = {};
	company['apc_name'] = "TestUpdate GmbH";
	company['type'] = "0";
	company['areacode'] = "49";
	company['country'] = "Germany";
	company['address'] = "Hauptstr. 1";
	company['address1'] = "Apt 2";
	company['post'] = "40614";
	company['city'] = "Neuss";
	company['contact'] = "Tom Lee";
	company['taxno'] = "DE123456789";
	company['email'] = "lee@test.com";
	company['cell'] = "01459086788";
	company['whatsapp'] = "01754679234";
	company['tel'] = "21312 788 7980";
	company['memo'] = "This is a test";
	var form = new FormData();
	form.append('apc_id', "10");
	form.append('app_company', JSON.stringify(company));
	postRequest('apPostCompanyUpdate.php', form, returnYes, returnNo);	
}

function testPostCompanyAdd() {
	var company = {};
	company['apc_name'] = "TestAdd GmbH";
	company['type'] = "0";
	company['areacode'] = "49";
	company['country'] = "Germany";
	company['address'] = "Hauptstr. 1";
	company['address1'] = "Apt 2";
	company['post'] = "40614";
	company['city'] = "Neuss";
	company['contact'] = "Tom Lee";
	company['taxno'] = "DE123456789";
	company['email'] = "lee@test.com";
	company['cell'] = "01459086788";
	company['whatsapp'] = "01754679234";
	company['tel'] = "21312 788 7980";
	company['memo'] = "This is a test";
	var form = new FormData();
	form.append('db', "test");
	form.append('app_company', JSON.stringify(company));
	postRequest('apPostCompanyAdd.php', form, returnYes, returnNo);	
}

function testPostOrderAdd() {
	var order = {};
	order['c_id'] = "1";
	order['apc_id'] = "2";
	var form = new FormData();
	form.append('order', JSON.stringify(order));
	postRequest('apPostOrderAdd.php', form, returnYes, returnNo);	
}

function testPostApplyShop() {
	var form = new FormData();
	form.append('c_id', "13");
	form.append('apc_id', "20");
	postRequest('apPostApplyShop.php', form, returnYes, returnNo);	
}

function testPostApplyShopAgain() {
	var form = new FormData();
	form.append('c_id', "13");
	form.append('apc_id', "20");
	postRequest('apPostApplyShopAgain.php', form, returnYes, returnNo);	
}

function testGetApplyStatus() {
	getRequest('apGetApplyStatus.php?db=test&apc_id=11', returnYes, returnNo);
}

function testGetInvs() {
	getRequest('apGetInvs.php?db=test', returnYes, returnNo);
}

function testGetVariants() {
	getRequest('apGetVariants.php?db=test&i_id=101302', returnYes, returnNo);
}

function testGetOrderStatus() {
	getRequest('apGetOrderStatus.php?db=test&k_id=42452', returnYes, returnNo);
}

</script>

</body>
</html>
