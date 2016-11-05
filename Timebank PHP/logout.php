<?php

    require_once 'header.php';
  
    if (isset($_SESSION['username'])) {
        
        destroySession(); ?>
        <p>You have been logged out. Please <a href='index.php'>click here</a> to return to the home page.</p>
  
    <?php } else { ?>

        <p>You cannot log out because you are not logged in.</p>

    <?php } ?>
