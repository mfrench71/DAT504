<?php

    require_once 'functions.php';

    $users = queryMysql("SELECT * FROM users");
    $userStats = $users->num_rows;

    $skillsOffered = queryMysql("SELECT * FROM userSkills WHERE skillOffered = 1");
    $skillsOfferedStats = $skillsOffered->num_rows;

    $skillsRequested = queryMysql("SELECT * FROM userSkills WHERE skillRequested = 1");
    $skillsRequestedStats = $skillsRequested->num_rows;

    echo "Community Users: <strong>" . $userStats . "</strong> | Skills Offered: <strong>" . $skillsOfferedStats . "</strong> | Skills Requested: <strong>" . $skillsRequestedStats . "</strong>";

?>