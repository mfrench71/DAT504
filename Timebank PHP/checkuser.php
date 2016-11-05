<?php
require_once 'functions.php';
if (isset($_POST['username']))
{
$username = cleanString($_POST['username']);
$result = queryMysql("SELECT * FROM users WHERE username='$username'");
if ($result->num_rows)
echo "&nbsp;&#x2718; " .
"This username is taken";
else
echo "&nbsp;&#x2714; " .
"This username is available";
}
?>