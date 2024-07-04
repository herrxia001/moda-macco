/* modalCustSearch */
// 2020-12-30 removed autocomplete for a_kcode
// 2021-01-04 mdsSearchCode
// 2021-01-20 load autocomplete from DB
// 2021-08-13 add name1

var $modalCustSearch = $("#modalCustSearch");
var mks_customer = {};
var mks_option = 0;
var mks_custs, mks_kcode, mks_kname, mks_kpost, mks_kustno, mks_name1;

$modalCustSearch.on('shown.bs.modal', function () {
	$("#mks_k_code").trigger('focus');
})

function getCustsYes(result) {
	mks_custs = result;	
	
	var name_id = document.getElementById("mks_k_name");
	var post_id = document.getElementById("mks_post");
	var ustno_id = document.getElementById("mks_ustno");
	var name1_id = document.getElementById("mks_name1");
	
	autoCusts(mks_custs, name_id, post_id, ustno_id, name1_id);
}

function autoCusts(custs, name_id, post_id, ustno_id, name1_id){	
	var a_kname = new Array(), a_kcode = new Array(), a_kpost = new Array(), a_kustno = new Array(), a_kname1 = new Array();

	a_kname = loadAutoList(custs, 'k_name');
	a_kcode = loadAutoList(custs, 'k_code'); 
	a_kpost = loadAutoList(custs, 'post');	
	a_kustno = loadAutoList(custs, 'ustno'); 
	a_kname1 = loadAutoList(custs, 'name1'); 
	
	autocomplete_like(name_id, a_kname);
	autocomplete(post_id, a_kpost);
	autocomplete(ustno_id, a_kustno);
	autocomplete_like(name1_id, a_kname1);
}

function getCusts() {
	getRequest("getCusts.php", getCustsYes, null);
}

function mksInit(option) {
	mks_customer = null;
	// option = 1, click next to close
	mks_option = option;
	// option = 2, search only
	if (mks_option == 2)
		document.getElementById("mksBtnNew").style.display = "none";

	document.getElementById("mks_k_code").value = "";
	document.getElementById("mks_k_name").value = "";
	document.getElementById("mks_post").value = "";
	document.getElementById("mks_ustno").value = "";
	document.getElementById("mks_name1").value = "";
	// autocomplete
	getCusts();
	
}

function mksGetCustById(id) {
	for (var i=0; i<mks_custs.length; i++) {
		if (mks_custs[i]['k_id'] == id)
			return mks_custs[i];
	}
	return null;
}

function mksGetCustByCode(code) {
	for (var i=0; i<mks_custs.length; i++) {
		if (mks_custs[i]['k_code'] == code)
			return mks_custs[i];
	}
	return null;
}

// Display customer data
function mksShowCust(id) {
	mks_customer = mksGetCustById(id);
	if (mks_customer == null)
		return;

	document.getElementById("mks_k_code").value = mks_customer['k_code'];
	document.getElementById("mks_k_name").value = mks_customer['k_name'];
	document.getElementById("mks_post").value = mks_customer['post'];
	document.getElementById("mks_ustno").value = mks_customer['ustno'];	
	document.getElementById("mks_name1").value = mks_customer['name1'];
}

// Show Customer modalCust
function mksNext() {
	var mks_k_code = document.getElementById("mks_k_code").value;

	if ((mks_customer == null || mks_customer['k_id'] == "") && mks_k_code != "") {
		mks_customer = mksGetCustByCode(mks_k_code);
		if (mks_customer == null) {
			$("#mks_k_code").trigger('focus');
			return false;
		}
	}

	if (mks_customer == null || mks_customer['k_id'] == "") {
		$("#mks_k_code").trigger('focus');
		return false;
	}

	$modalCustSearch.modal("toggle");
	
	if (mks_option) {
		mksDoneNext(mks_customer);
	}
	else {
		mkInit(mks_customer);
		$modalCust.modal();
	}		
}

// New customer modalCust
function mksNewCust(){
	$modalCustSearch.modal("toggle");

	mks_customer = new Object();	
	mks_customer['k_id'] = "";
	
	mkInit(mks_customer);
	$modalCust.modal();	
}

function doneAutocomp() {
	doneAutocompCust();
}

function doneAutocompCust() {
	var id = "";	
	var mks_k_name = document.getElementById("mks_k_name").value;
	var mks_post = document.getElementById("mks_post").value;
	var mks_ustno = document.getElementById("mks_ustno").value;
	var mks_name1 = document.getElementById("mks_name1").value;

	if (mks_k_code == "" && mks_k_name == "" && mks_post == "" && mks_ustno == "" && mks_name1 == "") {
		$("#mks_k_code").trigger('focus');
		return false;
	}

	var idx_name = mks_k_name.search("#");
	var idx_post = mks_post.search("#");
	var idx_ustno = mks_ustno.search("#");
	var idx_name1 = mks_name1.search("#");
	
	if (idx_name >= 0) {
		id = mks_k_name.substr(idx_name+1);
		mksShowCust(id);
		return;
	}
	if (idx_post >= 0) {
		id = mks_post.substr(idx_post+1);
		mksShowCust(id);
		return;
	}
	if (idx_ustno >= 0) {
		id = mks_ustno.substr(idx_ustno+1);
		mksShowCust(id);
		return;
	}
	if (idx_name1 >= 0) {
		id = mks_name1.substr(idx_name1+1);
		mksShowCust(id);
		return;
	}
}

function mdsSearchCode() {
	var code = document.getElementById("mks_k_code").value;
	document.getElementById("mks_k_name").value = "";
	document.getElementById("mks_post").value = "";
	document.getElementById("mks_ustno").value = "";
	document.getElementById("mks_name1").value = "";
	for (var i=0; i<mks_custs.length; i++) {
		if (mks_custs[i]['k_code'] == code) {
			document.getElementById("mks_k_name").value = mks_custs[i]['k_name'];
			document.getElementById("mks_post").value = mks_custs[i]['post'];
			document.getElementById("mks_ustno").value = mks_custs[i]['ustno'];
			document.getElementById("mks_name1").value = mks_custs[i]['name1'];
			mks_customer = mks_custs[i];
			break;
		}
	}
}
