<?php require_once 'header.php'; ?>

<?php

    // Set default values
    
    $error = "";
    $username = "";
    $password = "";
    $email = "";
    $firstname = "";
    $lastname = "";

    // If user is logged in i.e. they have accessed this page directly ...
    // Logout the user

    if (isset($_SESSION['username'])) destroySession();

    // Has the form been submitted?

    if (isset($_POST['username'])) {
        
        // If yes, clean and set variables to user's form input
        
        $username = cleanString($_POST['username']);
        $password = cleanString($_POST['password']);    
        $email = cleanString($_POST['email']);
        $firstname = cleanString($_POST['firstname']);    
        $lastname = cleanString($_POST['lastname']);
        
        // Basic form validation (empty values)

        if ($username == "" || $password == "" || $firstname == "" || $lastname == "")
            $error = "<div class='my-notify-warning'>Not all fields were completed.</div>";
        
        else {
            
            // Email validation
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "<div class='my-notify-warning'>Please enter a valid email address.</div>";
            }
            
            else {
            
                // If form values completed, query DB for existing username/email

                $userResult = queryMysql("SELECT username FROM users WHERE username='$username'");

                // If there's a result (username already in DB), display error message

                if ($userResult->num_rows)
                    $error = "<div class='my-notify-warning'>That username already exists.</div>";
                
                $emailResult = queryMysql("SELECT email FROM users WHERE email='$email'");

                // If there's a result (email already in DB), display error message

                if ($emailResult->num_rows)
                    $error = "<div class='my-notify-warning'>An account with that email address already exists.</div>";
            
                else {

                    // If no match, insert new user details into DB and set username session variable

                    queryMysql("INSERT INTO users (username, password, email, firstname, lastname, timeBalance) VALUES('$username', '$password', '$email', '$firstname', '$lastname','1')");
                    $_SESSION['username'] = $username;

                    // Redirect to Step 2

                    header("location: skills.php");
                }
            }
        }
    }
?>

<!-- Display sign up form -->

<div class="container">

    <h1><span class="fa fa-user-plus fa-fw"></span> Sign Up</h1>

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
              <td><input type="password" class="simple-input" maxlength="16" name="password" size="35" onBlur="checkPassword(this)" value=<?=$password;?>></td>
              <td><div id="passwordInfo"></div></td>
            </tr>
            <tr>
              <td><label for="email">Email</label></td>
              <td><input type="text" class="simple-input" maxlength="255" name="email" size="35" onBlur="checkEmail(this)" value=<?=$email;?>></td>
              <td><div id="emailInfo"></div></td>
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
      
</div>
            
<?php require_once 'footer.php'; ?>