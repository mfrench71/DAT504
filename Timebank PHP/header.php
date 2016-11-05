<?php
    session_start();
    echo "<!DOCTYPE html>\n<html><head>";
    require_once 'functions.php';
    $userstr = ' (Guest)';
    $creditBalanceStr = " (0)";
    
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $creditBalance = $_SESSION['creditBalance'];
        $loggedin = TRUE;
        $userstr = " ($username)";
        $creditBalanceStr = " ($creditBalance)";
    
    }
        
        else $loggedin = FALSE;

        echo "<title>$appname$userstr</title>" .
        $appname . $userstr . " Credit Balance: " . $creditBalanceStr;

    if ($loggedin) {
        
        echo "<br ><ul class='menu'>" .
        "<li><a href='profile.php'>Edit Profile</a></li>" .
        "<li><a href='logout.php'>Log out</a></li></ul><br>";

    } else {
        
        echo ("<br><ul class='menu'>" .
        "<li><a href='index.php'>Home</a></li>" .
        "<li><a href='signup.php'>Sign up</a></li>" .
        "<li><a href='login.php'>Log in</a></li></ul><br>" .
        "<span class='info'>&#8658; You must be logged in to " .
        "view this page.</span><br><br>");
    }
?>