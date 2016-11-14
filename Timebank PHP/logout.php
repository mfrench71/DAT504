<?php

    require_once 'header.php';

    // Is the user logged in?
  
    if (isset($_SESSION['username'])) {
        
        // If yes, end session, clearing session variables
        
        destroySession(); 
        
        // Redirect to home page and display logout success message
        
        header("location: index.php?updateStatus=success&action=Logout"); ?>
  
    <?php } else { ?>

        <!-- If the user is not logged in i.e. they have accessed the logout page directly, display message -->

        <p>You cannot log out because you are not logged in.</p>

    <?php } ?>

<?php require_once 'footer.php'; ?>
