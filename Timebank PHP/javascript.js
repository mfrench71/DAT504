// Function for shorthand getElementById

function O(obj) {
    if (typeof obj == 'object') return obj
    else return document.getElementById(obj)
}

// Check stats AJAX
    
   function checkStats() {
    // Create new request object
    var xhttp = new XMLHttpRequest();
    // Create event handler
    xhttp.onreadystatechange = function() {
        // Wait for response from (readyState of '4' - complete and response received and status of '200' - OK)
        if (this.readyState == 4 && this.status == 200) {
            // Set the HTML for the stats <span> to the response from checkStats.php
            O("stats").innerHTML = this.responseText;
       }
    };
    // Open and send request with no parameters
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
            O("info").innerHTML = this.responseText;
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
            O("passwordInfo").innerHTML = this.responseText;
       }
    };
    xhttp.open("POST", "checkPassword.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("password=" + password.value);
}

// Check Email AJAX
    
   function checkEmail(email) {
    
    if (email.value == '') {
        O('emailInfo').innerHTML = ''
        return
    }
       
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            O("emailInfo").innerHTML = this.responseText;
       }
    };
    xhttp.open("POST", "checkEmail.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("email=" + email.value);
} 


// jQuery function to hide status messages on click

$(document).ready(function(){
    $(".my-notify-success").click(function(){
        $(this).fadeOut();
    });
});

// jQuery Profile panel accordion

$(document).ready(function () {
    $('div.panel0> h3').click(function () {
        $(this).siblings('.opened').end()
        .toggleClass('opened').next('div').slideToggle('normal')
        .siblings('div:visible');
        return false;
    });
});