var modalDel = $("#modalDelete");
var functionDone;
function delItemModal(){
    if(document.getElementById("pwd").value == ""){
        alert("请输入密码");
        return;
    }
    // check passowrd //
    var user = localStorage.getItem("user");
    var form = new FormData();
	form.append('user', JSON.stringify(user));
	form.append('password', JSON.stringify(document.getElementById("pwd").value)); 
	postRequest("postLogin.php", form, checkSubmitYes, checkSubmitNo);
}

function cancelDel() {
	modalDel.modal("toggle");
}
function showDelModal(delfunc){
    modalDel.modal();
    functionDone = delfunc;
}



function checkSubmitYes(result) {
    // delete item //
    cancelDel();
    functionDone();
}
function checkSubmitNo(result) {
    alert("密码错误");
	$('#pwd').focus();
}