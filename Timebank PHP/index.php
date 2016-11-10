<?php require_once 'header.php'; ?>
<?php $updateStatus = ""; ?>
    
<p>Welcome to <?=$appname;?></p>

<?php

// Success message display
    
    if (isset($_GET['updateStatus'])) {
        $style = $_GET['updateStatus'];
        $message = $_GET['action'];
        echo "<div class = 'my-notify-" .$style. "'>". $message . " Success</div>";
    }

?>

<?php if ($loggedin) {
    
    // Get user details from DB
    
    $user = queryMysql("SELECT id, timeBalance FROM users WHERE username = '$username'");
    $row = $user->fetch_assoc();
    $user_id = $row['id'];
    $timeBalance = $row['timeBalance'];
    
    // Set up Time Balance variables
    
    $creditTimeBalance = $timeBalance + 1;
    $debitTimeBalance = $timeBalance - 1;
    
    // Get user's skill details from DB
    
    // User skills offered
    
    $skillsOffered = queryMysql("SELECT skills.id, skills.skillname FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE userskills.user_id = '$user_id' AND userskills.skillOffered = 1");
    
    // User skills requested
    
    $skillsRequested = queryMysql("SELECT skills.id, skills.skillname, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE userskills.user_id = '$user_id' AND userskills.skillRequested = 1");
    
    // Community skills requested - all - don't show user's own requests
    
    // $communitySkillsRequested = queryMysql("SELECT users.id,users.username, users.firstname, users.lastname, `skills`.`skillname`, userskills.id FROM `users` LEFT JOIN `userskills` ON `users`.`id` = `userskills`.`user_id` LEFT JOIN `skills` ON `userskills`.`skill_id` = `skills`.`id` WHERE userskills.skillRequested = 1 AND userskills.user_id != '$user_id'");
    
    // Display skill requests that match logged in user's skill offers
    
    $skillsRequestedMatched = queryMysql("SELECT users.*, skills.skillname, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillRequested = 1 AND timeOffered = 0 AND userskills.skill_id IN (SELECT skill_id FROM userskills WHERE user_id = '$user_id' AND skillOffered = 1)");
    
    // Display skill offers that match logged in user's skill requests
    
    $skillsOfferedMatched = queryMysql("SELECT users.id AS user_id, username, firstname, lastname, skills.id, skills.skillname, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillOffered = 1 AND timeOffered = 0 AND userskills.skill_id IN (SELECT skill_id FROM userskills WHERE user_id = '$user_id' AND skillRequested = 1)");
    
    // Has offer form been submitted?
    // If yes, update userskills table

    if (isset($_POST['SubmitOffer'])) {
        $offer_user_skills_id = $_POST['offer_user_skills_id'];
        $offer_request_user_id = $_POST['offer_request_user_id'];
        queryMysql("UPDATE userskills SET skillRequested = 0, timeOffered = 1, timeOfferedByUserId = '$user_id' WHERE id = '$offer_user_skills_id' AND user_id = '$offer_request_user_id'");
        
        // Add one credit to logged in user
        queryMysql("UPDATE users SET timeBalance = '$creditTimeBalance' WHERE id = '$user_id'");
        
        header("location: index.php?updateStatus=success&action=Offer");;
    }
    
    // Has the accept form been submitted?
    // If yes, update the userskills table
    
    if (isset($_POST['AcceptOffer'])) {
        
        $accept_request_skill_id = $_POST['accept_request_skill_id'];
        $accept_request_user_id = $_POST['accept_request_user_id'];
        
        // Logged in user no longer needs the skill they accepted so set this to 0
        queryMysql("UPDATE userskills SET skillRequested = 0, timeAccepted = 1, timeAcceptedByUserId = '$accept_request_user_id' WHERE user_id = '$user_id' AND skillRequested = 1 AND skill_id = '$accept_request_skill_id'");
        
        // Subtract one credit from logged in user
        queryMysql("UPDATE users SET timeBalance = '$debitTimeBalance' WHERE id = '$user_id'");
        
        // Add one credit user whose offer was accepted
        queryMysql("UPDATE users SET timeBalance = '$creditTimeBalance' WHERE id = '$accept_request_user_id'");
        
        header("location: index.php?updateStatus=success&action=Accept");
    }
    
?>

<table width="100%" cellspacing="20">
    <tr>
        <td width="33%" valign="top">
            <h3>Your Profile Summary</h3>
            <p>You are logged in as <?=$username." (".$user_id.")"?></p>
            <p>Your Time Balance (Credit) is: <?=$timeBalance?></p>
            <h3>These are your skills:</h3>

            <ul>
                <?php while ($skillsOfferedRow = $skillsOffered->fetch_assoc()) { ?>
                <li><?=$skillsOfferedRow['skillname']." (".$skillsOfferedRow['id'].")";?></li>
                <?php } ?>
            </ul>

            <h3>This is the help you need:</h3>
            
            <!-- If user has skills they need, display them -->
            
            <?php if(mysqli_num_rows($skillsRequested) > 0) { ?>

            <ul>
                <?php while ($skillsRequestedRow = $skillsRequested->fetch_assoc()) { ?>
                    <li><?=$skillsRequestedRow['skillname']." (".$skillsRequestedRow['id'].")";?></li>
                    <!-- <li>Id from userskills table is: <?=$skillsRequestedRow['userskills_id']?></li> -->
                <?php } ?> 
            </ul>

            <!-- Otherwise, display info message -->
            
            <?php } else {
            
                echo "<div class = 'my-notify-info'>You currently have no skills requested.</div>";
            
             } ?>
            
        </td>
        <td width="33%" valign="top">
            <h3>Community Skills Needed:</h3>
            
            <!-- If user has skills needed by other users, display those users -->
            
            <?php if(mysqli_num_rows($skillsRequestedMatched) > 0) { ?>
            
                <p>These members need your skills!<br />Earn Credits by offering your time to these community members:</p>
                <?php while ($skillsRequestedMatchedRow = $skillsRequestedMatched->fetch_assoc()) { ?>
                    <p>Username: <?=$skillsRequestedMatchedRow['username']." (".$skillsRequestedMatchedRow['id'].")";?><br/>
                    Name: <?=$skillsRequestedMatchedRow['firstname']." ".$skillsRequestedMatchedRow['lastname'];?><br/>
                    Would like help with: <strong><?=$skillsRequestedMatchedRow['skillname']." (".$skillsRequestedMatchedRow['userskills_id'].")";?></strong>
                    </p>
                    <form action="index.php" method="post" name="form1" id="form1">
                      <input type="submit" class="modern" name="SubmitOffer" id="submit" value="Offer 1 Hour">
                      <input type="hidden" name="offer_request_user_id" value=<?=$skillsRequestedMatchedRow['id']?>>
                      <input type="hidden" name="offer_user_skills_id" value=<?=$skillsRequestedMatchedRow['userskills_id']?>>
                    </form>
                    <hr />
                <?php } ?>
            
            <!-- Otherwise, display info message -->
            
            <?php } else {
            
                echo "<div class = 'my-notify-info'>There are currently no members who need your skills.</div>";
            
             } ?>
            
            
        </td>
        <td width="33%" valign="top">
            <h3>Community Skills Offered:</h3>
            
            <!-- If other users have skills needed by logged in user, display those users -->
            
            <?php if(mysqli_num_rows($skillsOfferedMatched) > 0) { ?>
            
                <p>These members have the skills to help you<br >Use your credit to buy the skills you need!</p>
                <?php while ($skillsOfferedMatchedRow = $skillsOfferedMatched->fetch_assoc()) { ?>
                    <p>Username: <?=$skillsOfferedMatchedRow['username']." (".$skillsOfferedMatchedRow['user_id'].")";?><br/>
                    Name: <?=$skillsOfferedMatchedRow['firstname']." ".$skillsOfferedMatchedRow['lastname'];?><br/>
                    Can offer: <strong><?=$skillsOfferedMatchedRow['skillname']." (".$skillsOfferedMatchedRow['userskills_id'].")";?></strong>
                    </p>
                    <form action="index.php" method="post" name="form1" id="form1">
                        <input type="submit" class="modern" name="AcceptOffer" id="submit" value="Accept Offer">
                        <input type="hidden" name="accept_request_skill_id" value=<?=$skillsOfferedMatchedRow['id']?>>
                        <input type="hidden" name="accept_request_user_id" value=<?=$skillsOfferedMatchedRow['user_id']?>>
                    </form>
                    <hr />
                <?php } ?>
            
            <!-- Otherwise, display info message -->
            
            <?php } else {
            
                echo "<div class = 'my-notify-info'>There are currently no members who offer the skills you need.</div>";
            
             } ?>
        </td>
    </tr>
</table>

<!-- If user is not logged in, display info message -->

<?php } else {

    echo "<div class = 'my-notify-info'>Please sign up or log in to join our community.</div>";

} ?>

<?php require_once 'footer.php'; ?>