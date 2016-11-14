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

if (isset($_POST['Submit'])) {

    // If yes, insert user ID, skill ID, checkbox and skillOffered values into DB
    
    $checkboxes = isset($_POST['checked']) ? $_POST['checked'] : array();
	foreach ($checkboxes as $value) {
        queryMysql("INSERT INTO userskills (user_id, skill_id, skillOffered) VALUES ($user_id, $value, '1')");
	}
    
    // Redirect to next page
    
    header("location: skills1.php");
}

?>

<!-- Display the form -->

<div class="container">
    
    <h1><span class="fa fa-user-plus fa-fw"></span> Sign Up</h1>

    <h3>Step 2: Please tell us what skills you can offer:</h3>
    
    <p class="my-notify-info">You'll be able to let us know what skills you NEED on the following page.</p>
    <form method="post" action="skills.php">
      <table cellpadding="5" style="border: 1px solid silver;">
        <tr>
          <th>Skill</th>
          <th>I can OFFER this skill</th>
        </tr>
        <?php while ($row = $skills->fetch_assoc()) { ?>
        <tr>
          <td><?=$row["skillname"];?></td>
          <td align="center"><input type="checkbox" name="checked[]" value="<?=$row['id']?>" id="<?=$row['skillname']?>" /></td>
        </tr>
        <?php } ?>
      </table>
      <input name="Submit" class="modern" type="submit" id="Submit" value="Step 3 &gt;&gt;">
    </form>
    
</div>    
<?php require_once 'footer.php'; ?>