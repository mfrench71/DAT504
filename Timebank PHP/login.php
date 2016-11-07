<?php require_once 'header.php'; ?>

<h3>Please enter your details to log in</h3>

<?php

    $error = $username = $password = "";

    // Has the form been submitted?
    // If yes, clean and set variables to whatever the user entered in the form

    if (isset($_POST['username'])) {
        $username = cleanString($_POST['username']);
        $password = cleanString($_POST['password']);
        
        // Basic form validation
        // If form fields incomplete, display error message

        if ($username == "" || $password == "")
            $error = "<p>Not all fields were completed.</p>";
        
        // If all form fields completed, query database for user details
        
        else {
            $result = queryMySQL("SELECT username, password, creditBalance FROM users WHERE username='$username' AND password='$password'");
            
            // Fetch the results
            
            $row = $result->fetch_assoc();
            
            // If no results (no match), display error message

            if ($result->num_rows == 0) {
                $error = "<p>Username/Password invalid</p>";
            }
            
            // If there is a result (match), set session variables and display logged in message
    
            else {
                
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                header("location: index.php");
                die("You are now logged in.<br><br>");
            }
        }
    }
?>

<!-- Display Login Form -->

<form method="post" action="login.php"><?=$error;?>
<span class="fieldname">Username</span>
    <input type="text" maxlength="255" name="username" value=<?=$username;?>>
<br>
<span class="fieldname">Password</span>
    <input type="password" maxlength="16" name="password" value=<?=$password;?>>
    <br><span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Login'></form>

<?php require_once 'footer.php'; ?>