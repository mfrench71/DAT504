<?php require_once 'header.php'; ?>

<script>
    
    // If username field empty, clear info DIV
    function checkUser(username) {
        if (username.value == '') {
            O('info').innerHTML = ''
            return
        }
    
        params = "username=" + username.value
        request = new ajaxRequest()
        request.open("POST", "checkuser.php", true)
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        request.setRequestHeader("Content-length", params.length)
        request.setRequestHeader("Connection", "close")
    
        request.onreadystatechange = function() {
            if (this.readyState == 4)
                if (this.status == 200)
                    if (this.responseText != null)
                        O('info').innerHTML = this.responseText
        }
        request.send(params)
    }
    
    function ajaxRequest() {
        try { var request = new XMLHttpRequest() }
        catch(e1) {
            try { request = new ActiveXObject("Msxml2.XMLHTTP") }
            catch(e2) {
                try { request = new ActiveXObject("Microsoft.XMLHTTP") }
                catch(e3) {
                    request = false
                } 
            } 
        }
                
        return request
    }
    
</script>

<h3>Please enter your details to sign up</h3>

<?php

    $error = $username = $password = $firstname = $lastname = "";
    if (isset($_SESSION['username'])) destroySession();

    if (isset($_POST['username'])) {
        $username = cleanString($_POST['username']);
        $password = cleanString($_POST['password']);    
        $firstname = cleanString($_POST['firstname']);    
        $lastname = cleanString($_POST['lastname']);    

        if ($username == "" || $password == "" || $firstname == "" || $lastname == "")
            $error = "Not all fields were completed<br><br>";
        else {
            $result = queryMysql("SELECT * FROM users WHERE username='$username'");
            if ($result->num_rows)
                $error = "That username already exists<br><br>";
            else {
                queryMysql("INSERT INTO users (username, password, firstname, lastname, timeBalance, creditBalance) VALUES('$username', '$password', '$firstname', '$lastname','0','1')");
                die("<h4>Account created</h4>Please Log in.<br><br>");
            }
        }
    }
?>

<form method='post' action='signup.php'><?=$error;?>

    <span class='fieldname'>Username</span>
    <input type='text' maxlength='255' name='username' onBlur="checkUser(this)" value=<?=$username;?>><span id='info'></span><br>

    <span class='fieldname'>Password</span>
    <input type='text' maxlength='16' name='password' value=<?=$password;?>><br>

    <span class='fieldname'>First Name</span>
    <input type='text' maxlength='255' name='firstname' value=<?=$firstname;?>><br>

    <span class='fieldname'>Last Name</span>
    <input type='text' maxlength='255' name='lastname' value=<?=$lastname;?>><br>

    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Sign up'>

</form>
