/**
 * Created by Daniel Vidmar.
 * Date: 3/3/14
 * Time: 10:54 AM
 * Version: Beta 1
 * Last Modified: 3/3/14 at 10:54 AM
 * Last Modified by Daniel Vidmar.
 */
window.onload = function() {
    positionForms();
}

function showValue(div, value) {
    var element = document.getElementById(div);
    element.innerHTML = value;
}

function positionForms() {
    var project = document.getElementById("project_add");
    if(project != null) {
        var main = document.getElementById("main");
        var left = (main.style.width / 2) - 214;
        project.style.left = left;
        return;
    }

    var list = document.getElementById("list_add");
    if(list != null) {
        var main = document.getElementById("main");
        var left = (main.style.width / 2) - 214;
        list.style.left = left;
        return;
    }

    var task = document.getElementById("task_add");
    if(task != null) {
        var main = document.getElementById("main");
        var left = (main.style.width / 2) - 214;
        task.style.left = left;
        return;
    }
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