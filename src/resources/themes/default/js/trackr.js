/**
 * Created by Daniel Vidmar.
 * Date: 3/3/14
 * Time: 10:54 AM
 * Version: Beta 1
 * Last Modified: 3/3/14 at 10:54 AM
 * Last Modified by Daniel Vidmar.
 */

function linkColorField(event, div, field) {
	var picker = document.getElementById("jspalette");
	var scrollLeft = (window.pageXOffset !== undefined) ? window.pageXOffset : (document.documentElement || document.body.parentNode || document.body).scrollLeft;
	var scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
	var mouseX = event.clientX + scrollLeft;
	var mouseY = event.clientY + scrollTop;
	
	picker.style.left = mouseX + 'px';
	picker.style.top = mouseY + 'px';
    picker.style.display = 'block';
    document.getElementById("jspalette-choose").onclick = function() {
        document.getElementById(div).style.background = document.getElementById("picked-color").value;
        document.getElementsByName(field)[0].value = document.getElementById("picked-color").value;
        document.getElementById("jspalette").style.display = 'none';
    }
    document.getElementById("jspalette-close").onclick = function() {
        document.getElementById("jspalette").style.display = 'none';
	}
}

function removeData(div, id) {
    var dataField = document.getElementsByName(div)[0];
    var dataString = dataField.value;
    var data = dataString.split(',');
    var newString = "";
    for(i = 0; i < data.length; i++) {
        if(data[i] != id) { newString += data[i]; }
        if(i < (data.length - 1) && i != 0) { newString += ","; }
    }
    dataField.value = newString;
}

function addData(div, id) {
    var dataField = document.getElementsByName(div)[0];
    var dataString = dataField.value;
    if(dataString != null && dataString != "") { dataString += ","; }
    dataString += id;
    dataField.value = dataString;
}

function onDragOver(event) {
    event.preventDefault();
}

function onDrag(event) {
    event.dataTransfer.setData("dragdata", event.target.id);
}

function onDrop(event, field, remove) {
    event.preventDefault();
    var div = event.dataTransfer.getData("dragdata");
    event.target.appendChild(document.getElementById(div));
    var dataID = div.split('-')[1];
    var targetID = event.target.id;
    if(remove == "remove") {
        removeData(field, dataID);
    } else {
        addData(field, dataID);
    }
}

function showValue(div, value) {
    var element = document.getElementById(div);
    element.innerHTML = value;
}

function showMessage(type, text) {
    var message = document.getElementById("msg");
    message.className = type;
    message.innerHTML = text;

    message.style.opacity = '0';
    message.style.display = 'block';
    setTimeout(
        function add() {
            message.style.opacity = '1';
        }, 100);
}

function closeMessage() {
    var message = document.getElementById("msg");

    message.style.opacity = '0';
    setTimeout(
        function add() {
            message.style.display = 'none';
        }, 600);
}

function showKey(name) {
    var module = document.getElementById(name);
    var key = module.getElementsByTagName("div")[0];

    key.style.opacity = '1';
}

function hideKey(name) {
    var module = document.getElementById(name);
    var key = module.getElementsByTagName("div")[0];

    key.style.opacity = '0';
}

function changeLanguage(language) {
    var ajaxString = "?lang=" + language;

    ajax("GET", ajaxString, function callback(result) {
        location.reload();
    });
}

function showDiv(div, useID) {
    var element = (typeof useID !== 'undefined' && !useID) ? div : document.getElementById(div);
    element.style.opacity = '0';
    element.style.display = 'block';
    setTimeout(
        function add() {
            element.style.opacity = '1';
        }, 200);
}

function hideDiv(div, useID) {
    var element = (typeof useID !== 'undefined' && !useID) ? div : document.getElementById(div);
    element.style.opacity = '0';
    setTimeout(
        function add() {
            element.style.display = 'none';
        }, 200);
}

function switchPage(event, pageID, nextPage) {

    slideOut(pageID);
    slideIn(nextPage);

    event.stopPropagation();
    return false;
}

function slideOut(id) {
    var element = document.getElementById(id);
    element.style.top = '-450px';
    element.style.opacity = '0';
    setTimeout(
        function add() {
            element.style.display = 'none';
        }, 200);
}

function slideIn(id) {
    var element = document.getElementById(id);
    element.style.top = '250px';
    setTimeout(
        function add() {
            element.style.display = 'block';
            element.style.opacity = '1';
        }, 200);

    setTimeout(
        function add() {
            element.style.top = '0px';
        }, 215);
}

function switchable(current, element) {
	var current = document.querySelector("." + current);
	var element = document.querySelector("." + element);
	
	hideDiv(current, false);
	showDiv(element, false);
}

//AJAX function
function ajax(type, url, callback) {
    try {
        var xhr = new XMLHttpRequest();
        xhr.open(type, url, false);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    callback(xhr.responseText);
                }
            }
        };
        xhr.send();
    } catch (e) {
        //TODO: Error logging
    }
}