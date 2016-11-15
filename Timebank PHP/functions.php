<?php

    // Preferences
    $appname = "Time Bank";

    // MySQL details
    $db_hostname = 'localhost';
    $db_database = 'timebank';
    $db_username = 'root';
    $db_password = '';

    // Create database connection
    $connection = new mysqli($db_hostname,$db_username,$db_password,$db_database);

    // Check database connection
    if ($connection->connect_error) die ($connection->connect_error);

    // Function to query database
    function queryMysql($query) {
        global $connection;
        $result = $connection->query($query);
        if (!$result) die($connection->error);
        return $result;
    }

    // Destroy session and clear data - user logout
    function destroySession() {
        $_SESSION=array();
        if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');
        session_destroy();
    }
    
    // Remove potentially harmful code from user input
    function cleanString($var) {
        global $connection;
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        return $connection->real_escape_string($var);
    }
?>
