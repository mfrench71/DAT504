<?php require_once 'header.php';

// Get username from session variable

$username = $_SESSION['username'];
$error = "";

// Query DB for user ID of logged in user so we can insert this into userskills table

$user = queryMysql("SELECT id FROM users WHERE username = '$username'");
$userrow = $user->fetch_assoc();
$user_id = $userrow['id'];

// Query DB for list of skills

$skills = queryMysql("SELECT * FROM skills ORDER BY skillname");

// Has the form been submitted?

if (isset($_POST['Submit'])) {
    
    // $_POST['checked'] only exists if at least one checkbox is ticked, so check for this
    
    if(isset($_POST['checked'])) {
        $checkboxes = $_POST['checked'];
        // If yes, loop through checkbox array, updating user ID, skill ID, checkbox and skillRequested values into DB
        foreach ($checkboxes as $value) {
        // queryMysql("INSERT INTO userskills (user_id, skill_id, skillRequested) VALUES ($user_id, $value, '1')");
            queryMysql("UPDATE userskills SET skillRequested = '1' WHERE user_id = '$user_id' AND skill_id = '$value'");
        }
        
        // Redirect to next page
    
        header("location: index.php?updateStatus=success&action=Profile%20Created");
        
    } else {
        
        // Otherwise, display an error
        
        $error = "<div class='my-notify-warning'>Please select at least one skill.</div>";
    }
    
}

?>

<!-- Display the form -->

<div class="container">
    
    <h1><span class="fa fa-user-plus fa-fw"></span> Sign Up</h1>

    <h3>Step 3: Please tell us what help you NEED:</h3>

    <form method='post' action='skills1.php'>
        <?=$error?>
        <table class="tableSignup" cellpadding="5">
        <tr>
            <th>Skill</th>
            <th>I NEED help with</th>
        </tr>
            
        <!-- Loop through skills and output skill name and correspoding checkbox -->

        <?php while ($row = $skills->fetch_assoc()) { ?>    
        <tr>
            <td><?=$row["skillname"];?></td>
            <td align="center">
                <input type="checkbox" name="checked[]" value="<?=$row['id']?>" id="<?=$row['skillname']?>" />
            </td>
        </tr>

        <?php } ?>

        </table>
            <input name="Submit" class="modern" type="submit" id="Submit" value="Finish">
    </form>
    
</div>

<?php require_once 'footer.php'; ?>