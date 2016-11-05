<?php
    session_start();
    require_once 'functions.php';
    require_once 'meta.php';

    // Set default values

    $userstr = ' (Guest)';
    $creditBalanceStr = " (0)";
    
    // If user is logged in, set username and credit balance from session

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $creditBalance = $_SESSION['creditBalance'];
        $loggedin = TRUE;
        $userstr = " ($username)";
        $creditBalanceStr = " ($creditBalance)";
    
    }
        else $loggedin = FALSE;
    ?>
    
    <?=$appname . $userstr . " Credit Balance: " . $creditBalanceStr;?>

     <!-- If user is logged in, show logged in menu -->

    <?php if ($loggedin) { ?>
        
        <ul class='menu'>
            <li><a href='profile.php'>Edit Profile</a></li>
            <li><a href='logout.php'>Log out</a></li>
        </ul>

    <!--  If not logged in, show logged out menu and message -->

    <?php } else { ?>
        
        <ul class='menu'>
            <li><a href='index.php'>Home</a></li>
            <li><a href='signup.php'>Sign up</a></li>
            <li><a href='login.php'>Log in</a></li>
        </ul>

        <!-- <span class='info'>&#8658; You must be logged in to view this page.</span> -->
    
    <?php } ?>
