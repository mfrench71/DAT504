<?php require_once 'header.php';

$updateStatus = "";

// Success status message display
    
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
    
    // Get user's skill details from DB:
    
    // Logged in user: skills offered
    
    $skillsOffered = queryMysql("SELECT skills.id, skills.skillname FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE userskills.user_id = '$user_id' AND userskills.skillOffered = 1");
    
    // Logged in user: skills requested
    
    $skillsRequested = queryMysql("SELECT skills.id, skills.skillname, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE userskills.user_id = '$user_id' AND userskills.skillRequested = 1");
    
    // Display skill requests that match logged in user's skill offers
    
    $skillsRequestedMatched = queryMysql("SELECT users.*, skills.skillname, userskills.id AS userskills_id, userskills.timeOffered FROM users LEFT JOIN userskills ON users.id = userskills.user_id LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillRequested = 1 AND userskills.skill_id IN (SELECT skill_id FROM userskills WHERE user_id = '$user_id' AND skillOffered = 1)");
    
    // Direct offers from other users
    
    $directOffer = queryMysql("SELECT users.id AS user_id, username, firstname, lastname, skills.id AS skills_id, skills.skillname, userskills.id AS userskills_id FROM users LEFT JOIN userskills ON users.id = userskills.timeOfferedByUserId LEFT JOIN skills ON userskills.skill_id = skills.id WHERE skillRequested = 1 AND timeOffered = 1 AND userskills.timeOfferedByUserId IN (SELECT timeOfferedByUserId FROM userskills WHERE user_id = '$user_id' AND timeOffered = 1)");
    
    // Has offer form been submitted?
    // If yes, update userskills table

    if (isset($_POST['SubmitOffer'])) {
        $offer_user_skills_id = $_POST['offer_user_skills_id'];
        $offer_request_user_id = $_POST['offer_request_user_id'];
        
        queryMysql("UPDATE userskills SET timeOffered = 1, timeOfferedByUserId = '$user_id' WHERE id = '$offer_user_skills_id' AND user_id = '$offer_request_user_id'");
        
        header("location: index.php?updateStatus=success&action=Offer");;
    }
    
    // Has the ACCEPT direct offer form been submitted?
    // If yes, update the userskills table
    
    if (isset($_POST['AcceptDirectOffer'])) {
        
        $accept_direct_offer_user_id = $_POST['accept_direct_offer_user_id'];
        $accept_direct_offer_userskills_id = $_POST['accept_direct_offer_userskills_id'];
        
        // Logged in user no longer needs the skill they accepted so set this to 0
        queryMysql("UPDATE userskills SET skillRequested = 0, timeAccepted = 1, timeAcceptedByUserId = '$user_id' WHERE id = '$accept_direct_offer_userskills_id'");
        
        // Subtract one credit from logged in user
        queryMysql("UPDATE users SET timeBalance = timeBalance -1 WHERE id = '$user_id'");
        
        // Add one credit to user whose offer was accepted
        queryMysql("UPDATE users SET timeBalance = timeBalance + 1 WHERE id = '$accept_direct_offer_user_id'");
        
        // Refresh page
        
        header("location: index.php?updateStatus=success&action=Accept");
    }
    
    // Has the REJECT direct offer form been submitted?
    // If yes, update the userskills table
    
    if (isset($_POST['RejectDirectOffer'])) {
        
        $reject_direct_offer_user_id = $_POST['reject_direct_offer_user_id'];
        $reject_direct_offer_userskills_id = $_POST['reject_direct_offer_userskills_id'];
        
        // Reset offer values
        queryMysql("UPDATE userskills SET timeOffered = 0, timeOfferedByUserId = 0 WHERE id = '$reject_direct_offer_userskills_id'");
        
        // Refresh page
        
        header("location: index.php?updateStatus=success&action=Reject");
    }
    
?>

<!-- Content Layout -->

