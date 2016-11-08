<?php require_once 'header.php';

// Get username from session variable

$username = $_SESSION['username'];

// Query DB for user ID of logged in user so we can insert this into userskills table

$user = queryMysql("SELECT id FROM users WHERE username = '$username'");
$userrow = $user->fetch_assoc();
$user_id = $userrow['id'];

// Query DB for list of skills

$skills = queryMysql("SELECT * FROM skills ORDER BY skillname");

// Has the form been submitted?
// If yes, retrieve each checkbox value

if (isset($_POST['Submit'])) {
    echo 'You have requested the following skills:';

    // Insert user ID and skill ID checkbox value(s) into DB
    
    $checkboxes = isset($_POST['checked']) ? $_POST['checked'] : array();
	foreach ($checkboxes as $value) {
		echo " $value, ";
        queryMysql("INSERT INTO userskills (user_id, skill_id, skillRequested) VALUES ($user_id, $value, '1')");
	}
    
    header("location: index.php");
}

?>

<!-- Display the form -->

<h3>Step 3: Please tell us what help you need:</h3>

<form method='post' action='skills1.php'>    
    <table style="border: 1px solid silver;">
    <tr>
        <th>Skill Name</th>
        <th>I need help with</th>
    </tr>
        
    <?php while ($row = $skills->fetch_assoc()) { ?>    
    <tr>
        <td><?=$row["skillname"];?></td>
        <td>
            <input type="checkbox" name="checked[]" value="<?=$row['id']?>" id="<?=$row['skillname']?>" />
        </td>
    </tr>
        
    <?php } ?>
    
    </table>
        <input name="Submit" type="submit" id="Submit" value="Submit">
</form>

<?php require_once 'footer.php'; ?>