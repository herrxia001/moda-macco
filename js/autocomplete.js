function autocomplete(inp, arr, img) {
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
        /*check if the item starts with the same letters as the text field value:*/
       if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
		  att = document.createAttribute("class");       // Create a "class" attribute
		  att.value = "p-1";                           // Set the value of the class attribute
		  b.setAttributeNode(att);   
		  b.innerHTML = "";
		  if (img)
			  b.innerHTML = "<img height='80' src='"+img[i]+"'><a>\xa0\xa0\xa0\xa0\xa0\xa0</a>";
          /*make the matching letters bold:*/
          b.innerHTML += "<b style='font-family:courier'>" + arr[i].substr(0, val.length) + "</b>";
          b.innerHTML += "<a style='font-family:courier'>" + arr[i].substr(val.length) + "</a>";
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += '<input type="hidden" value="' + arr[i] + '">';
          /*execute a function when someone clicks on the item value (DIV element):*/
			  b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value; 
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
			  doneAutocomp();
			});
          a.appendChild(b);
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

function autocomplete_like(inp, arr, img) {
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
        /*check if the item starts with the same letters as the text field value:*/
		var strongIndex = (arr[i].toLowerCase()).indexOf(val.toLowerCase());
		if (strongIndex >= 0) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
		  att = document.createAttribute("class");       // Create a "class" attribute
		  att.value = "p-1";                           // Set the value of the class attribute
		  b.setAttributeNode(att);   
		  b.innerHTML = "";
		  if (img && val.length > 1)
			  b.innerHTML = "<img height='80' src='"+img[i]+"'><a>\xa0\xa0\xa0\xa0\xa0\xa0</a>";
          /*make the matching letters bold:*/
			b.innerHTML += "<a style='font-family:courier'>" + arr[i].substr(0, strongIndex) + "</a>";
			b.innerHTML += "<b style='font-family:courier'>" + arr[i].substr(strongIndex, val.length) + "</b>";
			b.innerHTML += "<a style='font-family:courier'>" + arr[i].substr(strongIndex + val.length) + "</a>";
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += '<input type="hidden" value="' + arr[i] + '">';
          /*execute a function when someone clicks on the item value (DIV element):*/
			  b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value; 
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
			  doneAutocomp();
			});
          a.appendChild(b);
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



function autocomplete_like_callback(inp, arr, img, callback) {
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
        /*check if the item starts with the same letters as the text field value:*/
		var strongIndex = (arr[i].toLowerCase()).indexOf(val.toLowerCase());
		if (strongIndex >= 0) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
		  att = document.createAttribute("class");       // Create a "class" attribute
		  att.value = "p-1";                           // Set the value of the class attribute
		  b.setAttributeNode(att);   
		  b.innerHTML = "";
		  if (img && val.length > 1)
			  b.innerHTML = "<img height='80' src='"+img[i]+"'><a>\xa0\xa0\xa0\xa0\xa0\xa0</a>";
          /*make the matching letters bold:*/
			b.innerHTML += "<a style='font-family:courier'>" + arr[i].substr(0, strongIndex) + "</a>";
			b.innerHTML += "<b style='font-family:courier'>" + arr[i].substr(strongIndex, val.length) + "</b>";
			b.innerHTML += "<a style='font-family:courier'>" + arr[i].substr(strongIndex + val.length) + "</a>";
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += '<input type="hidden" value="' + arr[i] + '">';
          /*execute a function when someone clicks on the item value (DIV element):*/
			  b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value; 
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
              callback();
			});
          a.appendChild(b);
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

/*Get all suppliers*/
function autoSups(sname, sups){
	var a_sname = new Array();	
	
	for (var i = 0; i < sups.length; i++) {
		a_sname[i] = sups[i]['s_name'];		
	}
	
	autocomplete(sname, a_sname);
}

/*Get all types*/
function autoTypes(tname, types){
	var a_tname = new Array();
	
	for (var i = 0; i < types.length; i++) {
		a_tname[i] = types[i]['t_name'];
	}
	
	autocomplete(tname, a_tname);
}

/*Get all variants*/
function autoVariants(vname, variants){
	var a_vname = new Array();
	
	for (var i = 0; i < variants.length; i++) {
		a_vname[i] = variants[i]['variant'];
	}
	
	autocomplete(vname, a_vname);
}

/*Get all customers*/
function sortList() {
	return function(a,b){
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	}
}
function formatListItem(item, length) {
	if (item[0] == " ")
		item = item.substring(1);
	else
		item = item.replace(/\s\s+/g, ' ');
	var newItem = ""; 
	if (item.length == length)
		newItem = item;
	else if (item.length > length) {
		newItem = item.substring(0, length); 
	} else {
		newItem = item;
		for (var i=0; i<length-item.length; i++) {
			newItem += "\xa0";
		}
	}
	return newItem; 
}
function loadAutoList(old, field) { 
	var list = new Array();
	var count = 0, i;
	for (i = 0; i < old.length; i++) {
		if (old[i][field] != null && old[i][field] != "") {
			if (field == 'post')
				list[count] = formatListItem(old[i][field], 8)+"\xa0"+formatListItem(old[i]['k_name'], 20)+"\xa0#"+old[i]['k_id'];
			else if (field == 'ustno')
				list[count] = formatListItem(old[i][field], 11)+"\xa0"+formatListItem(old[i]['k_name'], 16)+"\xa0#"+old[i]['k_id'];
			else
				list[count] = formatListItem(old[i][field], 20)+"\xa0#"+old[i]['k_id'];
			count++;
		}
	}
	list.sort(sortList());
	return list;
}