<div class="container">
    
    <h1><span class="fa fa-home fa-fw"></span> Welcome to <?=$appname;?></h1>
    
    <div class="column">
        
        <div class = "panel0">
        
        <h3>Your Profile Summary</h3>
            <p><span class="fa fa-user-circle fa-fw"></span> You are logged in as <?=$username?></p> 
        
            <p><span class="fa fa-money fa-fw"></span> Your Time Balance (Credit) is: <?=$timeBalance?></p>
            
            <?php
        
                // Time credit notifications
        
                if($timeBalance > 0 && $timeBalance <= 2) {
                    echo "<div class = 'my-notify-warning'>Your time credit is low! Why not offer some time?</div>";
                } elseif ($timeBalance == 0) {
                    echo "<div class = 'my-notify-error'>You have no time credit!.</div>";
                }
            ?>
            
            <hr />
            
            <h3>These are your skills:</h3>
            
            <!-- If user has skills to offer, display them -->
            
             <?php if(mysqli_num_rows($skillsOffered) > 0) { ?>

                <ul id="userSkills">
                    <?php while ($skillsOfferedRow = $skillsOffered->fetch_assoc()) { ?>
                    <li><?=$skillsOfferedRow['skillname']?></li>
                    <?php } ?>
                </ul>
            
            <!-- Otherwise, display info message -->
            
            <?php } else {
            
                echo "<div class = 'my-notify-info'>You currently have no skills to offer.</div>";
            
             } ?>
            
            <hr />

            <h3>This is the help you need:</h3>
            
            <!-- If user has skills they need, display them -->
            
            <?php if(mysqli_num_rows($skillsRequested) > 0) { ?>

            <ul>
                <?php while ($skillsRequestedRow = $skillsRequested->fetch_assoc()) { ?>
                    <li><?=$skillsRequestedRow['skillname']?></li>
                <?php } ?> 
            </ul>

            <!-- Otherwise, display info message -->
            
            <?php } else {
            
                echo "<div class = 'my-notify-info'>You currently have no skills requested.</div>";
            
             } ?>
            
            </div>
       
    </div>
    
    <div class="column">
        
        <!-- Community Skills Needed -->
        
        <h3>Community Skills Requested:</h3>
            
            <!-- If user has skills needed by other users, display those users and skills required -->
            
            <?php if(mysqli_num_rows($skillsRequestedMatched) > 0) { ?>
            
                <p>These members need your skills!<br />Earn Credits by offering your time to these community members:</p>
                <?php while ($skillsRequestedMatchedRow = $skillsRequestedMatched->fetch_assoc()) { ?>
                    
                    <div class = "panel">
                    <p><span class="fa fa-user-circle fa-fw"></span> <?=$skillsRequestedMatchedRow['username']?><br/>
                    Name: <?=$skillsRequestedMatchedRow['firstname']." ".$skillsRequestedMatchedRow['lastname'];?><br/>
                    Would like help with: <strong><?=$skillsRequestedMatchedRow['skillname']?></strong>
                    </p>
                        
                    <!-- If user has pending offers, display them with a notificatoin and hide the Offer button -->
                        
                    <?php if ($skillsRequestedMatchedRow['timeOffered']) { ?>
                        
                        <p class="my-notify-success"><?=$skillsRequestedMatchedRow['firstname']?> has received an offer of help with <?=$skillsRequestedMatchedRow['skillname']?> but has yet to accept it.</p>
                        
                    <?php } else { ?>
            
                    <!-- Submit Offer Form -->
            
                    <form action="index.php" method="post" name="form1" id="form1">
                      <input type="submit" class="modern" name="SubmitOffer" id="submit" value="Offer 1 Hour">
                      <input type="hidden" name="offer_request_user_id" value=<?=$skillsRequestedMatchedRow['id']?>>
                      <input type="hidden" name="offer_user_skills_id" value=<?=$skillsRequestedMatchedRow['userskills_id']?>>
                    </form>
                        
                    <?php } ?>
                     
                    </div>
                        
                <?php } ?>
            
            <!-- Otherwise, display info message -->
            
            <?php } else {
            
                echo "<div class = 'my-notify-info'>There are currently no members who need your skills.</div>";
            
             } ?>
        
    </div>
    
    <div class="column">
        
        <!-- Community Skills Offered -->
        
        <h3>Community Skills Offered:</h3>
            
           <!-- If user has direct offers of help from other users, display them -->
            
            <?php if(mysqli_num_rows($directOffer) > 0) { ?>
            
                <p>You've received these direct offers of help from members of the Timebank community:</p>

                <?php while ($directOfferRow = $directOffer->fetch_assoc()) { ?>
        
                    <div class = "panel1">

                    <p><span class="fa fa-user-circle-o fa-fw"></span> <?=$directOfferRow['username']?><br/>
                        Name: <?=$directOfferRow['firstname']." ".$directOfferRow['lastname'];?><br/>
                        Offered help with: <strong><?=$directOfferRow['skillname'];?></strong>
                    </p>

                    <?php if($timeBalance > 0) { ?>
            
                        <!-- If user has credit, show Accept Offer button -->
        
                        <div id = "buttonLeft">

                        <form action="index.php" method="post" name="form1" id="form1">
                            <input type="submit" class="modern" name="AcceptDirectOffer" id="submit" value="Accept Offer">
                            <input type="hidden" name="accept_direct_offer_user_id" value=<?=$directOfferRow['user_id']?>>
                            <input type="hidden" name="accept_direct_offer_userskills_id" value=<?=$directOfferRow['userskills_id']?>>
                        </form>
                            
                        </div>

                        <?php } else { ?>
                            <!-- Otherwise show warning -->
                            <div class ="my-notify-warning">
                                Earn credits to accept offers!
                            </div>            
                        <?php } ?>
        
                        <!-- Reject Offer button -->
        
                        <div id = "buttonRight">
        
                        <form action="index.php" method="post" name="form1" id="form1">
                            <input type="submit" class="modernYellow" name="RejectDirectOffer" id="submit" value="No Thanks">
                            <input type="hidden" name="reject_direct_offer_user_id" value=<?=$directOfferRow['user_id']?>>
                            <input type="hidden" name="reject_direct_offer_userskills_id" value=<?=$directOfferRow['userskills_id']?>>
                        </form>
                        
                        </div>
                        
                    </div>

                <?php } ?>
            
                <!-- Otherwise, display info message -->
            
                <?php } else {
            
                    echo "<div class = 'my-notify-info'>You have not received any offers of help yet.</div>";
            
                } ?>
        
    </div>

</div>

<br style="clear:both;"/>

<!-- If user is not logged in, display info message -->

<?php } else { ?>

    <div class = "my-notify-info">Please <a href="signup.php">sign up</a> or <a href="login.php">log in</a> to join our community.</div>

<?php } ?>

<?php require_once 'footer.php'; ?>