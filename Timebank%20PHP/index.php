<?php require_once 'header.php'; ?>
    
<p>Welcome to <?=$appname;?></p>

<?php if ($loggedin) { ?>
    <p>You are logged in as <?=$username?>.</p>
<?php } else { ?>
    <p>Please sign up and/or log in to join in.</p>
<?php } ?>

</body>
</html>