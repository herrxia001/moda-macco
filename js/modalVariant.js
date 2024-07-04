
var $modalVariant = $("#modalVariant");
var mdvMyId, mdvMyOption, mdvCode1;
var myVariant = new Array(), nVariantCount = 0, nVariantTotal = 0;
var nVariantMax = 100;
var lastVariant;
var selImageId = -1;
var selVariantId = -1;

// Show variant
function mdvDisplayVariant(id, option, code1) {
	mdvMyId = id;
	mdvMyOption = option; 
	mdvCode1 = code1;
	autoVariants(mdv_variant, a_variants);
	
	if (mdvMyOption == 1) 
		getRequest("getVariant.php?i_id="+mdvMyId, mdvGetVariantYes, mdvGetVariantNo);
	else 
		mdvShowModal();
}
// Get variant back - purchase
function mdvGetVariantPurYes(result) {
	myVariant = result;
	nVariantCount = myVariant.length; 
	getRequest("getImages.php?id="+mdvMyId, mdvGetImagesYes, mdvGetImagesNo);
}
function mdvGetVariantPurNo(result) {
	mdvShowModal();
}
function mdvGetImagesYes(result) {
	mdvImages = result;
	mdvImageCount = mdvImages.length;		
	for(var i=0; i<mdvImageCount; i++){
		if(parseInt(mdvImages[i]['m_no']) > mdvImageNoCount)
			mdvImageNoCount = parseInt(mdvImages[i]['m_no']);
	} 
	mdvImageNoCount++; 
	mdvShowModal();	
}
function mdvGetImagesNo(result) {
	alert(result);
}
// Get variant back
function mdvGetVariantYes(result) {
	myVariant = result;
	nVariantCount = myVariant.length;
	mdvShowModal();
}
function mdvGetVariantNo(result) {
	mdvShowModal();
}
// Show modalVariant
function mdvShowModal() {
	mdvInitVariant(); 
	for (var i=0; i<nVariantCount; i++) { 
		mdvShowVariant(i, myVariant[i]);
	}
	if (nVariantCount == nVariantMax)
		document.getElementById("mdvBtnAdd").style.display = "none";
	mdvDisplayTotal();	
	$modalVariant.modal();
}
// Init modalVariant
function mdvInitVariant() {	
	$('#mdvDataContainer').hide();
	mdvEmptyInput();
	mdvEmptyImages();
	for (var i=0; i<nVariantMax; i++) {					
		mdvEmptyVariant(i);
	}
	// Show images in image selection
	for (var i=0; i<imgCount; i++) {
		var imgSrc = document.getElementById("image_"+i).src;
		var img = document.getElementById("mdsi_image_"+i);
		img.src = imgSrc;
		img.style.display = "inline";
	}
	for (var i=imgCount; i<nVariantMax; i++) {
		var img = document.getElementById("mdsi_image_"+i);
		img.style.display = "none";		
	}
}
// Display variant total
function mdvDisplayTotal() {
	nVariantTotal = 0;
	for (var i=0; i<nVariantCount; i++) { 
		nVariantTotal += parseInt(myVariant[i]['amount']);
	}	
	document.getElementById("mdvTitle").innerHTML = myRes['comVariant']+"&nbsp;&nbsp;"+nVariantCount+"<br>"+myRes['comQuantity']+"&nbsp;&nbsp;"+nVariantTotal;
}
// Empty input field
function mdvEmptyInput() {
	document.getElementById("mdv_variant").value = "";
	document.getElementById("mdv_variant_size").value = "";
	document.getElementById("mdv_amount").value = "";
	document.getElementById("mdv_code").value = "";
}
// Empty one variant (in list)
function mdvEmptyVariant(idx) {
	document.getElementById("mdv_image_"+idx).style.display = "none";
	document.getElementById("mdv_image_"+idx).src = "blank.jpg";
	document.getElementById("mdv_textv_"+idx).style.display = "none";
	document.getElementById("mdv_textv_"+idx).innerHTML = "";
	document.getElementById("mdv_texta_"+idx).style.display = "none";
	document.getElementById("mdv_texta_"+idx).innerHTML = "";
	document.getElementById("mdv_textc_"+idx).style.display = "none";
	document.getElementById("mdv_textc_"+idx).innerHTML = "";
	document.getElementById("mdv_texts_"+idx).style.display = "none";
	document.getElementById("mdv_texts_"+idx).innerHTML = "";
}
// Show one variant
function mdvShowVariant(idx, variant) {
	document.getElementById("mdv_image_"+idx).style.display = "block";
	var imgSrc = "blank.jpg";
	if (variant['m_no'] != "") {
		var imgId = mdvGetImgIdByNo(variant['m_no']);
		if (imgId >= 0)
			imgSrc = document.getElementById("image_"+imgId).src;		
	}
	document.getElementById("mdv_image_"+idx).src = imgSrc;
	document.getElementById("mdv_textv_"+idx).style.display = "block";
	document.getElementById("mdv_textv_"+idx).innerHTML = myRes['comVariant']+"&nbsp;"+variant['variant'];
	document.getElementById("mdv_texta_"+idx).style.display = "block";
	document.getElementById("mdv_texta_"+idx).innerHTML = myRes['comQuantity']+"&nbsp;"+variant['amount'];
	document.getElementById("mdv_textc_"+idx).style.display = "block";
	if(variant['size'] !== null && variant['size'] != ""){
		document.getElementById("mdv_texts_"+idx).innerHTML = myRes['comVariantSize']+"&nbsp;"+variant['size'];
		document.getElementById("mdv_texts_"+idx).style.display = "block";
	}
	if (variant['barcode'] != null)
		document.getElementById("mdv_textc_"+idx).innerHTML = myRes['comBarcode']+"&nbsp;"+variant['barcode'];
}
/********************************************************************
	Save & close modalVariant
********************************************************************/
// Done modalVariant
function mdvDone() {
	mdvCloseInput();
	mdvShowList();
	$modalVariant.modal("toggle");
	if (nVariantCount > 0) {
		document.getElementById("count").value = nVariantTotal.toString();
		document.getElementById("count").readOnly = true;
	} else {
		document.getElementById("count").readOnly = false;
	}
}
/********************************************************************
	Add new item
********************************************************************/
// Add item
function mdvAdd() {
	document.getElementById("mdvDataTitle").innerHTML = myRes['comAdd'];
	mdvHideList();
	$('#mdvDataContainer').show();
	mdvShowButtons(0);
	$('#mdv_variant').trigger('focus');	
}
// Choose variant from list
function selVariants(e) {
	var x = $(e).text();
	document.getElementById("mdv_variant").value = x;
}
// Choose variant Size from list
function selVariantSize(e) {
	var x = $(e).text();
	document.getElementById("mdv_variant_size").value = x;
}
// Generate new barcode
function mdvNewBarcode() {
	var newseq = 0, seq = 0;
	var seqStr = "";
	for (var i=0; i<nVariantCount; i++) {
		if (myVariant[i]['barcode'] != null && myVariant[i]['barcode'] != "" && myVariant[i]['barcode'].length > 6
			&& myVariant[i]['barcode'].substr(0,6) == mdvMyId) {
			seqStr = myVariant[i]['barcode'].substr(6);
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
	var thisSeq = mdvMyId+newseqStr;
	
	return thisSeq;
}
/********************************************************************
	Select and edit item
********************************************************************/
// Select item
function mdvSelectItem(e) {
	var id = $(e).attr("id"); 
	var idx = parseInt(id.replace("mdv_item_", '')); 
	selVariantId = idx;
	mdvEdit();
}
// Edit item
function mdvEdit() {
	document.getElementById("mdvDataTitle").innerHTML = myRes['comEdit'];
	mdvHideList();
	$('#mdvDataContainer').show();
	mdvShowButtons(1);	
	mdvHighlightImage();
	mdvDisplayItem();	
}
// Highlight image
function mdvHighlightImage() {
	// get ID of image_? by imageNo
	if (myVariant[selVariantId]['m_no'] != null && myVariant[selVariantId]['m_no'] != "")
		selImageId = mdvGetImgIdByNo(myVariant[selVariantId]['m_no']);
	// Highlight variant image
	if (selImageId >= 0) {
		var img = document.getElementById("mdsi_image_"+selImageId);
		img.style.border = "4px solid red";	
		// show image in mdsi_selimage
		var defaultImg = document.getElementById("mdsi_selimage");
		defaultImg.src = img.src;
	}
}
// Display item
function mdvDisplayItem() {
	document.getElementById("mdv_variant").value = myVariant[selVariantId]['variant'];
	document.getElementById("mdv_variant_size").value = myVariant[selVariantId]['size'];
	document.getElementById("mdv_amount").value = myVariant[selVariantId]['amount'];
	document.getElementById("mdv_code").value = myVariant[selVariantId]['barcode'];
}
// Show buttons
function mdvShowButtons(option) {
	if (option == 1) {
		document.getElementById("mdvBtnAddItem").style.display = "none";
		document.getElementById("mdvBtnUpdateItem").style.display = "block";
		document.getElementById("mdvBtnDelItem").style.display = "block";
		document.getElementById("mdvBtnCancelItem").style.display = "block";
	} else {
		document.getElementById("mdvBtnAddItem").style.display = "block";
		document.getElementById("mdvBtnUpdateItem").style.display = "none";
		document.getElementById("mdvBtnDelItem").style.display = "none";
		document.getElementById("mdvBtnCancelItem").style.display = "block";
	}
}
/********************************************************************
	Input button actions
********************************************************************/
// Add item
function mdvAddItem() {
	var vname = document.getElementById("mdv_variant").value;
	var vcount = document.getElementById("mdv_amount").value;
	var vcode = document.getElementById("mdv_code").value;
	var vsize = document.getElementById("mdv_variant_size").value;
	// validation
	if (!mdvCheckItem(vname, vcount, vcode, "", "", vsize, ""))
		return;
	vcount = parseInt(vcount).toString();
	document.getElementById("mdv_amount").value = vcount;
	// check barcode
	if (vcode == ""  || vcode == mdvCode1)
		mdvAddItemNext();
	else
		mdvCheckBarcode(vcode);
}
function mdvAddItemNext() {	
	var vname = document.getElementById("mdv_variant").value;
	var vcount = document.getElementById("mdv_amount").value;
	var vcode = document.getElementById("mdv_code").value;
	var vsize = document.getElementById("mdv_variant_size").value;
	vcount = parseInt(vcount).toString();
	if (vcode == "")
		vcode = mdvNewBarcode();
	// Add variant
	var variantItem = new Object();
	variantItem['i_id'] = mdvMyId;
	variantItem['variant'] = vname;
	variantItem['amount'] = vcount;
	variantItem['barcode'] = vcode;
	variantItem['size'] = vsize;
	variantItem['m_no'] = mdvGetImage();
	myVariant[nVariantCount] = variantItem;
	mdvShowVariant(nVariantCount, myVariant[nVariantCount]);
	// Database
	mdvDbAdd(myVariant[nVariantCount]);
	
	nVariantCount++;
	mdvDisplayTotal();	
	mdvCloseInput();
	mdvShowList();	
}
function mdvCheckBarcode(code) {
	getRequest("getInvByCode1.php?code1="+code, mdvGetCodeYes, mdvGetCodeNo);
}
function mdvGetCodeYes(result) {
	alert(myRes['msgErrDupData']);	
	$('#mdv_code').trigger('focus');	
	return;	
}
function mdvGetCodeNo(result) {
	mdvAddItemNext();
}
// Update item
function mdvUpdateItem() {
	var vname = document.getElementById("mdv_variant").value;
	var vcount = document.getElementById("mdv_amount").value;
	var vcode = document.getElementById("mdv_code").value;
	var vsize = document.getElementById("mdv_variant_size").value;

	
	if (!mdvCheckItem(vname, vcount, vcode, myVariant[selVariantId]['variant'], myVariant[selVariantId]['barcode'], vsize, myVariant[selVariantId]['size']))
		return;
	vcount = parseInt(vcount).toString();
	document.getElementById("mdv_amount").value = vcount;
	
	// check barcode
	if (vcode == "" || vcode == myVariant[selVariantId]['barcode'] || vcode == mdvCode1) 		
		mdvUpdateItemNext();
	else
		mdvCheckBarcode1(vcode);
}
function mdvUpdateItemNext() {
	var vname = document.getElementById("mdv_variant").value;
	var vcount = document.getElementById("mdv_amount").value;
	var vcode = document.getElementById("mdv_code").value;
	var vsize = document.getElementById("mdv_variant_size").value;
	vcount = parseInt(vcount).toString();
	if (vcode == "")
		vcode = myVariant[selVariantId]['barcode'];
		
	myVariant[selVariantId]['variant'] = vname;
	myVariant[selVariantId]['amount'] = vcount;
	myVariant[selVariantId]['barcode'] = vcode;
	myVariant[selVariantId]['size'] = vsize;
	myVariant[selVariantId]['m_no'] = mdvGetImage();
	mdvShowVariant(selVariantId, myVariant[selVariantId]);
	mdvDisplayTotal();
	mdvDbUpdate(myVariant[selVariantId]);

	mdvCloseInput();
	mdvShowList();
}
function mdvCheckBarcode1(code) {
	getRequest("getInvByCode1.php?code1="+code, mdvGetCodeYes1, mdvGetCodeNo1);
}
function mdvGetCodeYes1(result) {
	alert(myRes['msgErrDupData']);	
	$('#mdv_code').trigger('focus');	
	return;	
}
function mdvGetCodeNo1(result) {
	mdvUpdateItemNext();
}
// Delete item
function mdvDelItem() {
	if (!confirm(myRes['msgConfirmDelete']))			
		return; 
	// database
	mdvDbDelete(myVariant[selVariantId]);
	// delete item from myVariant
	if (selVariantId < nVariantCount - 1) {
		for (var i=selVariantId; i<nVariantCount-1; i++) {
			mdvShowVariant(i, myVariant[i+1]);
		}
	}	
	mdvEmptyVariant(nVariantCount-1);
	nVariantCount--;
	document.getElementById("mdvBtnAdd").style.display = "block";
	myVariant.splice(selVariantId, 1);
	mdvDisplayTotal();

	mdvCloseInput();
	mdvShowList();
}
// Cancel item
function mdvCancelItem() {
	mdvCloseInput();
	mdvShowList();	
}
/********************************************************************
	Functions
********************************************************************/
// Check item
function mdvCheckItem(vname, vcount, vcode, old_name, old_code, vsize, old_vsize) {
	if (vname == "") {
		$('#mdv_variant').trigger('focus');
		return false;
	}
	// Check if variant exists
	if (vname != old_name) {
		for (i=0; i<nVariantCount; i++) {
			if (myVariant[i]['variant'] == vname) {
				alert(myRes['msgErrDupData']);
				$('#mdv_variant').trigger('focus');
				return false;
			}
		}
	}
	if (!checkCount(vcount)) {
		$('#mdv_amount').trigger('focus');
		return false;
	}
	// Check if barcode exists
	if (vcode != old_code) {
		for (i=0; i<nVariantCount; i++) {
			if (myVariant[i]['barcode'] == vcode) {
				alert(myRes['msgErrDupData']);
				$('#mdv_code').trigger('focus');
				return false;
			}
		}
	}
	
	return true;
}
// validation
function checkCount(s) {
	if (s == "")
		return false;
	if (parseInt(s) < 0 || parseInt(s) > 9999)
		return false;
	var d;
	for (var i=0; i<s.length; i++) {
		d = s[i];
		if (d < "0" || d > "9")
			return false;
	}
	return true;
}
// Close input
function mdvCloseInput() {
	selVariantId = -1;
	selImageId = -1;
	mdvEmptyInput();
	mdvEmptyImages();
	$('#mdvDataContainer').hide();	
}
// Hide List
function mdvHideList() {
	$('#mdvListContainer').hide();	
	document.getElementById("mdvBtnAdd").style.display = "none";
	document.getElementById("mvBtnDone").style.display = "none";
}
// Show List
function mdvShowList() {
	$('#mdvListContainer').show();
	if (nVariantCount == nVariantMax)
		document.getElementById("mdvBtnAdd").style.display = "none";
	else
		document.getElementById("mdvBtnAdd").style.display = "block";
	document.getElementById("mvBtnDone").style.display = "block";	
}
/********************************************************************
	Database actions
********************************************************************/
// Add item to DB
function mdvDbAdd(variant) {
	lastVariant = variant;
	form = new FormData();
	form.append('variant', JSON.stringify(variant));
	postRequest("postVariantAdd.php", form, mdvDbAddYes, mdvDbAddNo);
}
function mdvDbAddYes(result) {
	lastVariant['iv_id'] = result;
}
function mdvDbAddNo(result) {	
}
// Update item in DB
function mdvDbUpdate(variant) { 
	form = new FormData();
	form.append('variant', JSON.stringify(variant));
	postRequest("postVariantUpdate.php", form, mdvDbUpdateYes, mdvDbUpdateNo);
}
function mdvDbUpdateYes(result) {	
}
function mdvDbUpdateNo(result) {	
}
// Delete item from DB
function mdvDbDelete(variant) { 
	form = new FormData();
	form.append('variant', JSON.stringify(variant));
	postRequest("postVariantDelete.php", form, mdvDbDeleteYes, mdvDbDeleteNo);
}
function mdvDbDeleteYes(result) {	
}
function mdvDbDeleteNo(result) {	
}
/********************************************************************
	Image actions
********************************************************************/
// Select image
function mdvSelImage(e) {
	// de-highlight all images
	for (var i=0; i<nVariantMax; i++) {
		var img = document.getElementById("mdsi_image_"+i);
		img.style.border = "1px dotted";
	}
	// highlight selected image
	var id = $(e).attr("id"); 
	var img = document.getElementById(id);
	img.style.border = "4px solid red";
	selImageId = id.replace("mdsi_image_", '');
	// show image in mdsi_selimage
	var defaultImg = document.getElementById("mdsi_selimage");
	defaultImg.src = img.src;
}
// Get image ID by imageNo(m_no)
function mdvGetImgIdByNo(imgNo) {
	for (var i=0; i<imgCount; i++) {
		var imageNo = document.getElementById("imageNo_"+i);
		if (imageNo.value == imgNo)
			return i;
	}	
	return -1;
}
// Get selected image
function mdvGetImage() {
	if (selImageId < 0)
		return "";
	// update variant image
	var imgNo = document.getElementById("imageNo_"+selImageId).value;
	return imgNo;
}
// Add new photo
var mdvImageCapture = document.getElementById("mdvNewImage");
// Display image and submit
mdvImageCapture.onchange = function () {	
	// get the new image
	var file = mdvImageCapture.files[0];
	compressImage(file, displayImage, 1);	
}
// Empty images in selection
function mdvEmptyImages() {
	for (var i=0; i<nVariantMax; i++) {
		var img = document.getElementById("mdsi_image_"+i);
		img.style.border = "1px dotted";
	}
	var defaultImg = document.getElementById("mdsi_selimage");
	defaultImg.src = "blank.jpg";
}
// Select no image
function mdvNoImage() {
	mdvEmptyImages();
	selImageId = -1;
}
