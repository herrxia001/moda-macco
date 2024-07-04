
var $modalOrderItems = $("#modalOrderItems");

function mdoiShow(items){
	var $table = $('#mdoiTable');
	var mdItemsCount = 0, mdItemsValue = 0;
	var imgSrc = "", imgStr = "";
	var rows = [];
	
	for (var i=0; i<items.length; i++) {
		imgSrc = items[i]['path']+"/"+items[i]['i_id']+"_"+items[i]['m_no']+"_s.jpg";
		imgStr = "<img width='60' height='60' style='object-fit: cover' src='"+imgSrc+"'";
		items[i]['subtotal'] = parseInt(items[i]['count']) * parseFloat(items[i]['price']);
		rows.push({
			idx_image: imgStr,
			idx_code: items[i]['i_code'],
			idx_count: items[i]['count'],
			idx_price: items[i]['price']
		});
		mdItemsCount += parseInt(items[i]['count']);
		mdItemsValue += items[i]['subtotal'];
	}
	$table.bootstrapTable('removeAll');
	$table.bootstrapTable('append', rows);
	
	document.getElementById("mdoiSumCount").innerText = mdItemsCount;
	document.getElementById("mdoiSumValue").innerText = mdItemsValue.toFixed(2);

	$modalOrderItems.modal();
}

function mdoiCancel() {
	$modalOrderItems.modal("toggle");
}





