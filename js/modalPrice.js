var modalPrice = $("#modalPrice");

function mdprShow() {
	if (myInvPrice.length <= 0) {
		var price = document.getElementById("price").value;
		document.getElementById("mdpr_price1").value = price;
		modalPrice.modal();
		return;
	}
	
	var id = 0;
	for (var i=0; i<myInvPrice.length; i++) {
		id = i+1;
		document.getElementById("mdpr_price"+id).value = myInvPrice[i]['price'];
		document.getElementById("mdpr_note"+id).value = myInvPrice[i]['note'];
	}
	for (var i=myInvPrice.length; i<5; i++) {
		id = i+1;
		document.getElementById("mdpr_price"+id).value = "";
		document.getElementById("mdpr_note"+id).value = "";
	}
	modalPrice.modal();
}

function cancelPrice() {
	modalPrice.modal("toggle");
}

function donePrice() {
	var price, note;
	var id = 0;
	for (var i=0; i<5; i++) {
		id = i+1;
		price = document.getElementById("mdpr_price"+id).value;
		note = document.getElementById("mdpr_note"+id).value;
		if (price == "" || parseFloat(price) <= 0)
			break;
		if (myInvPrice[i] != null) {
			myInvPrice[i]['price'] = price;
			myInvPrice[i]['note'] = note;
		} else {
			var invPrice = new Object();
			invPrice['i_id'] = myId;
			invPrice['ip_id'] = i;
			invPrice['price'] = price;
			invPrice['note'] = note;
			myInvPrice.push(invPrice);
		}
	}
	if (i < 5 && myInvPrice.length >= i) {
		myInvPrice.splice(i);
	}
	if (myInvPrice.length <= 0)
		return;
	mdprDbUpdate();
}

function mdprDbUpdate() {
	var form = new FormData();
	form.append('i_id', myId);
	form.append('price', JSON.stringify(myInvPrice));
	postRequest('postInvPriceUpdate.php', form, mdprDbYes, mdprDbNo);
}

function mdprDbYes(result) {
	modalPrice.modal("toggle");
	document.getElementById("price").value = myInvPrice[0]['price'];
}

function mdprDbNo(result) {
	modalPrice.modal("toggle");
	document.getElementById("price").value = myInvPrice[0]['price'];
}