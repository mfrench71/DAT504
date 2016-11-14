// Function for shorthand getElementById

function O(obj) {
    if (typeof obj == 'object') return obj
    else return document.getElementById(obj)
}

// Function for accessing object style

function S(obj) {
    return O(obj).style;
}

// Function to return all elements by class name

function C(name) {
    var elements = document.getElementsByTagName('*');
    var objects = [];
    for (var i = 0; i < elements.length; ++i)
        if (elements[i].className == name) objects.push(elements[i])
    return objects;
}

// Check stats AJAX
    
   function checkStats() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("stats").innerHTML =
            this.responseText;
       }
    };
    xhttp.open("POST", "checkStats.php", true);
    xhttp.send();
} 

// Check Username AJAX
    
   function checkUser(username) {
    
    if (username.value == '') {
        O('info').innerHTML = ''
        return
    }
       
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            O("info").innerHTML =
            this.responseText;
       }
    };
    xhttp.open("POST", "checkUser.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username=" + username.value);
} 

// Check Password AJAX
    
   function checkPassword(password) {
    
    if (password.value == '') {
        O('passwordInfo').innerHTML = ''
        return
    }
       
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            O("passwordInfo").innerHTML =
            this.responseText;
       }
    };
    xhttp.open("POST", "checkPassword.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("password=" + password.value);
}

// jQuery function to hide status messages on click

$(document).ready(function(){
    $(".my-notify-success").click(function(){
        $(this).fadeOut();
    });
});