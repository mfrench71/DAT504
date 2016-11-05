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

            <p>&#x2718; This username is taken</p>

    <!-- If no, the username is available -->

    <?php } else { ?>

            <p>&#x2714; This username is available</p>
    
    <?php } ?>
