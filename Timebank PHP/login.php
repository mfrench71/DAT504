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
            $error = "<p class='error'>Not all fields were completed.</p>";
        
        // If all form fields completed, query database for user details
        
        else {
            $result = queryMySQL("SELECT username, password, timeBalance FROM users WHERE username='$username' AND password='$password'");
            
            // Fetch the results
            
            $row = $result->fetch_assoc();
            
            // If no results (no match), display error message

            if ($result->num_rows == 0) {
                $error = "<p class='error'>Username/Password invalid</p>";
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

<form method="post" action="login.php">
<?=$error;?>
<table>
	<tr>
    	<td>
			<label for="username">Username</label>
		</td>
    	<td>
        	<input name="username" type="text" class="simple-input" value="<?=$username;?>" size="40" maxlength="255">
       	</td>
	</tr>
	<tr>
		<td>
			<label for="password">Password</label>
		</td>
   		<td>
   			<input name="password" type="password" class="simple-input" value="<?=$password;?>" size="40" maxlength="16">
   		</td>
  	<tr>
  		<td> 
			<input type="submit" class="modern" value="Login">
		</td>
		<td>
		</td>
	</tr>
</table>
</form>

<?php require_once 'footer.php'; ?>