
var $modalOrder = $("#modalOrder");

function mdOrderLoad(items, time){
	var $table = $('#mdOrderTable');
	
	document.getElementById("mdOrderTitle").innerHTML = "订单号:&nbsp;"+items[0]['o_id'];
	document.getElementById("mdOrderTitleTime").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;时间:&nbsp;"+time;

	$table.bootstrapTable('removeAll');

	var mdOrderCount = 0, mdOrderPrice = 0;
	var rows = [];
	for (var i=0; i<items.length; i++) {
		if (items[i]['i_name'] != null)
			var dataStr = "<a style='font-weight:bold;'>"+items[i]['i_code']+"</a><br>"+"<a >"+items[i]['i_name']+"</a>";
		else
			var dataStr = "<a style='font-weight:bold;'>"+items[i]['i_code']+"</a>";
		var imgSrc = items[i]['path']+"/"+items[i]['i_id']+"_"+items[i]['m_no']+"_s.jpg";
		var imgStr = "<img width='60' height='60' style='border:1px dotted; object-fit: cover' src='"+imgSrc+"' >";
		rows.push({
			idx_image: imgStr,
			idx_code: dataStr,
			idx_count: items[i]['count'],
			idx_price: items[i]['price']
		});
		mdOrderCount += parseInt(items[i]['count']);
		mdOrderPrice += parseInt(items[i]['count'])*parseFloat(items[i]['price']);
	}	
	$table.bootstrapTable('append', rows);
	
	document.getElementById("mdOrderSumCount").innerText = mdOrderCount.toString();
	document.getElementById("mdOrderSumPrice").innerText = mdOrderPrice.toFixed(2);;		 
}





