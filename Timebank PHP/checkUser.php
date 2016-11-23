<?php

    require_once 'functions.php';

    // Has data been posted?
    // If yes, clean string and query database for supplied username

    if (isset($_POST['username'])) {
        
        $username = cleanString($_POST['username']);
        $result = queryMysql("SELECT * FROM users WHERE username='$username'");
        
    }

    // Is there a result?
    // If yes, the username already exists

    if ($result->num_rows) { ?>

            <div class = "my-notify-warning">This username is taken.</div>

    <!-- If no, the username is available -->

    <?php } else { ?>

            <div class = "my-notify-success">This username is available.</div>
    
    <?php } ?>
