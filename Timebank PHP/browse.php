<?php require_once 'header.php'; ?>

<?php

    // If form submitted, set selected skill ID to form value
    // Otherwise, set to wildcard to show all

    if (isset($_POST['offered_id'])) {
        $selectedOfferedSkill = $_POST['offered_id'];
    } else {
        $selectedOfferedSkill = "%";
    }

    // If form submitted, set selected skill ID to form value
    // Otherwise, set to wildcard to show all

    if (isset($_POST['requested_id'])) {
        $selectedRequestedSkill = $_POST['requested_id'];
    } else {
        $selectedRequestedSkill = "%";
    }

    // Query DB for all offered skills

    $skillsOfferedMenu = queryMysql("SELECT DISTINCT skills.skillname, skills.id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillOffered = 1 ORDER BY skillname ASC");

    // Query DB for all requested skills

    $skillsRequestedMenu = queryMysql("SELECT DISTINCT skills.skillname, skills.id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillRequested = 1 ORDER BY skillname ASC");

    // Query DB for offered skills filtered by select menu

    $skillsOffered = queryMysql("SELECT users.id AS user_id, username, firstname, lastname, skills.skillname, skills.id, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillOffered = 1 AND timeOffered = 0 AND skills.id LIKE '$selectedOfferedSkill'");

    // Query DB for selected skills filtered by select menu

    $skillsRequested = queryMysql("SELECT users.id AS user_id, username, firstname, lastname, skills.skillname, skills.id, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillRequested = 1 AND timeAccepted = 0 AND skills.id LIKE '$selectedRequestedSkill'");

?>

<div class="container">
  
    <h1><span class="fa fa-list fa-fw"></span> Browse</h1>
    
        <?php if (!$loggedin) { ?>
    
            <!-- If the user is not logged in, display message -->
        
            <div class = "my-notify-info">Please <a href="signup.php">sign up</a> or <a href="login.php">log in</a> to offer your own skills or request help.</div>
        
        <?php } ?>
    
    <div class="columnBrowse">

        <!-- Community Skills Offered -->
        
        <h3>Community Skills Offered:</h3>
        
        <!-- Display select menu -->
        
        <form method="POST" action="browse.php">
        <select name="offered_id">
            <option value="%">Show All</option>
                <?php 
                    while ($skillsOfferedMenuRow = $skillsOfferedMenu->fetch_assoc()) {
                        $id = $skillsOfferedMenuRow['id'];
                        $name = $skillsOfferedMenuRow['skillname']; 
                        echo '<option value="'.$id.'">'.$name.'</option>';
                    }
            
                ?>    
        </select>
        <input type = "submit" class = "modern" name = "Submit" value = "Go"/>
        </form>

        <?php while ($skillsOfferedRow = $skillsOffered->fetch_assoc()) { ?>

            <div class = "panel">
                <p><span class="fa fa-user-circle fa-fw"></span> <?=$skillsOfferedRow['username']?><br/>
                <?php if ($loggedin) { ?>
                    Name: <?=$skillsOfferedRow['firstname']." ".$skillsOfferedRow['lastname'];?><br/>
                <?php } ?>
                Is offering help with: <strong><?=$skillsOfferedRow['skillname']?></strong>
                </p>
            </div>

        <?php } ?>
        
    </div>
    
    <div class="columnBrowse">
        
        <!-- Community Skills Needed -->
        
        <h3>Community Skills Requested:</h3>
        
        <!-- Display select menu -->
        
        <form method="POST" action="browse.php">
        <select name="requested_id">
            <option value="%">Show All</option>
                <?php 
                    while ($skillsRequestedMenuRow = $skillsRequestedMenu->fetch_assoc()) {
                        $id = $skillsRequestedMenuRow['id'];
                        $name = $skillsRequestedMenuRow['skillname']; 
                        echo '<option value="'.$id.'">'.$name.'</option>';
                    }
            
                ?>    
        </select>
        <input type = "submit" class = "modern" name = "Submit" value = "Go"/>
        </form>

        <?php while ($skillsRequestedRow = $skillsRequested->fetch_assoc()) { ?>

            <div class = "panel1">
                <p><span class="fa fa-user-circle-o fa-fw"></span> <?=$skillsRequestedRow['username']?><br/>
                <?php if ($loggedin) { ?>
                    Name: <?=$skillsRequestedRow['firstname']." ".$skillsRequestedRow['lastname'];?><br/>
                <?php } ?>
                Is requesting help with: <strong><?=$skillsRequestedRow['skillname']?></strong>
                </p>
            </div>

        <?php } ?>

        </div>
    
</div>

<br style="clear: both;" />

<?php require_once 'footer.php'; ?>