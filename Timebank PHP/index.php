<?php require_once 'header.php'; ?>  
    
<p>Welcome to <?=$appname;?></p>

<?php if ($loggedin) {
    
    // Get user details from DB
    
    $user = queryMysql("SELECT id, timeBalance FROM users WHERE username = '$username'");
    $row = $user->fetch_assoc();
    $user_id = $row['id'];
    $timeBalance = $row['timeBalance'];
    
    // Get user's skill details from DB
    
    // User skills offered
    
    $skillsOffered = queryMysql("SELECT skills.id, skills.skillname FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE userskills.user_id = '$user_id' AND userskills.skillOffered = 1");
    
    // User skills requested
    
    $skillsRequested = queryMysql("SELECT skills.id, skills.skillname FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE userskills.user_id = '$user_id' AND userskills.skillRequested = 1");
    
    // Community skills requested - all - don't show user's own requests
    
    // $communitySkillsRequested = queryMysql("SELECT users.id,users.username, users.firstname, users.lastname, `skills`.`skillname`, userskills.id FROM `users` LEFT JOIN `userskills` ON `users`.`id` = `userskills`.`user_id` LEFT JOIN `skills` ON `userskills`.`skill_id` = `skills`.`id` WHERE userskills.skillRequested = 1 AND userskills.user_id != '$user_id'");
    
    // Display skill requests that match logged in user's skill offers
    
    $skillsRequestedMatched = queryMysql("SELECT users.*, skills.skillname, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillRequested = 1 AND timeOffered = 0 AND userskills.skill_id IN (SELECT skill_id FROM userskills WHERE user_id = '$user_id' AND skillOffered = 1)");
    
    // Get IDs of users making offers
    $timeOfferedByUserID = queryMysql("SELECT id FROM users WHERE id IN (SELECT timeOfferedByUserId FROM userskills WHERE user_id = '$user_id' AND timeOffered = 1 AND timeAccepted = 0)");
    $timeOfferedByUserIDRow = $timeOfferedByUserID->fetch_assoc();
    $offerUserId = $timeOfferedByUserIDRow['id'];
    
    // Query User table with ID of users making offers
    
    // Has form been submitted?
    // If yes, update userskills table with offer details

    if (isset($_POST['Submit'])) {
        $user_skills_id = $_POST['user_skills_id'];
        $request_user_id = $_POST['request_user_id'];
        queryMysql("UPDATE userskills SET timeOffered = 1, timeOfferedByUserId = '$user_id' WHERE id = '$user_skills_id' AND user_id = '$request_user_id'");
        header("location: index.php");
    }
?>

<table width="100%" cellspacing="20">
    <tr>
        <td width="33%" valign="top">
            <h3>Your Profile Summary</h3>
            <p>You are logged in as <?=$username?>.</p>
            <p>Your Time Balance is: <?=$timeBalance?></p>
            <h3>These are your skills:</h3>

            <ul>
                <?php while ($skillsOfferedRow = $skillsOffered->fetch_assoc()) { ?>
                <li><?=$skillsOfferedRow['skillname']." (".$skillsOfferedRow['id'].")";?></li>
                <?php } ?>
            </ul>

            <h3>This the help you need:</h3>

            <ul>
                <?php while ($skillsRequestedRow = $skillsRequested->fetch_assoc()) { ?>
                <li><?=$skillsRequestedRow['skillname']." (".$skillsRequestedRow['id'].")";?></li>
                <?php } ?>
            </ul>
        </td>
        <td width="33%" valign="top">
            <h3>Community Skills Needed:</h3>
            <p>These members need your skills!<br />Earn Credits by offering your time to these community members:</p>
             <?php while ($skillsRequestedMatchedRow = $skillsRequestedMatched->fetch_assoc()) { ?>
            <p>Username: <?=$skillsRequestedMatchedRow['username']." (".$skillsRequestedMatchedRow['id'].")";?><br/>
            Name: <?=$skillsRequestedMatchedRow['firstname']." ".$skillsRequestedMatchedRow['lastname'];?><br/>
            Would like help with: <strong><?=$skillsRequestedMatchedRow['skillname']." (".$skillsRequestedMatchedRow['userskills_id'].")";?></strong>
            </p>
            <form action="index.php" method="post" name="form1" id="form1">
              <input type="submit" name="Submit" id="submit" value="Offer 1 Hour">
              <input type="hidden" name="request_user_id" value=<?=$skillsRequestedMatchedRow['id']?>>
              <input type="hidden" name="user_skills_id" value=<?=$skillsRequestedMatchedRow['userskills_id']?>>
            </form>
            <hr />
        <?php } ?>
        </td>
        <td width="33%" valign="top"><h3>Community Skills Offered:</h3>
        <p>You have received offers of help from the following community members:</p></td>
    </tr>
</table>

<?php } else { ?>

<p>Please sign up or log in to join our community.</p>

<?php } ?>

<?php require_once 'footer.php'; ?>