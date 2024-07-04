/********************************************************************
	modalApp script
********************************************************************/
var modalApp = $("#modalApp");
var mdapData = {};
var mdapType = 0;
var mdapCode = "", mdapPrice = "";
var mdapIsDiscount = false;
var mdapImageMax = 30;

function mdapShow(data) {
	mdapData = data;
	
	mdapCode = document.getElementById("i_code").value;
	if (mdapCode == "") {	
		$('#i_code').focus();
		return;
	}
	document.getElementById("mdapTitle").innerText = mdapCode;
		
	mdapPrice = document.getElementById("price").value;
	if (mdapPrice == "") {	
		$('#price').focus();
		return;
	}	
	document.getElementById("mdap_price").value = mdapPrice;
	
	if (mdapData['state'] == "-1") {
		mdapType = 0;
		document.getElementById("mdap_status_str").innerText = myRes['appStatusNormal'];
		document.getElementById("mdap_status").value = "0";
		document.getElementById("mdap_t_name").innerText = "";
		document.getElementById("mdap_t_id").value = "";
		document.getElementById("mdap_discount").checked = false;
		document.getElementById("mdap_hot").checked = false;
		document.getElementById("mdap_new").checked = false;
		document.getElementById("mdap_zero").checked = false;
		document.getElementById("mdapPriceSec").style.display = "none";
		document.getElementById("mdap_note").value = "";
	} else {
		mdapType = 1;
		document.getElementById("mdap_status").value = mdapData['state'];
		document.getElementById("mdap_status_str").innerText = mdapShowStatus();		
		document.getElementById("mdap_t_id").value = mdapData['ap_t_id'];
		document.getElementById("mdap_t_name").innerText = mdapShowType();
		if (mdapData['collections'][5] == "1") {
			mdapIsDiscount = true;
			document.getElementById("mdap_discount").checked = true;
			document.getElementById("mdapPriceSec").style.display = "block";
			document.getElementById("mdap_old_price").value = mdapData['old_price'];
		} else {
			mdapIsDiscount = false;
			document.getElementById("mdap_discount").checked = false;
			document.getElementById("mdapPriceSec").style.display = "none";
			document.getElementById("mdap_old_price").value = "";
		}
		if (mdapData['collections'][6] == "1")
			document.getElementById("mdap_hot").checked = true;
		else
			document.getElementById("mdap_hot").checked = false;
		if (mdapData['collections'][7] == "1")
			document.getElementById("mdap_new").checked = true;
		else
			document.getElementById("mdap_new").checked = false;
		if (mdapData['zero_sale'] == "1")
			document.getElementById("mdap_zero").checked = true;
		else
			document.getElementById("mdap_zero").checked = false;			
		document.getElementById("mdap_note").value = mdapData['note'];		
	}
	
	// images
	var appImgCount = myAppImages.length;
	var i = 0, j = 0;
	
	if (myAppImages.length <= 0) {
		for (i=0; i<imgCount; i++) {
			var apImg = new Object();
			apImg['i_id'] = myId;
			apImg['m_no'] = document.getElementById("imageNo_"+i).value;
			apImg['img_id'] = i;
			myAppImages.push(apImg);
			appImgCount++;
		}
	} else {
		for (i=0; i<appImgCount; i++) {
			var isExist = false;
			for (j=0; j<imgCount; j++) {
				if (myAppImages[i]['m_no'] == document.getElementById("imageNo_"+j).value) {
					myAppImages[i]['img_id'] = j;
					isExist = true;
					break;
				}
			}
			if (!isExist) {
				myAppImages[i]['img_id'] = -1;
			}
		}
	}

	i = 0;
	while (i < appImgCount) {
		if (myAppImages[i]['img_id'] == -1) {
			myAppImages.splice(i, 1);
			appImgCount--;
		} else {
			i++;
		}
	}

	for (j=0; j<imgCount; j++) {
		var isExist = false;
		for (i=0; i<appImgCount; i++) {
			if (myAppImages[i]['m_no'] == document.getElementById("imageNo_"+j).value) {
				isExist = true;
				break;
			}
		}
		if (!isExist) {			
			var apImg = new Object();
			apImg['i_id'] = myId;
			apImg['m_no'] = document.getElementById("imageNo_"+j).value;
			apImg['img_id'] = j;
			myAppImages.push(apImg);		
			appImgCount++;
		}
	}

	for (i=0; i<appImgCount; i++) {	
		showAppImage(myAppImages[i]['img_id'], i);
	}
	for (i=appImgCount; i<mdapImageMax; i++) {	
		hideAppImage(i);
	}
	
	modalApp.modal();
}

function showAppImage(imgId, apImgId) {
	var imgSrc = document.getElementById("image_"+imgId).src;
	var div = document.getElementById("mdap_div_"+apImgId);
	var img = div.firstElementChild;
	img.src = imgSrc;
	img.style.display = "inline";
	div.style.display = "inline";
}

function hideAppImage(apImgId) {
	var div = document.getElementById("mdap_div_"+apImgId);
	var img = div.firstElementChild;
	div.style.display = "none";
	img.style.display = "none";	
}

function cancelApp() {
	modalApp.modal("toggle");
}

