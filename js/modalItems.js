/* modalItems */
var $modalItems = $("#modalItems");

function mdItemsLoad(items){
	var $table = $('#mdItemsTable');

	$table.bootstrapTable('removeAll');

	var mdItemsCount = 0, mdItemsPrice = 0;
	var rows = [];
	for (var i=0; i<items.length; i++) {
		rows.push({
			idx_code: items[i]['i_code'],
			idx_name: items[i]['i_name'],
			idx_count: items[i]['count'],
			idx_price: items[i]['price']
		});
		mdItemsCount += parseInt(items[i]['count']);
		mdItemsPrice += parseFloat(items[i]['price']);
	}
	mdItemsPrice.toFixed(2);
	
	$table.bootstrapTable('append', rows);
	
	document.getElementById("mdItemsSumCount").innerText = mdItemsCount;
	document.getElementById("mdItemsSumPrice").innerText = mdItemsPrice;		 
}





