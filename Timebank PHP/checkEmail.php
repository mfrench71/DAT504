<?php

    require_once 'functions.php';

    // Has data been posted?
    // If yes, clean string and query database for supplied email

    if (isset($_POST['email'])) {
        
        $email = cleanString($_POST['email']);
        $result = queryMysql("SELECT email FROM users WHERE email='$email'");
        
    }

    // Is there a result?
    // If yes, the email already exists

    if ($result->num_rows) { ?>

            <div class = "my-notify-warning">An account with this email address already exists.</div>

    <!-- If no, the email is available -->

    <?php } ?>
