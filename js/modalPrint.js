var modalPrint = $("#modalPrint");
var isVariable;
/* print barcode */
function printBarcode(){
    if(document.getElementById("print_amount").value == ""){
        alert("请输入打印数量");
        return;
    }

    var vname = document.getElementById("mdv_variant").value;
    var vsize = document.getElementById("mdv_variant_size").value;

    var form = new FormData();
	form.append('i_code', document.getElementById("i_code").value);
    if(isVariable == true)
	    form.append('code', document.getElementById("mdv_code").value);
    else
        form.append('code', document.getElementById("code1").value);
    form.append('amount', document.getElementById("print_amount").value);
    if(isVariable == true)
        form.append('variant', vname + " "+ vsize);
    else
        form.append('variant', '');
        //form.append('variant', document.getElementById("t_name").value);
	postRequest('postInvPrint.php', form, mdprintDbYes, mdprintDbNo);

}
function cancelPrint() {
	modalPrint.modal("toggle");
}
function showPrintModal(){
    isVariable = true;
    modalPrint.modal();
}
function showPrintModalNoVariable(){
    isVariable = false;
    modalPrint.modal();
}
function mdprintDbYes(result) {	
    cancelPrint();
}
function mdprintDbNo(result) {	
}