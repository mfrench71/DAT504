<?php 

    require_once 'header.php';

    $updateStatus = "";

    // Success status message display
    
    if (isset($_GET['updateStatus'])) {
        $style = $_GET['updateStatus'];
        $message = $_GET['action'];
        echo "<div class = 'my-notify-" .$style. "'>". $message . " Success</div>";
    }

    // Get username from session variable

    $username = $_SESSION['username'];
    $offerError = $requestError = "";

    // Query DB for user ID of logged in user so we can insert this into userskills table

    $user = queryMysql("SELECT id FROM users WHERE username = '$username'");
    $userrow = $user->fetch_assoc();
    $user_id = $userrow['id'];

    // Queries for display of skills x 2

    $skills = queryMysql("SELECT skills.id, skills.skillname, skillRequested, skillOffered FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE userskills.user_id = '$user_id' ORDER BY skillname");
    
    $skills1 = queryMysql("SELECT skills.id, skills.skillname, skillRequested, skillOffered FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE userskills.user_id = '$user_id' ORDER BY skillname");

    // Queries to use later to loop through all skills and reset values

    $offerSkillsReset = queryMysql("SELECT id FROM skills");
    $requestSkillsReset = queryMysql("SELECT id FROM skills");

    // Has the offer skills form been submitted?

    if (isset($_POST['offerSubmit'])) {
        
        // Reset uerskills values
            
            while ($offerSkillsResetRow = $offerSkillsReset->fetch_assoc()) {
                $skillValue =  $offerSkillsResetRow['id'];
                queryMysql("UPDATE userskills SET skillOffered = '0', timeOffered = '0', timeOfferedByUserId = '0', timeAccepted = '0', timeAcceptedByUserId = '0', timeApproved = '0' WHERE user_id = '$user_id' AND skill_id = '$skillValue'");
            } 

        // $_POST['checked'] only exists if at least one checkbox is ticked, so check for this
        
        if(isset($_POST['checked'])) {
            
            // Insert checked values into userskills table
            
            $checkboxes = $_POST['checked'];
            // Loop through checkbox array, updating user ID, skill ID, checkbox and skillOffered values into DB
            foreach ($checkboxes as $value) {
                queryMysql("UPDATE userskills SET skillOffered = '1' WHERE user_id = '$user_id' AND skill_id = '$value'");
            }
            
            // Refresh page
            
            header("location: profile.php?updateStatus=success&action=Skills%20offered%20update");
            
        } else {

            // Otherwise, display an error

            $offerError = "<div class='my-notify-warning'>Please select at least one skill to offer.</div>";
        }
        
    }

    // Has the request skills form been submitted?

    if (isset($_POST['requestSubmit'])) {
        
        // Reset userskills values
            
            while ($requestSkillsResetRow = $requestSkillsReset->fetch_assoc()) {
                $skillValue =  $requestSkillsResetRow['id'];
                queryMysql("UPDATE userskills SET skillRequested = '0' , timeOffered = '0', timeOfferedByUserId = '0', timeAccepted = '0', timeAcceptedByUserId = '0', timeApproved = '0' WHERE user_id = '$user_id' AND skill_id = '$skillValue'");
            } 

        // $_POST['checked'] only exists if at least one checkbox is ticked, so check for this
        
        if(isset($_POST['checked'])) {
            
            // Insert checked values into userskills table
            
            $checkboxes = $_POST['checked'];
            // Loop through checkbox array, updating user ID, skill ID, checkbox and skillRequested values into DB
            foreach ($checkboxes as $value) {
                queryMysql("UPDATE userskills SET skillRequested = '1' WHERE user_id = '$user_id' AND skill_id = '$value'");
            }
            
            // Refresh page
            
            header("location: profile.php?updateStatus=success&action=Skills%20requested%20update");
            
        } else {

            // Otherwise, display an error

            $requestError = "<div class='my-notify-warning'>Please select at least one skill to offer.</div>";
        }
        
    }

?>

<div class="container">
    
    <h1><span class="fa fa-user fa-fw"></span> Profile</h1>
    
    <p class="my-notify-warning">Please note: Updating your profile will reset any outstanding time offers/acceptances in progress or awaiting approval.</p>
    
    <div class="columnHome">
        
        <h3>These are the skills you are currently offering:</h3>
        
        <!-- Display the form -->
        
        <form method="post" action="profile.php">
        <?=$offerError?>
            <table class="tableSignup" cellpadding="5">
                <tr>
                  <th>Skill</th>
                  <th>I can OFFER this skill</th>
                </tr>
                <?php while ($row = $skills->fetch_assoc()) { ?>
                <tr>
                  <td><?=$row["skillname"];?></td>
                  <td align="center"><input type="checkbox" <?php if($row['skillOffered']==1) { echo "checked"; } ?> name="checked[]" value="<?=$row['id']?>" id="<?=$row['skillname']?>" /></td>
                </tr>
                <?php } ?>
              </table>
            <input name="offerSubmit" class="modern" type="submit" id="Submit" value="Update">
        </form>
        
    </div>
    
    <div class="gutterHome"></div>
    
    <div class="columnHome">
        
        <h3>These are the skills you are currently requesting:</h3>
        
        <!-- Display the form -->
        
        <form method="post" action="profile.php">
        <?=$requestError?>
            <table class="tableSignup" cellpadding="5">
                <tr>
                  <th>Skill</th>
                  <th>I NEED this skill</th>
                </tr>
                <?php while ($row = $skills1->fetch_assoc()) { ?>
                <tr>
                  <td><?=$row["skillname"];?></td>
                  <td align="center"><input type="checkbox" <?php if($row['skillRequested']==1) { echo "checked"; } ?> name="checked[]" value="<?=$row['id']?>" id="<?=$row['skillname']?>" /></td>
                </tr>
                <?php } ?>
              </table>
            <input name="requestSubmit" class="modern" type="submit" id="Submit" value="Update">
        </form>
        
    </div>

</div>

<br style="clear:both;">

<?php require_once 'footer.php' ?>  