<?php
require_once 'header.php';
echo "<div class='main'><h3>Please enter your details to log in</h3>";
$error = $username = $password = "";
if (isset($_POST['username']))
{
$username = cleanString($_POST['username']);
$password = cleanString($_POST['password']);
if ($username == "" || $password == "")
$error = "Not all fields were entered<br>";
else
{
$result = queryMySQL("SELECT username ,password, creditBalance FROM users
WHERE username='$username' AND password='$password'");
$row = $result->fetch_assoc();

if ($result->num_rows == 0)
{
    $error = "<span class='error'>Username/Password
    invalid</span><br><br>";
}
    
else
    
{
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['creditBalance'] = $row['creditBalance'];
    die("You are now logged in.<br><br>");
}
    
}
}
echo <<<_END
<form method='post' action='login.php'>$error
<span class='fieldname'>Username</span><input type='text'
maxlength='255' name='username' value='$username'><br>
<span class='fieldname'>Password</span><input type='password'
maxlength='16' name='password' value='$password'>
_END;
?>
    <br> <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Login'> </form>
    <br> </div>
    </body>

    </html>