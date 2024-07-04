var aOptions = {};

function initAOptions() {
	aOptions = JSON.parse(localStorage.getItem("aOptions"));

	if (aOptions == null) {
		aOptions = new Object();
		aOptions['printNoART'] = 0;
		aOptions['printReklamation'] = 0;
		aOptions['printQRCode'] = 0;
		aOptions['printReklamation1'] = 0;
		aOptions['exportDecimal'] = 0;
	}
}

function saveAOptions(){
	localStorage.setItem("aOptions", JSON.stringify(aOptions));
}




