<?php
    session_start();
    require_once 'functions.php';
    require_once 'meta.php';

    // Set default values

    $userstr = ' (Guest)';
    
    // If user is logged in, set username session

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $loggedin = TRUE;
        $userstr = " ($username)";
    
    }
        else $loggedin = FALSE;

    ?>
    
    <!-- <?=$appname?> -->

     <!-- If user is logged in, show logged in menu -->

    <?php if ($loggedin) { ?>
        
        <ul id ="headerMenu">
            <li><a href='index.php'>Home</a></li>
            <li><a href='logout.php'>Log Out</a></li>
            <li><a href="profile.php"><?=$userstr;?></a></li>
        </ul>

    <!--  If not logged in, show logged out menu and message -->

    <?php } else { ?>
        
        <ul id = "headerMenu">
            <li><a href='index.php'>Home</a></li>
            <li><a href='signup.php'>Sign Up</a></li>
            <li><a href='login.php'>Log In</a></li>
        </ul>

    <?php } ?>