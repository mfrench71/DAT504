<?php

    require_once 'functions.php';

    // Number of users

    $users = queryMysql("SELECT * FROM users");
    $userStats = $users->num_rows;

    // Number of skills offered

    $skillsOffered = queryMysql("SELECT * FROM userSkills WHERE skillOffered = 1");
    $skillsOfferedStats = $skillsOffered->num_rows;

    // Number of skills requested

    $skillsRequested = queryMysql("SELECT * FROM userSkills WHERE skillRequested = 1");
    $skillsRequestedStats = $skillsRequested->num_rows;

    // Output formatted stats

    echo "Community Users: <strong>" . $userStats . "</strong> | Skills Offered: <strong>" . $skillsOfferedStats . "</strong> | Skills Requested: <strong>" . $skillsRequestedStats . "</strong>";

?>