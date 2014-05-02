/**
 * Created by Daniel Vidmar.
 * Date: 3/3/14
 * Time: 10:54 AM
 * Version: Beta 1
 * Last Modified: 3/3/14 at 10:54 AM
 * Last Modified by Daniel Vidmar.
 */

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

function checkUsername() {
    var form = document.getElementById("register");

    var username = form.getElementById("username").value;

    var ajaxString = "include/ajax/userajax.php?t=checkuser&username=" + username;

    ajax("POST", ajaxString, function callback(result) {
        if(result == "AVAILABLE") {
            //username is available
        } else {
            //username is not available
        }
    });
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
        }, 900);
}

function slideIn(id) {
    var element = document.getElementById(id);
    element.style.top = '250px';
    setTimeout(
        function add() {
            element.style.display = 'block';
            element.style.opacity = '1';
        }, 950);

    setTimeout(
        function add() {
            element.style.top = '0px';
        }, 1000);
}

function validEmail(email){
    //TODO: check if email is vaild
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