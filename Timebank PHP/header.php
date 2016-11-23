<?php
    session_start();
    ob_start();
    require_once 'functions.php';
    require_once 'meta.php';
    
    // If username session variable is set then user is logged in
    // So set the username variable to the session variable value

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $loggedin = TRUE;
    
    }
        else $loggedin = FALSE;

    ?>

     <!-- If user is logged in, show logged in menu -->

    <?php if ($loggedin) { ?>
        
        <ul id ="headerMenu">
            <li><a href='index.php'><span class="fa fa-home fa-fw"></span> Home</a></li>
            <li><a href='about.php'><span class="fa fa-info-circle fa-fw"></span> About</a></li>
            <li><a href='browse.php'><span class="fa fa-list fa-fw"></span> Browse</a></li>
            <li><a href='profile.php'><span class="fa fa-user fa-fw"></span> Profile</a></li>
            <li><a href='logout.php'><span class="fa fa-sign-out fa-fw"></span> Log Out</a></li>
        </ul>

    <!--  If not logged in, show guest user menu -->

    <?php } else { ?>
        
        <ul id = "headerMenu">
            <li><a href='index.php'><span class="fa fa-home fa-fw"></span> Home</a></li>
            <li><a href='about.php'><span class="fa fa-info-circle fa-fw"></span> About</a></li>
            <li><a href='browse.php'><span class="fa fa-list fa-fw"></span> Browse</a></li>
            <li><a href='signup.php'><span class="fa fa-user-plus fa-fw"></span> Sign Up</a></li>
            <li><a href='login.php'><span class="fa fa-sign-in fa-fw"></span> Log In</a></li>
        </ul>

    <?php } ?>