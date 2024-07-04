function currentDate(option) {
	var dt, d = new Date();
	var t = d.getDate();
	if (t < 10) t = '0'+t;
	var m = d.getMonth()+1;
	if (m < 10) m = '0'+m;
	
	if (option == 1)
		dt = t+m+d.getFullYear();
	else if (option == 2)
		dt = d.getFullYear()+"-"+m+"-"+t;
	else
		dt = t+"/"+m+"/"+d.getFullYear();
	
	return dt;
}

function convertDate(date, option) {
	if (date.length < 10)
		return "00/00/0000";
	var y = date.substring(0,4);
	var m = date.substring(5,7);
	var d = date.substring(8,10);
	if (option == 1)
		var dt = y+"-"+m+"-"+d;
	else
		var dt = d+"/"+m+"/"+y;
	
	return dt;
}






