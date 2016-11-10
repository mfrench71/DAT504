<?php require_once 'header.php'; ?>
<script>
    
    // Username available AJAX
    
    // If username field empty, clear info DIV
    function checkUser(username) {
        if (username.value == '') {
            O('info').innerHTML = ''
            return
        }
    
        params = "username=" + username.value
        request = new ajaxRequest()
        request.open("POST", "checkUser.php", true)
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
    
    // Check password strength AJAX
    
    // If password field empty, clear info DIV
    function checkPassword(password) {
        if (password.value == '') {
            O('passwordInfo').innerHTML = ''
            return
        }
    
        params = "password=" + password.value
        request = new ajaxRequest()
        request.open("POST", "checkPassword.php", true)
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        request.setRequestHeader("Content-length", params.length)
        request.setRequestHeader("Connection", "close")
    
        request.onreadystatechange = function() {
            if (this.readyState == 4)
                if (this.status == 200)
                    if (this.responseText != null)
                        O('passwordInfo').innerHTML = this.responseText
        }
        request.send(params)
    }
    
    // AJAX request
    
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
<?php

    $error = $username = $password = $firstname = $lastname = "";
    if (isset($_SESSION['username'])) destroySession();

    if (isset($_POST['username'])) {
        $username = cleanString($_POST['username']);
        $password = cleanString($_POST['password']);    
        $firstname = cleanString($_POST['firstname']);    
        $lastname = cleanString($_POST['lastname']);

        if ($username == "" || $password == "" || $firstname == "" || $lastname == "")
            $error = "<div class='my-notify-warning'>Not all fields were completed.</div>";
        else {
            $result = queryMysql("SELECT * FROM users WHERE username='$username'");
            if ($result->num_rows)
                $error = "<div class='my-notify-warning'>That username already exists.</div>";
            else {
                queryMysql("INSERT INTO users (username, password, firstname, lastname, timeBalance) VALUES('$username', '$password', '$firstname', '$lastname','1')");
                $_SESSION['username'] = $username;
                header("location: skills.php");
                die("<h4>Account created</h4>Please Log in.");
            }
        }
    }
?>

<!-- Display sign up form -->

<h3>Step 1: Please enter your details to sign up:</h3>
<form method='post' action='signup.php'>
  <?=$error;?>
  <table>
    <tr>
      <td><label for="username">Username</label></td>
      <td><input type="text" class="simple-input" maxlength="255" name="username" size="35" onBlur="checkUser(this)" value=<?=$username;?>></td>
      <td><span id='info'></span></td>
    </tr>
    <tr>
      <td><label for="password">Password</label></td>
      <td><input type="text" class="simple-input" maxlength="16" name="password" size="35" onBlur="checkPassword(this)" value=<?=$password;?>></td>
      <td><div id="passwordInfo"></div></td>
    </tr>
    <tr>
      <td><label for="firstname">First Name</label></td>
      <td><input type="text" class="simple-input" maxlength="255" name="firstname" size="35" value=<?=$firstname;?>></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="lastname">Last Name</label></td>
      <td><input type="text" class="simple-input" maxlength="255" name="lastname" size="35" value=<?=$lastname;?>></td>
      <td></td>
    </tr>
    <tr>
      <td><input type="submit" class="modern" value="Step 2 >>"></td>
      <td></td>
      <td></td>
    </tr>
  </table


</form>
<?php require_once 'footer.php'; ?>