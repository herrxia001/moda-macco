
var acNameList = new Array();
var acName1List = new Array();
var acPostList = new Array();
var acVatList = new Array();

var acAddList = new Array();
var acCityList = new Array();
var acTelList = new Array();

function acCustInitLists(customers) {		
	for (var i = 0; i < customers.length; i++) {
		if (customers[i]['k_name'] != null && customers[i]['k_name'] != "") {
			var nameItem = new Array();
			nameItem[0] = customers[i]['k_name'];
			nameItem[1] = customers[i]['k_id'];
			acNameList.push(nameItem);
		}
		if (customers[i]['name1'] != null && customers[i]['name1'] != "") {
			var name1Item = new Array();
			name1Item[0] = customers[i]['name1'];
			name1Item[1] = customers[i]['k_id'];
			acName1List.push(name1Item);
		}
		if (customers[i]['post'] != null && customers[i]['post'] != "") {
			var postItem = new Array();
      if (customers[i]['name1'] != null && customers[i]['name1'] != "") 
			  postItem[0] = customers[i]['post'] + "\xa0\xa0" + customers[i]['k_name'] + "\xa0\xa0" + customers[i]['name1'];
      else
        postItem[0] = customers[i]['post'] + "\xa0\xa0" + customers[i]['k_name'];
			postItem[1] = customers[i]['k_id'];
			acPostList.push(postItem);
		}
		if (customers[i]['ustno'] != null && customers[i]['ustno'] != "") {
			var vatItem = new Array();
      if (customers[i]['name1'] != null && customers[i]['name1'] != "")
        vatItem[0] = customers[i]['ustno'] + "\xa0\xa0" + customers[i]['k_name'] + "\xa0\xa0" + customers[i]['name1'];
      else
			  vatItem[0] = customers[i]['ustno'] + "\xa0\xa0" + customers[i]['k_name'];
			vatItem[1] = customers[i]['k_id'];
			acVatList.push(vatItem);
		}

    if (customers[i]['address'] != null && customers[i]['address'] != "") {
			var addItem = new Array();
      if (customers[i]['name1'] != null && customers[i]['name1'] != "")
			  addItem[0] = customers[i]['address'] + "\xa0\xa0" + customers[i]['k_name'] + "\xa0\xa0" + customers[i]['name1'];
      else
        addItem[0] = customers[i]['address'] + "\xa0\xa0" + customers[i]['k_name'];
			addItem[1] = customers[i]['k_id'];
			acAddList.push(addItem);
		}
    if (customers[i]['city'] != null && customers[i]['city'] != "") {
			var cityItem = new Array();
      if (customers[i]['name1'] != null && customers[i]['name1'] != "")
			  cityItem[0] = customers[i]['city'] + "\xa0\xa0" + customers[i]['k_name'] + "\xa0\xa0" + customers[i]['name1'];
      else
        cityItem[0] = customers[i]['city'] + "\xa0\xa0" + customers[i]['k_name'];
			cityItem[1] = customers[i]['k_id'];
			acCityList.push(cityItem);
		}
    if (customers[i]['tel'] != null && customers[i]['ustno'] != "") {
			var telItem = new Array();
      if (customers[i]['name1'] != null && customers[i]['name1'] != "")
			  telItem[0] = customers[i]['tel'] + "\xa0\xa0" + customers[i]['k_name'] + "\xa0\xa0" + customers[i]['name1'];
      else
        telItem[0] = customers[i]['tel'] + "\xa0\xa0" + customers[i]['k_name'];
			telItem[1] = customers[i]['k_id'];
			acTelList.push(telItem);
		}
	}
	acNameList.sort(sortList());
	acName1List.sort(sortList());
	acPostList.sort(sortList());
	acVatList.sort(sortList());

  acAddList.sort(sortList());
  acCityList.sort(sortList());
  acTelList.sort(sortList());
}
function sortList() {
	return function(a,b){
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	}
}
function acCustLoadControl(field, control) {
	if (field == "k_name")
		acCustAutoComplete(control, acNameList, 1);
	else if (field == "name1")
		acCustAutoComplete(control, acName1List, 1);
	else if (field == "post")
		acCustAutoComplete(control, acPostList, 0);
	else if (field == "ustno")
		acCustAutoComplete(control, acVatList, 0);
  else if (field == "address")
		acCustAutoComplete(control, acAddList, 0);
  else if (field == "city")
		acCustAutoComplete(control, acCityList, 0);
  else if (field == "tel")
		acCustAutoComplete(control, acTelList, 0);
}

function acCustAutoComplete(inp, arr, wild) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value, att;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
if (wild) {
        /*check if the item starts with the same letters as the text field value:*/
		var strongIndex = (arr[i][0].toLowerCase()).indexOf(val.toLowerCase());
		if (strongIndex >= 0) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
		  att = document.createAttribute("class");       // Create a "class" attribute
		  att.value = "p-1";                           // Set the value of the class attribute
		  b.setAttributeNode(att);   
		  b.innerHTML = "";
          /*make the matching letters bold:*/
			b.innerHTML += "<a style='font-family:courier'>" + arr[i][0].substr(0, strongIndex) + "</a>";
			b.innerHTML += "<b style='font-family:courier'>" + arr[i][0].substr(strongIndex, val.length) + "</b>";
			b.innerHTML += "<a style='font-family:courier'>" + arr[i][0].substr(strongIndex + val.length) + "</a>";
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += '<input type="hidden" value="' + arr[i][0]+ '" id="' + arr[i][1] +'">';
          /*execute a function when someone clicks on the item value (DIV element):*/
			  b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value; 
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
			  acCustDone(inp, this.getElementsByTagName("input")[0].id);
			});
          a.appendChild(b);
        }
} else {
        /*check if the item starts with the same letters as the text field value:*/
       if (arr[i][0].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
		  att = document.createAttribute("class");       // Create a "class" attribute
		  att.value = "p-1";                           // Set the value of the class attribute
		  b.setAttributeNode(att);   
		  b.innerHTML = "";
          /*make the matching letters bold:*/
          b.innerHTML += "<b style='font-family:courier'>" + arr[i][0].substr(0, val.length) + "</b>";
          b.innerHTML += "<a style='font-family:courier'>" + arr[i][0].substr(val.length) + "</a>";
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += '<input type="hidden" value="' + arr[i][0] + '" id="' + arr[i][1] +'">';
          /*execute a function when someone clicks on the item value (DIV element):*/
			  b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value; 
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
			  acCustDone(inp, this.getElementsByTagName("input")[0].id);
			});
          a.appendChild(b);
        }	
}
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