function saveApp() {
	var isNew = "0", isHot = "0", isDis = "0";
	var ap_t_id = "", old_price = "";
	
	mdapData['state'] = document.getElementById("mdap_status").value;
	
	ap_t_id = document.getElementById("mdap_t_id").value;
	if (ap_t_id == "") {
		$('#mdap_t_name').focus();
		return;
	}
	mdapData['ap_t_id'] = ap_t_id;

	document.getElementById("mdap_discount").checked ? isDis = "1" : isDis = "0";
	old_price = document.getElementById("mdap_old_price").value;
	if (isDis == "1" && (old_price == "" || parseFloat(old_price) <= parseFloat(mdapPrice))) {
		$('#mdap_old_price').focus();
		return;
	}
	if (old_price == "") old_price = "0.00";
	old_price.replace(",", ".");
	mdapData['old_price'] = old_price;
	
	document.getElementById("mdap_hot").checked ? isHot = "1" : isHot = "0";
	document.getElementById("mdap_new").checked ? isNew = "1" : isNew = "0";	
	mdapData['collections'] = "00000" + isDis + isHot + isNew;
	
	document.getElementById("mdap_zero").checked ? mdapData['zero_sale'] = "1" : mdapData['zero_sale'] = "0";
	mdapData['note'] = document.getElementById("mdap_note").value;
	
	if (myAppImages.length > 0)
		mdapData['m_no'] = myAppImages[0]['m_no'];
	else
		mdapData['m_no'] = "0";
	
	mdapDbAction();
}

function mdapDbAction() {
	var form = new FormData();
	form.append('data', JSON.stringify(mdapData));
	form.append('images', JSON.stringify(myAppImages));
	if (mdapType == 0) {
		postRequest('apPostProductAdd.php', form, mdapDbYes, mdapDbNo);
	} else {
		postRequest('apPostProductUpdate.php', form, mdapDbYes, mdapDbNo);
	}
}

function mdapDbYes(result) {
	modalApp.modal("toggle");
}

function mdapDbNo(result) {
	alert(myRes['msgErrDatabase']);
}

/********************************************************************
	FUNCTIONS
********************************************************************/
function mdapSelDiscount() {
	if (!mdapIsDiscount) {
		mdapIsDiscount = true;
		document.getElementById("mdapPriceSec").style.display = "block";
	} else {
		mdapIsDiscount = false;
		document.getElementById("mdapPriceSec").style.display = "none";
		document.getElementById("mdap_old_price").value = "";
	}		
}
function mdapSelStatus(e) {
	document.getElementById("mdap_status_str").innerText = $(e).text();
	document.getElementById("mdap_status").value = e.getElementsByTagName("input")[0].value;  
}

function mdapShowStatus() {
	if (mdapData['state'] == "1")
		return myRes['appStatusOffline'];
	else if (mdapData['state'] == "2")
		return  myRes['appStatusRestock'];
	else
		return  myRes['appStatusNormal'];
}

function mdapSelType(e) {
	document.getElementById("mdap_t_name").innerText = $(e).text();
	document.getElementById("mdap_t_id").value = e.getElementsByTagName("input")[0].value; 
}

function mdapShowType() {
	for (var i=0; i<myAppTypes.length; i++) {
		if (mdapData['ap_t_id'] == myAppTypes[i]['ap_t_id'])
			return myAppTypes[i]['t_name'];
	}
	return "";
}
/********************************************************************
	Drag & Drop
********************************************************************/
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("image", ev.target.id);
}

function drop(ev) {
	ev.preventDefault();
	
	var data = ev.dataTransfer.getData("image");
	var srcImg = document.getElementById(data);
	var srcDiv = srcImg.parentNode;
	var tgtDiv = ev.currentTarget;
	var tgtImg = tgtDiv.firstElementChild;
	var tgtId = parseInt(tgtDiv.id.replace("mdap_div_", ""));
	var srcId = parseInt(srcDiv.id.replace("mdap_div_", ""));
	tgtDiv.replaceChild (srcImg, tgtImg);
	var curImg = tgtImg;
	
	if (tgtId < srcId) {
		for (var i=tgtId+1; i<srcId; i++) {	
			var nxtId = "mdap_div_"+i; 
			var nxtDiv = document.getElementById(nxtId); 
			var nxtImg = nxtDiv.firstElementChild; 
			nxtDiv.replaceChild (curImg, nxtImg);
			curImg = nxtImg;
		}
	} else {
		for (var i=tgtId-1; i>srcId; i--) {	
			var nxtId = "mdap_div_"+i; 
			var nxtDiv = document.getElementById(nxtId); 
			var nxtImg = nxtDiv.firstElementChild; 
			nxtDiv.replaceChild (curImg, nxtImg);
			curImg = nxtImg;
		}
	}
	srcDiv.appendChild (curImg);
	
	var apImg =  copyAppImg(myAppImages[srcId]);
	if (tgtId < srcId) {		
		myAppImages.splice(tgtId, 0, apImg);
		myAppImages.splice(srcId+1, 1);
	} else {
		myAppImages.splice(tgtId+1, 0, apImg); 
		myAppImages.splice(srcId, 1); 
	}
}

function copyAppImg(img) {
	var apImg = new Object();
	apImg['i_id'] = myId;
	apImg['m_no'] = img['m_no'];
	apImg['img_id'] = img['img_id'];
	
	return apImg;
}