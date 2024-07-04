
var $modalSelTime = $("#modalSelTime");

function checkRadio8() {
	var radiobtn = document.getElementById("radio8");
	radiobtn.checked = true;
}

function mdstSelMonth(e) {
	var x = $(e).text();
	document.getElementById("mdstMonth").innerText = x;
	var radiobtn = document.getElementById("radio7");
	radiobtn.checked = true;
}

function mdstSelYear(e) {
	var x = $(e).text();
	document.getElementById("mdstYear").innerText = x;
	var radiobtn = document.getElementById("radio7");
	radiobtn.checked = true;
}

function mdstSetChecked(timev) {
	switch (timev) {
		case "timeToday": document.getElementById("radio1").checked = true; break;
		case "timeYesterday": document.getElementById("radio2").checked = true; break;
		case "timeThisMonth": document.getElementById("radio3").checked = true; break;
		case "timeLastMonth": document.getElementById("radio4").checked = true; break;
		case "timeThisYear": document.getElementById("radio5").checked = true; break;
		case "timeLastYear": document.getElementById("radio6").checked = true; break;
		case "timeMonth": document.getElementById("radio7").checked = true; break;
		case "timePeriod": document.getElementById("radio8").checked = true; break;
		default: document.getElementById("radio9").checked = true;
	}
}

function mdstGetChecked(){
	var timev = 0;
	var radios = document.getElementsByName('timeRadio');
	
	for (var i = 0; i < radios.length; i++) {
		if (radios[i].checked) {
			timev = radios[i].value;
			break;
		}
	}
	
	return timev;	
}

function mdstGetStr(){	
	var timev = mdstGetChecked();
	var timeStr = "";
	var timefrom, timeto;

	switch (timev) {
		case "timeToday": timeStr = document.getElementById("rd1").innerText; break;
		case "timeYesterday": timeStr = document.getElementById("rd2").innerText; break;
		case "timeThisMonth": timeStr = document.getElementById("rd3").innerText; break;
		case "timeLastMonth": timeStr = document.getElementById("rd4").innerText; break;
		case "timeThisYear": timeStr = document.getElementById("rd5").innerText; break;
		case "timeLastYear": timeStr = document.getElementById("rd6").innerText; break;
		case "timeMonth": 
			year = document.getElementById("mdstYear").innerText;
			month = document.getElementById("mdstMonth").innerText;
			timeStr = year+"/"+month;
			break;
		case "timePeriod": 
			datefrom = document.getElementById("mdstFrom").value;
			dateto = document.getElementById("mdstTo").value;
			timeStr = datefrom+"--"+dateto;
			break;
		default: timeStr = document.getElementById("rd9").innerText;
	}

	return timeStr;
	
}

function mdstGetMonthLastDay(month) {
	var month_last_day = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	if (month <1 || month > 12)
		return 30;
	return month_last_day[month-1];
}

function mdstGetYesterday(year, month, day) {	
	var dt = "";
	
	if (day > 1)
		dt = year+"-"+fd(month)+"-"+fd(day-1);
	else if (day == 1) {
		if (month > 1) { 
			var d = mdstGetMonthLastDay(month-1);
			dt = year+"-"+fd(month-1)+"-"+fd(d); 
		}
		else {
			var y = year - 1;
			dt = y+"-"+"12"+"-"+"31";
		}
	}
	
	return dt;
}

function mdstGetValue(option){ 
	var timev = mdstGetChecked();
	var datenow = new Date();	
	var day = datenow.getDate(), month = datenow.getMonth() + 1, year = datenow.getFullYear();
	var day_1, month_1, year_1;
	var datefrom, dateto = year+"-"+fd(month)+"-"+fd(day);
	var result = "";
	var result1 = new Object;
	
	switch (timev) {
		case "timeToday": 
			datefrom = dateto;
			break;
		case "timeYesterday": 
			datefrom = mdstGetYesterday(year, month, day);
			dateto = datefrom;
			break;
		case "timeThisMonth":
			year_1 = year;
			month_1 = month;
			day_1 = 1;
			datefrom = year_1+"-"+fd(month_1)+"-"+fd(day_1);
			break;
		case "timeLastMonth":
			if (month > 1) {
				year_1 = year;
				month_1 = month - 1;
			}
			else {
				year_1 = year - 1;
				month_1 = 12;
			}
			day_1 = 1;
			datefrom = year_1+"-"+fd(month_1)+"-"+fd(day_1);
			year = year_1;
			month = month_1;
			day = mdstGetMonthLastDay(month);
			dateto = year+"-"+fd(month)+"-"+fd(day);
			break;
		case "timeThisYear": 
			year_1 = year;
			month_1 = 1;
			day_1 = 1;
			datefrom = year_1+"-"+fd(month_1)+"-"+fd(day_1);
			break;
		case "timeLastYear": 
			year_1 = year - 1;
			month_1 = 1;
			day_1 = 1;
			datefrom = year_1+"-"+fd(month_1)+"-"+fd(day_1);
			year = year - 1;
			month = 12;
			day = 31;
			dateto = year+"-"+fd(month)+"-"+fd(day);
			break;
		case "timeMonth":
			selyear = document.getElementById("mdstYear").innerText;
			selmonth = document.getElementById("mdstMonth").innerText;
			year_1 = selyear;
			month_1 = selmonth;
			day_1 = 1;
			datefrom = year_1+"-"+fd(month_1)+"-"+fd(day_1);
			year = selyear;
			month = selmonth;
			day = 31;
			dateto = year+"-"+fd(month)+"-"+fd(day);
			break;
		case "timePeriod":
			datefrom = document.getElementById("mdstFrom").value;
			dateto = document.getElementById("mdstTo").value;
			break;
		default: 
			datefrom = "2020-01-01";
	}
	
	if (option) {
		result1['timefrom'] = datefrom;
		result1['timeto'] = dateto;
		return result1;
	} else {
		result = "timefrom="+datefrom+"&timeto="+dateto;
		return result;
	}
}

function fd(d) {
	var t = d.toString();
	if (t.length < 2)
		return "0"+t;
	else
		return t;
	
}


