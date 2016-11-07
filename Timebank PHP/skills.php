<?php require_once 'header.php';

// Get username from session variable

$username = $_SESSION['username'];

// Query DB for user ID of logged in user so we can insert this into userskills table

$user = queryMysql("SELECT id FROM users WHERE username = '$username'");
$userrow = $user->fetch_assoc();
$user_id = $userrow['id'];

// Query DB for list of skills

$skills = queryMysql("SELECT * FROM skills");

// Has the form been submitted?
// If yes, retrieve each checkbox value

if (isset($_POST['Submit'])) {
    echo 'You have added the following skills to your profile:';

    // Insert user ID and skill ID checkbox value(s) into DB
    
    $checkboxes = isset($_POST['checked']) ? $_POST['checked'] : array();
	foreach ($checkboxes as $value) {
		echo " $value, ";
        queryMysql("INSERT INTO userskills (user_id, skill_id, skillOffered) VALUES ($user_id, $value, '1')");
	}
    
    $selHoursOffered = $_POST['selHoursOffered'];
    queryMysql("UPDATE users SET timeBalance = '$selHoursOffered' WHERE id = '$user_id'");
}

?>

<!-- Display the form -->

<h3>Step 2: Please tell us what skills you can offer:</h3>

<form method='post' action='skills.php'>    
    <table style="border: 1px solid silver;">
    <tr>
        <th>Skill Name</th>
        <th>I can OFFER this skill</th>
    </tr>
        
    <?php while ($row = $skills->fetch_assoc()) { ?>    
    <tr>
        <td><?=$row["skillname"];?></td>
        <td>
            <input type="checkbox" name="checked[]" value="<?=$row['id']?>" id="<?=$row['skillname']?>" />
        </td>
    </tr>
        
    <?php } ?>
        
    <tr>
        <td>How many hours would you like to offer?</td>
        <td><label for="selHoursOffered">Select:</label>
          <select name="selHoursOffered" id="selHoursOffered">
            <option value="0" selected="SELECTED">Select Hours</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select></td>
    </tr>
    
    </table>
        <span class='fieldname'>&nbsp;</span>
        <input type='submit' value='Submit' name="Submit">
</form>

<?php require_once 'footer.php'; ?>