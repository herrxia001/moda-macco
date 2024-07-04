
var $modalCust = $("#modalCustomer");
var mkColumns = ['k_id', 'k_code', 'k_name', 'name1', 'address', 'post', 'city', 'country', 'tel', 'email', 'contact', 
				'taxno', 'ustno', 'whatsapp', 'wechat', 'discount'];
var mkColumnTotal = 16, mkCode = "";
var mk_customer;

/************************************************************************
	INIT
************************************************************************/
function mkShow(customer) {
	mkInit(customer);
	$modalCust.modal();
}
function mkCancelCust() {
	$modalCust.modal("toggle");	
}
function mkInit(customer) {
	var i = 0;
	
	mkShowCustomer(customer);
	mkAutoFields();
	
	var a_country = JSON.parse(localStorage.getItem("a_country"));	
	autocomplete(document.getElementById("mk_country"), a_country);	
}
function mkShowCustomer(customer) {
	if (customer['k_id'] != "" && customer['k_id'] != "0") {
		for (i=0; i<mkColumnTotal; i++) {
			if (customer[mkColumns[i]] != null)
				document.getElementById("mk_"+mkColumns[i]).value = customer[mkColumns[i]];
			else
				document.getElementById("mk_"+mkColumns[i]).value = "";
		}
		mkCode = customer['k_code'];
	} else {
		for (i=0; i<mkColumnTotal; i++) {
			document.getElementById("mk_"+mkColumns[i]).value ="";
		}
	}
}
function mkAutoFields(){	
	acCustLoadControl("k_name", document.getElementById("mk_k_name"));
	acCustLoadControl("name1", document.getElementById("mk_name1"));
	acCustLoadControl("post", document.getElementById("mk_post"));
	acCustLoadControl("ustno", document.getElementById("mk_ustno"));	

	acCustLoadControl("address", document.getElementById("mk_address"));
	acCustLoadControl("city", document.getElementById("mk_city"));
	acCustLoadControl("tel", document.getElementById("mk_tel"));
}
/************************************************************************
	SAVE
************************************************************************/
function getBackYes(result){	
	$("#mk_k_code").trigger('focus');
	return;	
}

function getBackNo(result){
	mkDoneCustContinue();	
}

function mkSaveBack(result) { 
	mk_customer['k_id'] = result;
	$modalCust.modal("toggle");	
	mkSaveCust(mk_customer);
}

function mkDoneCustContinue() {
	if (mk_customer['k_name'] == "") {
		$("#mk_k_name").trigger('focus');
		return false;
	}	

	var link = "postCust.php";
	var form = new FormData();
	form.append('cust', JSON.stringify(mk_customer));
	postRequest(link, form, mkSaveBack, null);	
}

function mkDoneCust() {
	mk_customer = new Object();
	for (var i=0; i<mkColumnTotal; i++) {
		mk_customer[mkColumns[i]] = document.getElementById("mk_"+mkColumns[i]).value;
	}
	if (mk_customer['k_code'] == "") {
		$("#mk_k_code").trigger('focus');
		return false;
	}
	if (parseFloat(mk_customer['discount']) <0 || parseFloat(mk_customer['discount']) >=100) {
		mk_customer['discount'] = "";
		$("#mk_discount").trigger('focus');
		return false;
	}

	if (mk_customer['k_code'] == mkCode)
		mkDoneCustContinue();
	else
		getRequest("getCustsByColumn.php?col=k_code&val="+mk_customer['k_code'], getBackYes, getBackNo);			
}

/************************************************************************
	VAT NUMBER
************************************************************************/
var viesResult;
function validVIES() {
	var number = document.getElementById("mk_ustno").value;
	if (number == "" || number.length < 3) {
		$("#mk_ustno").trigger('focus');
		return;
	}
	
	var countryCode = (number.substring(0,2)).toUpperCase();
	var vatNumber = (number.substring(2)).toUpperCase();

	var link = "getVIES.php?countrycode="+countryCode+"&vatnumber="+vatNumber;
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			viesResult = this.responseText;
			alert(viesResult);
		};
	};
	xhr.open("GET", link, true);
	xhr.send();
}
function printVIES() {
	viesResult = viesResult.replaceAll(/(?:\r\n|\r|\n)/g, '<br />');
	var output = '<html><head><style type="text/css" media="print">@page { size:A4; margin:0.8cm 0.8cm 0.8cm 1.5cm; }\</style></head><body>';
	output += '<p>'+viesResult+'</p>';
	output += '</body></html>';
	
	var mywindow = window.open();
    mywindow.document.write(output);
	mywindow.document.close();
	mywindow.focus();
	if (/Android|iPhone|iPad/i.test(navigator.userAgent)) {
		mywindow.print();
		mywindow.onafterprint = function () {
			mywindow.close();
		} 
	}else {
		mywindow.onload = function () {
			mywindow.print();
			mywindow.close();
		}
	}
}
/************************************************************************
	AUTO K_CODE 
************************************************************************/
function mkGetCustNo() {
	var prefix = document.getElementById("mk_k_code").value;
	if (prefix != "")
		getRequest("getCustNo.php?prefix="+prefix, mkAutoCustYes, mkAutoCustNo);
	else
		getRequest("getCustNo.php", mkAutoCustYes, mkAutoCustNo);
}	
function mkAutoCustYes(result) {
	document.getElementById("mk_k_code").value = result;
}
function mkAutoCustNo(result) {
	document.getElementById("mk_k_code").value = "";
}
/************************************************************************
	AUTOCOMPLETE 
************************************************************************/
function mkSearchCode() {
	var code = document.getElementById("mk_k_code").value;
	var customer = mkGetCustByCode(code);
	if (customer == null) {
		customer = new Object();
		customer['k_id'] = "0";
		customer['k_code'] = code;
	}
	mkShowCustomer(customer);
	document.getElementById("mk_k_code").value = code;	
}
function doneAutocompCust(inp, id) {
	var customer = mkGetCustById(id);
	mkShowCustomer(customer);
}
/************************************************************************
	FUNCTIONS 
************************************************************************/
function mkGetCustByCode(code) {
	for (var i=0; i<customers.length; i++) {
		if (customers[i]['k_code'] == code)
			return customers[i];
	}
	return null;
}
function mkGetCustById(id) {
	for (var i=0; i<customers.length; i++) {
		if (customers[i]['k_id'] == id)
			return customers[i];
	}
	return null;
}
