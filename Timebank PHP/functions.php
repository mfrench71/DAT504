<?php

    // Preferences
    $appname = "Time Bank";

    // MySQL details
    $db_hostname = 'localhost';
    $db_database = 'timebank';
    $db_username = 'root';
    $db_password = '';

    // Create database connection object
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

    // Unset and destroy session variable - user logout
    function destroySession () {
        session_unset();
        session_destroy();
    }
    
    // Remove potentially harmful code from user input
    function cleanString($var) {
        global $connection;
        // Strip HTML
        $var = strip_tags($var);
        // Convert characters to entities e.g. '<' becomes '&lt'
        $var = htmlentities($var);
        // Strip slashes
        $var = stripslashes($var);
        // Escape characters in SQL string
        return $connection->real_escape_string($var);
    }
?>
