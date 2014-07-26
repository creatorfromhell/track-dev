/**
 * Created by Daniel Vidmar.
 * Date: 3/3/14
 * Time: 10:54 AM
 * Version: Beta 1
 * Last Modified: 3/3/14 at 10:54 AM
 * Last Modified by Daniel Vidmar.
 */

function removeLabel(div, id) {
    var labelField = document.getElementsByName(div)[0];
    var labelString = labelField.value;
    var labels = labelString.split(',');
    var newString = "";
    for(i = 0; i < labels.length; i++) {
        if(labels[i] != id) { newString += labels[i]; }
        if(i < (labels.length - 1) && i != 0) { newString += ","; }
    }
    labelField.value = newString;
}

function addLabel(div, id) {
    var labelField = document.getElementsByName(div)[0];
    var labelString = labelField.value;
    if(labelString != null && labelString != "") { labelString += ","; }
    labelString += id;
    labelField.value = labelString;
}

function onDragOver(event) {
    event.preventDefault();
}

function onDrag(event) {
    event.dataTransfer.setData("label", event.target.id);
}

function onDrop(event) {
    event.preventDefault();
    var label = event.dataTransfer.getData("label");
    event.target.appendChild(document.getElementById(label));
    var labelID = label.split('-')[1];
    var targetID = event.target.id;
    if(targetID == "labels-chosen") {
        addLabel("labels", labelID);
    } else if(targetID == "labels-chosen-edit") {
        addLabel("labels-edit", labelID);
    } else if(targetID == "labels-available") {
        removeLabel("labels", labelID);
    } else if(targetID == "labels-available-edit") {
        removeLabel("labels-edit", labelID);
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

function showDiv(div) {
    var element = document.getElementById(div);
    element.style.opacity = '0';
    element.style.display = 'block';
    setTimeout(
        function add() {
            element.style.opacity = '1';
        }, 200);
}

function hideDiv(div) {
    var element = document.getElementById(div);
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