<?php require_once 'header.php'; ?>

<?php

    $selectedSkill = "%";

    $skillsOffered = queryMysql("SELECT users.id AS user_id, username, firstname, lastname, skills.skillname, skills.id, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillOffered = 1 AND timeOffered = 0 AND skills.id LIKE '$selectedSkill'");

    $skillsRequested = queryMysql("SELECT users.id AS user_id, username, firstname, lastname, skills.skillname, skills.id, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillRequested = 1 AND timeAccepted = 0 AND skills.id LIKE '$selectedSkill'");

?>

<h1>Browse</h1>

<div class="container">
    
    <div class="columnBrowse">

<?php while ($skillsOfferedRow = $skillsOffered->fetch_assoc()) { ?>
                    
    <div class = "panel">
        <p>Username: <?=$skillsOfferedRow['username']." (".$skillsOfferedRow['user_id'].")";?><br/>
        Name: <?=$skillsOfferedRow['firstname']." ".$skillsOfferedRow['lastname'];?><br/>
        Is offering help with: <strong><?=$skillsOfferedRow['skillname']." (".$skillsOfferedRow['userskills_id'].")";?></strong>
        </p>
    </div>

<?php } ?>
        
    </div>
    
    <div class="columnBrowse">

<?php while ($skillsRequestedRow = $skillsRequested->fetch_assoc()) { ?>
                    
    <div class = "panel1">
        <p>Username: <?=$skillsRequestedRow['username']." (".$skillsRequestedRow['user_id'].")";?><br/>
        Name: <?=$skillsRequestedRow['firstname']." ".$skillsRequestedRow['lastname'];?><br/>
        Is requesting help with: <strong><?=$skillsRequestedRow['skillname']." (".$skillsRequestedRow['userskills_id'].")";?></strong>
        </p>
    </div>

<?php } ?>
        
        </div>
    
</div>

<br style="clear: both;" />

<?php require_once 'footer.php'; ?>