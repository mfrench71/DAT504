<?php require_once 'header.php'; ?>  
    
<p>Welcome to <?=$appname;?></p>

<?php if ($loggedin) {
    
    $user = queryMysql("SELECT * FROM users WHERE username = '$username'");
    $row = $user->fetch_assoc();
    $timeBalance = $row['timeBalance'];
    $creditBalance = $row['creditBalance'];
    
?>

    <p>You are logged in as <?=$username?>.</p>
    <p>Your Time Balance is: <?=$timeBalance?></p>
    <p>Your Credit Balance is: <?=$creditBalance?></p>

<?php } else { ?>

    <p>Please sign up and/or log in to join in.</p>

<?php } ?>

<?php require_once 'footer.php'; ?>
