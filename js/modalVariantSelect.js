/************************************************************************************
	JS ModalVariantSelect
		2021-02-04: created file
		2021-02-18:	added new variant
************************************************************************************/

var $modalVariantSelect = $("#modalVariantSelect");
var mdvsMyId, mdvsMyCode, mdvsMyPath, mdvsMyPOId;
var mdvsMyOption; // option=0, purchase; option=1: order
var mdvsPurType = 0;
var mdvsVariant = null, mdvsVariantCount = 0, mdvsVariantTotal = 0;
var mdvsVariantMax = 100;

/********************************************************************
	Show modalVariantSelect
********************************************************************/
function mdvsShow(id, poid, code, path, option) {
	mdvsMyId = id; 
	mdvsMyPOId = poid;
	mdvsMyCode = code;
	mdvsMyPath = path;
	mdvsMyOption = option;	
	mdvsVariantCount = mdvsVariant.length;
	autoVariants(mdvs_new, a_variants);
	mdvsShowModal();
}
// Show modalVariantSelect
function mdvsShowModal() {
	mdvsInitVariant(); 
	mdvsShowVariant();		
	mdvDisplayTitle();
	
	$modalVariantSelect.modal();
}
// Init modalVariantSelect
function mdvsInitVariant() {	
	for (var i=0; i<mdvsVariantMax; i++) {			
		document.getElementById("mdvs_image_"+i).src = "blank.jpg";
		document.getElementById("mdvs_text_"+i).innerHTML = "";
		document.getElementById("mdvs_old_count_"+i).innerHTML = "";
		document.getElementById("mdvs_count_"+i).value = "";
		$('#mdvsItem_'+i).hide();
	}
	mdvsShowNew(false);
	document.getElementById("mdvsBtnAdd").disabled = false;
	if (mdvsMyOption)
		document.getElementById("mdvsBtnAdd").style.display = "none";
}
// Show new variant
function mdvsShowNew(option) {
	if (option) {
		document.getElementById("mdvs_new").style.display = "inline";
		document.getElementById("mdvsBtnVList").style.display = "inline";
		document.getElementById("mdvsBtnNewCancel").style.display = "inline";
		document.getElementById("mdvsBtnNewOk").style.display = "inline";
	} else {
		document.getElementById("mdvs_new").style.display = "none";
		document.getElementById("mdvsBtnVList").style.display = "none";
		document.getElementById("mdvsBtnNewCancel").style.display = "none";
		document.getElementById("mdvsBtnNewOk").style.display = "none";
	}
}
// Show variant
function mdvsShowVariant() {
	for (var i=0; i<mdvsVariantCount; i++) {
		if (mdvsVariant[i]['m_no'] != null) {
			var imgSrc = mdvsMyPath+"/"+mdvsMyId+"_"+mdvsVariant[i]['m_no']+".jpg";
			document.getElementById("mdvs_image_"+i).src = imgSrc;
			document.getElementById("mdvs_image_"+i).alt = imgSrc;
		}
		document.getElementById("mdvs_text_"+i).innerHTML = mdvsVariant[i]['variant'];
		if (mdvsMyOption) {
			document.getElementById("mdvs_old_count_"+i).innerHTML = "库存:&nbsp;"+mdvsVariant[i]['amount'];
		}
		if (mdvsVariant[i]['count'] == null || parseInt(mdvsVariant[i]['count']) <= 0)
			document.getElementById("mdvs_count_"+i).value = "";
		else
			document.getElementById("mdvs_count_"+i).value = mdvsVariant[i]['count'];
		$('#mdvsItem_'+i).show();
	}
}
// Show title
function mdvDisplayTitle() {
	mdvsVariantTotal = 0;
	for (var i=0; i<mdvsVariantCount; i++) { 
		var amount = document.getElementById("mdvs_count_"+i).value;
		if (amount == "")
			amount = "0";
		mdvsVariantTotal += parseInt(amount);
	}
	document.getElementById("mdvsTitle").innerHTML = "货号:&nbsp;&nbsp;"+mdvsMyCode+"&nbsp;&nbsp;&nbsp;&nbsp;件数:&nbsp;&nbsp;"+mdvsVariantTotal;
}
/********************************************************************
	Save & close modalVariantSelect
********************************************************************/
function mdvsDone() {
	for (var i=0; i<mdvsVariantCount; i++) {
		var vcount = document.getElementById("mdvs_count_"+i).value;
		if (!mdvsCheckCount(vcount)) {
			$('#mdvs_count_'+i).trigger('focus');
			return;
		}
		if (vcount == "")
			vcount = "0";
		vcount = parseInt(vcount).toString();
		var vdiff = parseInt(vcount) - parseInt(mdvsVariant[i]['count']);
		mdvsVariant[i]['count'] = vcount;
		mdvsVariant[i]['count_diff'] = vdiff;
		mdvsVariant[i]['i_id'] = mdvsMyId;
		if (mdvsMyOption == 1)
			mdvsVariant[i]['o_id'] = mdvsMyPOId;
		else
			mdvsVariant[i]['p_id'] = mdvsMyPOId;
	}
	$modalVariantSelect.modal("toggle");
	document.getElementById("m_count").value = mdvsVariantTotal.toString();
	mdvsDoneVariant();
}
/********************************************************************
	Functions
********************************************************************/
// Add count
function mdvsCountAdd(e) {
	var id = $(e).attr("id"); 
	var idx = parseInt(id.replace("mdvsBtnCountAdd_", ''));
	var countCtrl = document.getElementById("mdvs_count_"+idx);
	var v = countCtrl.value;
	if (v == "")
		v = "0";
	var d = parseInt(v);
	if (d == 8000000)
		return;
	d++;
	countCtrl.value = d.toString();
	mdvDisplayTitle();
}
// Minus count
function mdvsCountMinus(e) {
	var id = $(e).attr("id"); 
	var idx = parseInt(id.replace("mdvsBtnCountMinus_", ''));
	var countCtrl = document.getElementById("mdvs_count_"+idx);
	var v = countCtrl.value;
	if (v == "")
		return;
	var d = parseInt(v);
	if (d == 1)
		countCtrl.value = "";
	else {
		d--;
		countCtrl.value = d.toString();
	}
	mdvDisplayTitle();
}
// When mdvs_count_x loses focus
$(document).on('blur', "[id^=mdvs_count_]", function(){
	var v = $(this).val();
	if (!mdvsCheckCount(v)) {
		$(this).trigger('focus');
		return;
	}
	$(this).val(parseInt(v).toString());
	mdvDisplayTitle();
})
// Validate mdvs_count_x
function mdvsCheckCount(s) {
	if (s == "")
		return true;
	if (parseInt(s) < 0 || parseInt(s) > 8000000)
		return false;
	var d;
	for (var i=0; i<s.length; i++) {
		d = s[i];
		if (d < "0" || d > "9")
			return false;
	}
	return true;
}
/********************************************************************
	NEW
********************************************************************/
function mdvsAdd() {
	mdvsShowNew(true);
	document.getElementById("mdvsBtnAdd").disabled = true;
	document.getElementById("mdvs_new").value = "";
	$('#mdvs_new').trigger('focus');
}
// Choose variant from list
function selVariants(e) {
	var x = $(e).text();
	document.getElementById("mdvs_new").value = x;
}
function doneAutocompVariant() {
	
}
function mdvsNewOk() {
	var newv = document.getElementById("mdvs_new").value;
	if (newv == "") {
		$('#mdvs_new').trigger('focus');
		return;
	}
	for (var i=0; i<mdvsVariantCount; i++) {
		if (newv.toLowerCase() == mdvsVariant[i]['variant'].toLowerCase()) {
			alert("该款色已存在");
			$('#mdvs_new').trigger('focus');
			return;
		}
	}
	// add new variant
	var newVariant = new Object();
	newVariant['i_id'] = mdvsMyId;
	newVariant['variant'] = newv;
	newVariant['amount'] = "0";
	newVariant['count'] = "0";
	newVariant['barcode'] = mdvsNewBarcode();
	mdvsVariant[mdvsVariantCount] = newVariant;
	// hide new
	mdvsShowNew(false);
	// add new to table
	$('#mdvsItem_'+mdvsVariantCount).show();
	document.getElementById("mdvs_text_"+mdvsVariantCount).innerHTML = newv;
	document.getElementById("mdvs_count_"+mdvsVariantCount).value = "";
	mdvsVariantCount++;
	// database - add a new inv_variant
	form = new FormData();
	form.append('variant', JSON.stringify(newVariant));
	postRequest("postVariantAdd.php", form, mdvsDbAddYes, mdvsDbAddNo);
}
function mdvsNewCancel() {
	document.getElementById("mdvsBtnAdd").disabled = false;
	mdvsShowNew(false);
}
function mdvsDbAddYes(result) {
	var newIdx = mdvsVariantCount-1;
	mdvsVariant[newIdx]['iv_id'] = result;
	document.getElementById("mdvsBtnAdd").disabled = false;
	// database - add a new pur_varaint
	if (mdvsPurType == 1) {
		mdvsVariant[newIdx]['p_id'] = mdvsMyPOId;
		form = new FormData();
		form.append('purvariant', JSON.stringify(mdvsVariant[newIdx]));
		postRequest("postPurVariantAddOne.php", form, null, null); 
	}
}
function mdvsDbAddNo(result) {	
}
// Generate new barcode
function mdvsNewBarcode() {
	var newseq = 0, seq = 0;
	var seqStr = "";
	for (var i=0; i<mdvsVariantCount; i++) {
		if (mdvsVariant[i]['barcode'] != null && mdvsVariant[i]['barcode'] != "" && mdvsVariant[i]['barcode'].length > 6
			&& mdvsVariant[i]['barcode'].substr(0,6) == mdvsMyId) {
			seqStr = mdvsVariant[i]['barcode'].substr(6);
			seq = parseInt(seqStr);
			if (newseq <= seq)
				newseq = seq;
		}
	}
	newseq++;
	var newseqStr = newseq.toString();
	var j = 4-newseqStr.length;
	for (var i=0; i<j; i++) 
		newseqStr = "0" + newseqStr;
	var thisSeq = mdvsMyId+newseqStr;
	
	return thisSeq;
}

function mdvsShowImageView(e) {
	var altStr = $(e).attr("alt");
	if (altStr.includes("blank"))
		return;
	document.getElementById("mdvs_imageZoom").src = $(e).attr("alt");
	document.getElementById("mdvs_imageView").style.display = "block";
}

