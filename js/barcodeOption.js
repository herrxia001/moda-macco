var option = new Object();
var tmpOption = JSON.parse(localStorage.getItem("barcodePrint"));

initOption();
loadOption();

function initOption() {
	option['barcode'] = true;
	option['artno'] = true;
	option['variant'] = true;
	option['colorSecond'] = false;
	option['paperWidth'] = 50;
	option['paperHeight'] = 25;
	option['codeWidth'] = 3;
	option['codeHeight'] = 50;
	option['fontSize'] = 32;
}
function loadOption() {
	if (tmpOption == null)
		return;
	option['barcode'] = tmpOption['barcode'];
	option['artno'] = tmpOption['artno'];
	option['variant'] = tmpOption['variant'];
	tmpOption['colorSecond'] == null? option['colorSecond'] = false : option['colorSecond'] = tmpOption['colorSecond'];
	tmpOption['paperWidth'] == null?  option['paperWidth'] = 50 : option['paperWidth'] = tmpOption['paperWidth'];
	tmpOption['paperHeight'] == null?  option['paperHeight'] = 25 : option['paperHeight'] = tmpOption['paperHeight'];
	tmpOption['codeWidth'] == null?  option['codeWidth'] = 3 : option['codeWidth'] = tmpOption['codeWidth'];
	tmpOption['codeHeight'] == null?  option['codeHeight'] = 50 : option['codeHeight'] = tmpOption['codeHeight'];
	tmpOption['fontSize'] == null?  option['fontSize'] = 32 : option['fontSize'] = tmpOption['fontSize'];
}