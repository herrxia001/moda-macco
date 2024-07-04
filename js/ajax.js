// AJAX - GET
function getRequest(link, cb, cb1){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var result = JSON.parse(this.responseText);
			if(result != "NO"){
				if(cb) cb(result);
			}
			else{
				if(cb1) cb1(result);
			}
		};
	};
	xhr.open("GET", link, true);
	xhr.send();
}

// AJAX - POST
function postRequest(link, form, cb, cb1){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var result = JSON.parse(this.responseText);
			if(result != "NO"){
				if(cb) cb(result);
			}
			else{
				if(cb1) cb1(result);
			}
		}
	}
	xhr.open('POST', link, true);
	xhr.send(form);
}





